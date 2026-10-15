<?php
/**
 * MISSION KIDS — Integration Test: Anti-Tampering & Server-Side Puzzle Validation
 * Proves that invalid solutions, missing payloads, forged reflection, and prerequisite bypasses
 * NEVER alter user progress, stars, or XP rewards.
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Services/AuthService.php';
require_once __DIR__ . '/src/Services/MissionProgressService.php';
require_once __DIR__ . '/src/Services/GamificationService.php';

echo "\n===============================================================\n";
echo "  MISSION KIDS: PUZZLE ANTI-TAMPERING INTEGRATION TEST SUITE\n";
echo "===============================================================\n\n";

$pdo = Database::getConnection();
$auth = new AuthService();
$progService = new MissionProgressService();
$gamification = new GamificationService();

$passed = 0;
$total = 0;

function assertTamp(string $name, bool $condition, string $details = ''): void {
    global $passed, $total;
    $total++;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name} - {$details}\n";
    }
}

// Register isolated student for tamper testing
$tamperUsername = 'tamper_test_' . time();
$reg = $auth->register($tamperUsername, 'secret123', 'Siswa Auditor', 'astro_cat');
$userId = (int)($reg['user_id'] ?? 0);

// Helper to check user XP
function getUserXp(PDO $pdo, int $userId): int {
    $stmt = $pdo->prepare("SELECT total_xp FROM profiles WHERE user_id = :uid LIMIT 1");
    $stmt->execute([':uid' => $userId]);
    return (int)$stmt->fetchColumn();
}

// -----------------------------------------------------------------------------
// Test 1: Submitting completeMission WITHOUT solution_payload (Missing Solution)
// -----------------------------------------------------------------------------
$resMissing = $progService->completeMission($userId, 1, 0, 'Refleksi Valid', null);
assertTamp('Test 1: Request tanpa solution_payload DITOLAK', 
    $resMissing['success'] === false && !empty($resMissing['validation_failed']));

// Verify DB: Mission 1 must NOT be completed, XP must remain 0
$stmtProg = $pdo->prepare("SELECT status FROM mission_progress WHERE user_id = :uid AND mission_id = 1");
$stmtProg->execute([':uid' => $userId]);
$status1 = $stmtProg->fetchColumn();
assertTamp('Test 1 DB: Status misi tetap belum selesai (bukan completed)', 
    $status1 !== 'completed');
assertTamp('Test 1 DB: Total XP tetap 0', getUserXp($pdo, $userId) === 0);

// -----------------------------------------------------------------------------
// Test 2: Submitting completeMission with WRONG solution (Manipulated Values)
// -----------------------------------------------------------------------------
// Toko Kue butuh 2 donat dan kembalian 1000. Kirim: 1 donat, 500 koin
$resWrong = $progService->completeMission($userId, 1, 0, 'Refleksi Valid', ['donuts' => 1, 'change' => 500]);
assertTamp('Test 2: Solusi teka-teki manipulatif/salah DITOLAK', 
    $resWrong['success'] === false && !empty($resWrong['validation_failed']));

// Verify that failed attempt was automatically recorded in mission_attempts
$stmtAtt = $pdo->prepare("SELECT COUNT(*) FROM mission_attempts WHERE user_id = :uid AND mission_id = 1 AND is_success = 0");
$stmtAtt->execute([':uid' => $userId]);
$failedAttemptsCount = (int)$stmtAtt->fetchColumn();
assertTamp('Test 2 DB: Percobaan gagal tercatat di mission_attempts', $failedAttemptsCount >= 2);

// -----------------------------------------------------------------------------
// Test 3: Submitting VALID solution after failures -> First-Try Bonus NOT awarded
// -----------------------------------------------------------------------------
$resCorrect = $progService->completeMission($userId, 1, 0, 'Refleksi Sembarang', ['donuts' => 2, 'change' => 1000]);
assertTamp('Test 3: Solusi sah (2 donat, 1000 koin) BERHASIL diselesaikan', 
    $resCorrect['success'] === true && $resCorrect['stars'] === 3);

// Verify First-Try Bonus: Karena user sudah pernah gagal di Test 1 & 2, first_try_bonus (50 XP) TIDAK boleh cair!
$hasFirstTryBonus = false;
foreach ($resCorrect['xp_breakdown'] as $item) {
    if (str_contains($item['label'], 'Sekali Coba')) {
        $hasFirstTryBonus = true;
    }
}
assertTamp('Test 3 Anti-Abuse: First-Try Bonus (50 XP) GUGUR karena riwayat percobaan gagal', 
    $hasFirstTryBonus === false);

// -----------------------------------------------------------------------------
// Test 4: Reflection Tampering (Arbitrary text should NOT award 30 XP reflection bonus)
// -----------------------------------------------------------------------------
$hasReflectionBonus = false;
foreach ($resCorrect['xp_breakdown'] as $item) {
    if (str_contains($item['label'], 'Refleksi')) {
        $hasReflectionBonus = true;
    }
}
assertTamp('Test 4 Anti-Abuse: Teks refleksi sembarang TIDAK mendapatkan bonus 30 XP', 
    $hasReflectionBonus === false);

// Total awarded from mission should be strictly base XP 100 (plus 50 XP from first-mission achievement)
assertTamp('Test 4 DB: Total XP yang didapat hanya base XP 100 (+ 50 badge pertama)', 
    $resCorrect['total_awarded_xp'] === 100 && getUserXp($pdo, $userId) === 150);

// -----------------------------------------------------------------------------
// Test 5: Clean Run with Authentic Reflection on Mission 2 (Jembatan Angka)
// -----------------------------------------------------------------------------
// Mission 2 is now available because Mission 1 was completed
$correctReflectionText = 'Setiap papan selalu melompat bertambah 4 (+4)';
$resM2 = $progService->completeMission($userId, 2, 0, $correctReflectionText, ['selected_value' => 15]);
assertTamp('Test 5: Misi 2 dengan balok 15 dan refleksi otentik BERHASIL', 
    $resM2['success'] === true);

$hasM2Reflection = false;
foreach ($resM2['xp_breakdown'] as $item) {
    if (str_contains($item['label'], 'Refleksi') && $item['amount'] === 30) {
        $hasM2Reflection = true;
    }
}
assertTamp('Test 5: Bonus Refleksi Belajar (30 XP) DICAIRKAN untuk jawaban refleksi yang benar', 
    $hasM2Reflection === true);

// -----------------------------------------------------------------------------
// Test 6: Replay Reward Capped at Max 3 Times
// -----------------------------------------------------------------------------
// User replays Mission 1
$r1 = $progService->completeMission($userId, 1, 0, null, ['donuts' => 2, 'change' => 1000]);
$r2 = $progService->completeMission($userId, 1, 0, null, ['donuts' => 2, 'change' => 1000]);
$r3 = $progService->completeMission($userId, 1, 0, null, ['donuts' => 2, 'change' => 1000]);
$r4 = $progService->completeMission($userId, 1, 0, null, ['donuts' => 2, 'change' => 1000]);

assertTamp('Test 6 Replay 1: Latihan ulang ke-1 mendapat 25 XP', $r1['total_awarded_xp'] === 25);
assertTamp('Test 6 Replay 2: Latihan ulang ke-2 mendapat 25 XP', $r2['total_awarded_xp'] === 25);
assertTamp('Test 6 Replay 3: Latihan ulang ke-3 mendapat 25 XP', $r3['total_awarded_xp'] === 25);
assertTamp('Test 6 Replay 4: Latihan ulang ke-4 DIBATASI (0 XP didapat)', $r4['total_awarded_xp'] === 0);

// -----------------------------------------------------------------------------
// Test 7: Locked Mission Prerequisite Bypass with Valid Solution
// -----------------------------------------------------------------------------
// Mission 9 (Robot Mengulang) is still locked for this user
$resLocked = $progService->completeMission($userId, 9, 0, 'Refleksi', ['loop_count' => 4, 'actions' => ['Lompat', 'Maju']]);
assertTamp('Test 7: Misi terkunci (Misi 9) TETAP DITOLAK meskipun payload solusinya valid', 
    $resLocked['success'] === false && str_contains($resLocked['error'], 'terkunci'));

// Verify Mission 9 status in DB
$stmtM9 = $pdo->prepare("SELECT status FROM mission_progress WHERE user_id = :uid AND mission_id = 9");
$stmtM9->execute([':uid' => $userId]);
$m9Status = $stmtM9->fetchColumn();
assertTamp('Test 7 DB: Misi 9 tidak berubah menjadi completed', $m9Status !== 'completed');

echo "\n===============================================================\n";
echo "  TAMPER INTEGRATION TEST SUMMARY: {$passed} / {$total} PASSED\n";
echo "===============================================================\n\n";

if ($passed === $total) {
    exit(0);
} else {
    exit(1);
}
