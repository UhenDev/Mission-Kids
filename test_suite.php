<?php
/**
 * MISSION KIDS — Comprehensive Automated Test Suite
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Services/AuthService.php';
require_once __DIR__ . '/src/Services/MissionProgressService.php';
require_once __DIR__ . '/src/Services/GamificationService.php';
require_once __DIR__ . '/src/Services/MikoAiService.php';

echo "\n==========================================\n";
echo "  MISSION KIDS AUTOMATED TEST SUITE\n";
echo "==========================================\n\n";

$testsPassed = 0;
$totalTests = 0;

function assertTest(string $name, bool $condition, string $details = ''): void {
    global $testsPassed, $totalTests;
    $totalTests++;
    if ($condition) {
        $testsPassed++;
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name} - {$details}\n";
    }
}

// 1. Database & Driver
try {
    $pdo = Database::getConnection();
    $driver = Database::getDriverUsed();
    assertTest("Database Connection", $pdo instanceof PDO, "Driver: {$driver}");
    
    $worldCount = (int)$pdo->query("SELECT COUNT(*) FROM worlds")->fetchColumn();
    assertTest("Seeded Worlds Count", $worldCount === 3, "Found: {$worldCount}");

    $missionCount = (int)$pdo->query("SELECT COUNT(*) FROM missions")->fetchColumn();
    assertTest("Seeded Missions Count", $missionCount === 9, "Found: {$missionCount}");

    $achCount = (int)$pdo->query("SELECT COUNT(*) FROM achievements")->fetchColumn();
    assertTest("Seeded Badges Count", $achCount === 5, "Found: {$achCount}");
} catch (Exception $e) {
    assertTest("Database Initial Check", false, $e->getMessage());
}

// 2. AuthService Tests
$auth = new AuthService();
$testUser = 'test_student_' . time();
$reg = $auth->register($testUser, 'test1234', 'Siswa Hebat', 'super_bear');
assertTest("Auth: Student Registration", $reg['success'] === true, $reg['error'] ?? '');
$testUserId = (int)($reg['user_id'] ?? 0);

$login = $auth->login($testUser, 'test1234');
assertTest("Auth: Student Login", $login['success'] === true, $login['error'] ?? '');

$prof = $auth->getStudentProfile($testUserId);
assertTest("Auth: Profile Retrieval", !empty($prof) && $prof['nickname'] === 'Siswa Hebat');

// 3. MIKO AI Service Tests
$miko = new MikoAiService();
$hint1 = $miko->getScaffoldedHint('tanaman-layu', 1, 1, ['water' => 20], 'Siswa Hebat');
assertTest("MIKO: Scaffolded Hint Level 1", $hint1['success'] === true && !empty($hint1['hint_text']));

$hint2 = $miko->getScaffoldedHint('tanaman-layu', 2, 2, ['water' => 20], 'Siswa Hebat');
assertTest("MIKO: Scaffolded Hint Level 2", $hint2['success'] === true && !empty($hint2['hint_text']));

$hint3 = $miko->getScaffoldedHint('tanaman-layu', 3, 3, ['water' => 20], 'Siswa Hebat');
assertTest("MIKO: Scaffolded Hint Level 3", $hint3['success'] === true && !empty($hint3['hint_text']));

// 4. Mission Gameplay & Progress Service Tests
$progressService = new MissionProgressService();
$mission = $progressService->getMissionBySlug('tanaman-layu', $testUserId);
assertTest("Mission: Fetch by Slug (Tanaman Layu)", !empty($mission) && $mission['slug'] === 'tanaman-layu');

// Complete Mission 2.1 (Tanaman Layu)
$completeRes = $progressService->completeMission($testUserId, (int)$mission['id'], 1, 'Air dan cahaya penting untuk tanaman');
assertTest("Mission: Complete Mission", $completeRes['success'] === true, $completeRes['error'] ?? '');
assertTest("Mission: XP Awarded", $completeRes['total_awarded_xp'] >= 100, "XP: " . ($completeRes['total_awarded_xp'] ?? 0));
assertTest("Mission: 3 Stars Rating", ($completeRes['stars'] ?? 0) === 3);

// Verify Next Mission in World (Misteri Bayangan) is now unlocked!
$nextMission = $progressService->getMissionBySlug('misteri-bayangan', $testUserId);
assertTest("Mission: Next Node Unlocked (Misteri Bayangan)", $nextMission['progress_status'] === 'available', "Status: " . ($nextMission['progress_status'] ?? ''));

// 5. Gamification & Skill Journey Tests
$gamification = new GamificationService();
$skills = $gamification->getSkillProgress($testUserId);
assertTest("Skills: Science Progress Updated", $skills['science']['percent'] > 0, "Percent: " . $skills['science']['percent']);

$userAch = $gamification->getUserAchievements($testUserId);
$hasFirstBadge = false;
foreach ($userAch as $ua) {
    if ($ua['slug'] === 'first-mission' && !empty($ua['is_unlocked'])) {
        $hasFirstBadge = true;
    }
}
assertTest("Badges: 'First Mission' Badge Unlocked", $hasFirstBadge);

echo "\n==========================================\n";
echo "  TEST SUMMARY: {$testsPassed} / {$totalTests} PASSED\n";
echo "==========================================\n\n";

if ($testsPassed === $totalTests) {
    exit(0);
} else {
    exit(1);
}
