<?php
/**
 * MISSION KIDS — Mission Progress & Execution Service
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/GamificationService.php';
require_once __DIR__ . '/PuzzleValidatorService.php';

class MissionProgressService
{
    private PDO $db;
    private GamificationService $gamification;
    private PuzzleValidatorService $puzzleValidator;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->gamification = new GamificationService();
        $this->puzzleValidator = new PuzzleValidatorService();
    }

    public function getWorldsWithProgress(int $userId): array
    {
        $worlds = $this->db->query("SELECT * FROM worlds WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();

        foreach ($worlds as &$w) {
            // Get missions in world
            $stmtM = $this->db->prepare("SELECT m.id, m.slug, m.title, m.subtitle, m.learning_objective, m.interaction_type, m.xp_reward, m.sort_order,
                COALESCE(mp.status, (CASE WHEN m.sort_order = 1 THEN 'available' ELSE 'locked' END)) as progress_status,
                COALESCE(mp.stars, 0) as stars
                FROM missions m
                LEFT JOIN mission_progress mp ON m.id = mp.mission_id AND mp.user_id = :uid
                WHERE m.world_id = :wid AND m.is_active = 1
                ORDER BY m.sort_order ASC");
            $stmtM->execute([':uid' => $userId, ':wid' => $w['id']]);
            $w['missions'] = $stmtM->fetchAll();

            $totalMissions = count($w['missions']);
            $completedMissions = 0;
            foreach ($w['missions'] as $m) {
                if ($m['progress_status'] === 'completed') {
                    $completedMissions++;
                }
            }

            $w['total_missions'] = $totalMissions;
            $w['completed_missions'] = $completedMissions;
            $w['progress_percent'] = $totalMissions > 0 ? (int)round(($completedMissions / $totalMissions) * 100) : 0;
        }

        return $worlds;
    }

    public function getMissionBySlug(string $slug, int $userId): ?array
    {
        $stmt = $this->db->prepare("SELECT m.*, w.title as world_title, w.slug as world_slug, w.theme_color,
            COALESCE(mp.status, (CASE WHEN m.sort_order = 1 THEN 'available' ELSE 'locked' END)) as progress_status,
            COALESCE(mp.stars, 0) as stars
            FROM missions m
            JOIN worlds w ON m.world_id = w.id
            LEFT JOIN mission_progress mp ON m.id = mp.mission_id AND mp.user_id = :uid
            WHERE m.slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $slug, ':uid' => $userId]);
        $mission = $stmt->fetch();

        if (!$mission) {
            return null;
        }

        // Count previous attempts
        $stmtAtt = $this->db->prepare("SELECT COUNT(*) FROM mission_attempts WHERE user_id = :uid AND mission_id = :mid");
        $stmtAtt->execute([':uid' => $userId, ':mid' => $mission['id']]);
        $mission['attempt_count'] = (int)$stmtAtt->fetchColumn();

        $mission['config'] = json_decode($mission['config_json'], true) ?: [];

        return $mission;
    }

    public function getMissionById(int $missionId): ?array
    {
        $stmt = $this->db->prepare("SELECT m.*, w.id as world_id, w.title as world_title, w.slug as world_slug 
            FROM missions m 
            JOIN worlds w ON m.world_id = w.id 
            WHERE m.id = :id AND m.is_active = 1 LIMIT 1");
        $stmt->execute([':id' => $missionId]);
        $res = $stmt->fetch();
        return $res ?: null;
    }

    public function isMissionAvailable(int $userId, array $mission): bool
    {
        $missionId = (int)$mission['id'];
        $sortOrder = (int)$mission['sort_order'];
        $worldId = (int)$mission['world_id'];

        // 1. Check existing progress status for this user & mission
        $stmtProg = $this->db->prepare("SELECT status FROM mission_progress WHERE user_id = :uid AND mission_id = :mid LIMIT 1");
        $stmtProg->execute([':uid' => $userId, ':mid' => $missionId]);
        $prog = $stmtProg->fetch();

        if ($prog) {
            if (in_array($prog['status'], ['available', 'completed'], true)) {
                return true;
            }
            if ($prog['status'] === 'locked') {
                return false;
            }
        }

        // 2. Mission with sort_order = 1 is always available as entry point of world
        if ($sortOrder === 1) {
            return true;
        }

        // 3. For sort_order > 1, prerequisite is previous mission in same world being completed
        $stmtPrev = $this->db->prepare("SELECT mp.status 
            FROM missions m_prev
            JOIN mission_progress mp ON m_prev.id = mp.mission_id AND mp.user_id = :uid
            WHERE m_prev.world_id = :wid 
              AND m_prev.sort_order = :prev_order
              AND mp.status = 'completed'
            LIMIT 1");
        $stmtPrev->execute([
            ':uid' => $userId,
            ':wid' => $worldId,
            ':prev_order' => $sortOrder - 1
        ]);
        $prevCompleted = $stmtPrev->fetch();

        return !empty($prevCompleted);
    }

    public function recordAttempt(int $userId, int $missionId, int $hintsUsed, bool $isSuccess, ?string $reflectionAnswer = null): void
    {
        $stmt = $this->db->prepare("INSERT INTO mission_attempts (user_id, mission_id, hints_used, is_success, reflection_answer) VALUES (:uid, :mid, :hints, :success, :ref)");
        $stmt->execute([
            ':uid' => $userId,
            ':mid' => $missionId,
            ':hints' => $hintsUsed,
            ':success' => $isSuccess ? 1 : 0,
            ':ref' => $reflectionAnswer
        ]);
    }

    public function completeMission(int $userId, int $missionId, int $hintsUsed, ?string $reflectionAnswer = null, ?array $solutionPayload = null): array
    {
        // 1. Fetch mission details
        $mission = $this->getMissionById($missionId);

        if (!$mission) {
            return ['success' => false, 'error' => 'Misi tidak ditemukan.'];
        }

        // 2. Enforce Prerequisite Validation (Anti-State Progression Bypass)
        if (!$this->isMissionAvailable($userId, $mission)) {
            return [
                'success' => false,
                'error' => 'Misi ini masih terkunci! Selesaikan misi sebelumnya terlebih dahulu ya.'
            ];
        }

        // 3. Enforce Server-Side Puzzle Solution Validation (Anti-Solution Tampering)
        $validation = $this->puzzleValidator->validate($mission['slug'], $solutionPayload, $mission['config_json']);
        if (!$validation['valid']) {
            // Record failed attempt to prevent first-try bonus exploitation and track attempts accurately
            $this->recordAttempt($userId, $missionId, $hintsUsed, false, $reflectionAnswer);
            return [
                'success' => false,
                'error' => $validation['message'],
                'validation_failed' => true
            ];
        }

        // 4. Validate Reflection Answer against config
        $isReflectionValid = $this->puzzleValidator->validateReflection($mission['config_json'], $reflectionAnswer);

        $this->db->beginTransaction();
        try {
            // 5. Serialize reward execution per user by locking their existing profile row
            $isMysql = (Database::getDriverUsed() === 'mysql');
            $lockSql = "SELECT id, total_xp, current_level FROM profiles WHERE user_id = :uid" . ($isMysql ? " FOR UPDATE" : "");
            $stmtLock = $this->db->prepare($lockSql);
            $stmtLock->execute([':uid' => $userId]);
            $lockedProfile = $stmtLock->fetch();

            if (!$lockedProfile) {
                $this->db->rollBack();
                return ['success' => false, 'error' => 'Profil pengguna tidak ditemukan.'];
            }

            // 6. Under serialized lock, re-read fresh state of mission completion
            $stmtProg = $this->db->prepare("SELECT status, stars FROM mission_progress WHERE user_id = :uid AND mission_id = :mid LIMIT 1");
            $stmtProg->execute([':uid' => $userId, ':mid' => $missionId]);
            $existing = $stmtProg->fetch();
            $isFirstClear = empty($existing) || $existing['status'] !== 'completed';

            // 7. Count prior attempts for bonus calculation (before recording current success)
            $stmtAttCount = $this->db->prepare("SELECT COUNT(*) FROM mission_attempts WHERE user_id = :uid AND mission_id = :mid");
            $stmtAttCount->execute([':uid' => $userId, ':mid' => $missionId]);
            $priorAttempts = (int)$stmtAttCount->fetchColumn();

            // Star calculation: 3 stars if hints <= 1, 2 stars if hints == 2, 1 star if hints >= 3
            $hintsUsed = max(0, $hintsUsed);
            $stars = 3;
            if ($hintsUsed === 2) $stars = 2;
            if ($hintsUsed >= 3) $stars = 1;

            // Record this successful attempt
            $this->recordAttempt($userId, $missionId, $hintsUsed, true, $reflectionAnswer);

            // Update / Insert mission_progress
            if (Database::getDriverUsed() === 'sqlite') {
                $stmtSave = $this->db->prepare("INSERT INTO mission_progress (user_id, mission_id, status, stars, completed_at)
                    VALUES (:uid, :mid, 'completed', :stars, CURRENT_TIMESTAMP)
                    ON CONFLICT(user_id, mission_id) DO UPDATE SET status = 'completed', stars = MAX(stars, excluded.stars), completed_at = CURRENT_TIMESTAMP");
            } else {
                $stmtSave = $this->db->prepare("INSERT INTO mission_progress (user_id, mission_id, status, stars, completed_at) 
                    VALUES (:uid, :mid, 'completed', :stars, NOW())
                    ON DUPLICATE KEY UPDATE status = 'completed', stars = GREATEST(stars, VALUES(stars)), completed_at = COALESCE(completed_at, VALUES(completed_at))");
            }
            $stmtSave->execute([':uid' => $userId, ':mid' => $missionId, ':stars' => $stars]);

            // Unlock next mission in the same world
            $stmtNext = $this->db->prepare("SELECT id FROM missions WHERE world_id = :wid AND sort_order = :next_order LIMIT 1");
            $stmtNext->execute([':wid' => $mission['world_id'], ':next_order' => ((int)$mission['sort_order'] + 1)]);
            $nextMission = $stmtNext->fetch();
            if ($nextMission) {
                if (Database::getDriverUsed() === 'sqlite') {
                    $stmtUnlock = $this->db->prepare("INSERT INTO mission_progress (user_id, mission_id, status) VALUES (:uid, :mid, 'available')
                        ON CONFLICT(user_id, mission_id) DO UPDATE SET status = CASE WHEN status = 'locked' THEN 'available' ELSE status END");
                } else {
                    $stmtUnlock = $this->db->prepare("INSERT INTO mission_progress (user_id, mission_id, status) VALUES (:uid, :mid, 'available')
                        ON DUPLICATE KEY UPDATE status = CASE WHEN status = 'locked' THEN 'available' ELSE status END");
                }
                $stmtUnlock->execute([':uid' => $userId, ':mid' => $nextMission['id']]);
            }

            // 8. Calculate XP rewards
            $xpBreakdown = [];
            $totalAwarded = 0;

            if ($isFirstClear) {
                // Base mission clear XP
                $baseXp = (int)$mission['xp_reward'];
                $xpClear = $this->gamification->awardXp($userId, $baseXp, 'mission_clear', $missionId);
                if ($xpClear['awarded'] > 0) {
                    $xpBreakdown[] = ['label' => 'Misi Selesai!', 'amount' => $xpClear['awarded']];
                    $totalAwarded += $xpClear['awarded'];
                }

                // First attempt bonus (solved without failing)
                if ($priorAttempts === 0) {
                    $xpBonus = $this->gamification->awardXp($userId, 50, 'first_try_bonus', $missionId);
                    if ($xpBonus['awarded'] > 0) {
                        $xpBreakdown[] = ['label' => 'Bonus Hebat (Sekali Coba)', 'amount' => $xpBonus['awarded']];
                        $totalAwarded += $xpBonus['awarded'];
                    }
                }

                // Reflection bonus (only awarded if student answered correctly)
                if ($isReflectionValid) {
                    $xpRef = $this->gamification->awardXp($userId, 30, 'reflection_bonus', $missionId);
                    if ($xpRef['awarded'] > 0) {
                        $xpBreakdown[] = ['label' => 'Bonus Refleksi Belajar', 'amount' => $xpRef['awarded']];
                        $totalAwarded += $xpRef['awarded'];
                    }
                }
            } else {
                // Replay reward: capped at max 3 times per mission to prevent farming
                $stmtReplayToday = $this->db->prepare("SELECT COUNT(*) FROM xp_transactions 
                    WHERE user_id = :uid AND source_type = 'mission_replay' AND reference_id = :mid");
                $stmtReplayToday->execute([':uid' => $userId, ':mid' => $missionId]);
                $replaysDone = (int)$stmtReplayToday->fetchColumn();

                if ($replaysDone < 3) {
                    $practiceXp = 25;
                    $xpReplay = $this->gamification->awardXp($userId, $practiceXp, 'mission_replay', $missionId);
                    if ($xpReplay['awarded'] > 0) {
                        $xpBreakdown[] = ['label' => 'Latihan Ulang (' . ($replaysDone + 1) . '/3)', 'amount' => $xpReplay['awarded']];
                        $totalAwarded += $xpReplay['awarded'];
                    }
                } else {
                    $xpBreakdown[] = ['label' => 'Latihan Selesai (Batas Bonus Tercapai)', 'amount' => 0];
                }
            }

            // 9. Check for any newly unlocked achievements
            $newAchievements = $this->gamification->checkAndUnlockAchievements($userId);

            // 10. Get updated profile level info
            $stmtProf = $this->db->prepare("SELECT total_xp FROM profiles WHERE user_id = :uid LIMIT 1");
            $stmtProf->execute([':uid' => $userId]);
            $currentTotalXp = (int)$stmtProf->fetchColumn();
            $levelInfo = $this->gamification->calculateLevel($currentTotalXp);

            $this->db->commit();

            return [
                'success' => true,
                'stars' => $stars,
                'is_first_clear' => $isFirstClear,
                'total_awarded_xp' => $totalAwarded,
                'xp_breakdown' => $xpBreakdown,
                'new_achievements' => $newAchievements,
                'level_info' => $levelInfo,
                'next_mission_unlocked' => !empty($nextMission),
            ];
        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Failed to complete mission [user: {$userId}, mission: {$missionId}]: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Gagal menyimpan progres misi: ' . $e->getMessage()
            ];
        }
    }
}
