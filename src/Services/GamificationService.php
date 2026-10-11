<?php
/**
 * MISSION KIDS — Gamification, Level & Achievement Service
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

class GamificationService
{
    private PDO $db;
    private array $levels;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $config = require __DIR__ . '/../../config/config.php';
        $this->levels = $config['gamification']['levels'];
    }

    public function calculateLevel(int $totalXp): array
    {
        $currentLevel = 1;
        $levelInfo = $this->levels[1];

        foreach ($this->levels as $lvl => $info) {
            if ($totalXp >= $info['min_xp']) {
                $currentLevel = $lvl;
                $levelInfo = $info;
            }
        }

        $nextLevel = $currentLevel < 5 ? $currentLevel + 1 : 5;
        $nextInfo = $this->levels[$nextLevel];

        $xpInCurrentLevel = $totalXp - $levelInfo['min_xp'];
        $span = max(1, $nextInfo['min_xp'] - $levelInfo['min_xp']);
        $progressPercent = $currentLevel === 5 ? 100 : min(100, (int)round(($xpInCurrentLevel / $span) * 100));

        return [
            'level' => $currentLevel,
            'name' => $levelInfo['name'],
            'badge' => $levelInfo['badge'],
            'total_xp' => $totalXp,
            'current_xp' => $totalXp,
            'next_level' => $nextLevel,
            'next_min_xp' => $nextInfo['min_xp'],
            'progress_percent' => $progressPercent,
        ];
    }

    public function awardXp(int $userId, int $amount, string $sourceType, ?int $refId = null): array
    {
        // 1. Idempotency protection for one-time reward types (mission_clear, first_try_bonus, reflection_bonus, achievement_unlock)
        if (in_array($sourceType, ['mission_clear', 'first_try_bonus', 'reflection_bonus', 'achievement_unlock'], true)) {
            $stmtCheck = $this->db->prepare("SELECT id FROM xp_transactions WHERE user_id = :uid AND source_type = :src AND reference_id = :ref LIMIT 1");
            $stmtCheck->execute([
                ':uid' => $userId,
                ':src' => $sourceType,
                ':ref' => $refId
            ]);
            if ($stmtCheck->fetch()) {
                // Idempotent duplicate: reward already exists in database, do not double award!
                $stmtCur = $this->db->prepare("SELECT total_xp, current_level FROM profiles WHERE user_id = :uid LIMIT 1");
                $stmtCur->execute([':uid' => $userId]);
                $cur = $stmtCur->fetch();
                $curXp = $cur ? (int)$cur['total_xp'] : 0;
                $curLvl = $cur ? (int)$cur['current_level'] : 1;
                return [
                    'old_xp' => $curXp,
                    'new_xp' => $curXp,
                    'awarded' => 0,
                    'duplicate_prevented' => true,
                    'old_level' => $curLvl,
                    'new_level' => $curLvl,
                    'leveled_up' => false,
                    'level_info' => $this->calculateLevel($curXp)
                ];
            }
        }

        // 2. Record transaction in xp_transactions
        $stmtTx = $this->db->prepare("INSERT INTO xp_transactions (user_id, amount, source_type, reference_id) VALUES (:uid, :amount, :src, :ref)");
        $stmtTx->execute([
            ':uid' => $userId,
            ':amount' => $amount,
            ':src' => $sourceType,
            ':ref' => $refId
        ]);

        // 3. Atomic increment on profiles.total_xp (eliminates lost-update race condition)
        $stmtUp = $this->db->prepare("UPDATE profiles SET total_xp = total_xp + :amount WHERE user_id = :uid");
        $stmtUp->execute([
            ':amount' => $amount,
            ':uid' => $userId
        ]);

        // 4. Fetch fresh atomic total_xp and recalculate level
        $stmtFresh = $this->db->prepare("SELECT total_xp, current_level FROM profiles WHERE user_id = :uid LIMIT 1");
        $stmtFresh->execute([':uid' => $userId]);
        $fresh = $stmtFresh->fetch();
        $newXp = $fresh ? (int)$fresh['total_xp'] : $amount;
        $oldLvl = $fresh ? (int)$fresh['current_level'] : 1;
        $oldXp = $newXp - $amount;

        $newLevelData = $this->calculateLevel($newXp);
        $newLvl = $newLevelData['level'];

        if ($newLvl !== $oldLvl) {
            $stmtLvl = $this->db->prepare("UPDATE profiles SET current_level = :lvl WHERE user_id = :uid");
            $stmtLvl->execute([':lvl' => $newLvl, ':uid' => $userId]);
        }

        $leveledUp = $newLvl > $oldLvl;

        return [
            'old_xp' => $oldXp,
            'new_xp' => $newXp,
            'awarded' => $amount,
            'duplicate_prevented' => false,
            'old_level' => $oldLvl,
            'new_level' => $newLvl,
            'leveled_up' => $leveledUp,
            'level_info' => $newLevelData
        ];
    }

    public function checkAndUnlockAchievements(int $userId): array
    {
        $newlyUnlocked = [];

        // 1. Total completed missions
        $stmtComp = $this->db->prepare("SELECT COUNT(*) FROM mission_progress WHERE user_id = :uid AND status = 'completed'");
        $stmtComp->execute([':uid' => $userId]);
        $totalCompleted = (int)$stmtComp->fetchColumn();

        // 2. Completed missions per world
        $stmtWorldComp = $this->db->prepare("SELECT w.id, w.slug, COUNT(mp.id) as completed_count, COUNT(m.id) as total_missions 
            FROM worlds w 
            JOIN missions m ON w.id = m.world_id 
            LEFT JOIN mission_progress mp ON m.id = mp.mission_id AND mp.user_id = :uid AND mp.status = 'completed'
            GROUP BY w.id");
        $stmtWorldComp->execute([':uid' => $userId]);
        $worldStats = $stmtWorldComp->fetchAll();

        // Fetch all achievements
        $achievements = $this->db->query("SELECT * FROM achievements")->fetchAll();

        // Check each
        foreach ($achievements as $ach) {
            // Already unlocked?
            $stmtHas = $this->db->prepare("SELECT id FROM user_achievements WHERE user_id = :uid AND achievement_id = :aid LIMIT 1");
            $stmtHas->execute([':uid' => $userId, ':aid' => $ach['id']]);
            if ($stmtHas->fetch()) {
                continue;
            }

            $unlocked = false;

            if ($ach['criteria_type'] === 'total_missions' && $totalCompleted >= (int)$ach['criteria_threshold']) {
                $unlocked = true;
            } elseif ($ach['criteria_type'] === 'world_complete') {
                $targetWorldId = (int)$ach['criteria_threshold'];
                foreach ($worldStats as $ws) {
                    if ((int)$ws['id'] === $targetWorldId && (int)$ws['completed_count'] >= (int)$ws['total_missions'] && (int)$ws['total_missions'] > 0) {
                        $unlocked = true;
                        break;
                    }
                }
            }

            if ($unlocked) {
                $stmtIns = $this->db->prepare("INSERT INTO user_achievements (user_id, achievement_id) VALUES (:uid, :aid)");
                $stmtIns->execute([':uid' => $userId, ':aid' => $ach['id']]);

                // Award achievement bonus XP
                $xpRes = $this->awardXp($userId, (int)$ach['xp_reward'], 'achievement_unlock', (int)$ach['id']);
                $ach['bonus_xp'] = (int)$ach['xp_reward'];
                $newlyUnlocked[] = $ach;
            }
        }

        return $newlyUnlocked;
    }

    public function getUserAchievements(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT a.*, ua.unlocked_at, (CASE WHEN ua.id IS NOT NULL THEN 1 ELSE 0 END) as is_unlocked
            FROM achievements a
            LEFT JOIN user_achievements ua ON a.id = ua.achievement_id AND ua.user_id = :uid
            ORDER BY a.id ASC");
        $stmt->execute([':uid' => $userId]);
        return $stmt->fetchAll();
    }

    public function getSkillProgress(int $userId): array
    {
        // Skill dimensions:
        // 1. Numerasi (Number City)
        // 2. Sains Alam (Discovery Lab)
        // 3. Logika Komputasi (Thinking Lab)
        // 4. Problem Solving (Attempts & reflections)

        $stmt = $this->db->prepare("SELECT w.slug, COUNT(m.id) as total_missions, 
            COUNT(CASE WHEN mp.status = 'completed' THEN 1 END) as completed_missions
            FROM worlds w
            JOIN missions m ON w.id = m.world_id
            LEFT JOIN mission_progress mp ON m.id = mp.mission_id AND mp.user_id = :uid
            GROUP BY w.id");
        $stmt->execute([':uid' => $userId]);
        $rows = $stmt->fetchAll();

        $skills = [
            'numeracy' => ['title' => 'Numerasi & Pola', 'icon' => '🧮', 'percent' => 0],
            'science' => ['title' => 'Pemikiran Ilmiah & Sains', 'icon' => '🔬', 'percent' => 0],
            'logic' => ['title' => 'Logika & Algoritma', 'icon' => '🤖', 'percent' => 0],
            'problem_solving' => ['title' => 'Pemecahan Masalah', 'icon' => '💡', 'percent' => 0],
        ];

        $totalCompletedAll = 0;
        foreach ($rows as $r) {
            $total = max(1, (int)$r['total_missions']);
            $comp = (int)$r['completed_missions'];
            $totalCompletedAll += $comp;
            $pct = (int)round(($comp / $total) * 100);

            if ($r['slug'] === 'number-city') $skills['numeracy']['percent'] = $pct;
            if ($r['slug'] === 'discovery-lab') $skills['science']['percent'] = $pct;
            if ($r['slug'] === 'thinking-lab') $skills['logic']['percent'] = $pct;
        }

        // Overall problem solving journey: scaled across 9 missions
        $skills['problem_solving']['percent'] = min(100, (int)round(($totalCompletedAll / 9) * 100));

        return $skills;
    }
}
