<?php
/**
 * MISSION KIDS — Security & State Progression Test Suite
 * Validates prerequisite rules, anti-bypass mechanisms, and ACID transactions.
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Services/AuthService.php';
require_once __DIR__ . '/src/Services/MissionProgressService.php';
require_once __DIR__ . '/src/Services/GamificationService.php';

echo "====================================================\n";
echo "  MISSION KIDS: SECURITY & PROGRESSION VERIFICATION\n";
echo "====================================================\n\n";

$pdo = Database::getConnection();
$auth = new AuthService();
$progService = new MissionProgressService();
$gamification = new GamificationService();

$passed = 0;
$total = 0;

function assertSec(string $name, bool $condition, string $detail = ''): void {
    global $passed, $total;
    $total++;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name} - {$detail}\n";
    }
}

// Create isolated test user A
$usernameA = 'sec_user_a_' . time();
$regA = $auth->register($usernameA, 'pass1234', 'Siswa A', 'astro_cat');
$userIdA = (int)($regA['user_id'] ?? 0);

// Create isolated test user B
$usernameB = 'sec_user_b_' . time();
$regB = $auth->register($usernameB, 'pass1234', 'Siswa B', 'super_bear');
$userIdB = (int)($regB['user_id'] ?? 0);

try {
    // Skenario 1: Akun baru menyelesaikan misi pertama yang tersedia (World 1 Mission 1: Toko Kue, ID 1)
    $res1 = $progService->completeMission($userIdA, 1, 0, 'Refleksi 1', ['donuts' => 2, 'change' => 1000]);
    assertSec('Skenario 1: Misi pertama yang tersedia (ID 1) BERHASIL diselesaikan', 
        $res1['success'] === true && $res1['is_first_clear'] === true && $res1['total_awarded_xp'] >= 100);

    // Verifikasi database setelah Skenario 1:
    $stmtDb1 = $pdo->prepare("SELECT status, stars FROM mission_progress WHERE user_id = :uid AND mission_id = 1");
    $stmtDb1->execute([':uid' => $userIdA]);
    $row1 = $stmtDb1->fetch();
    assertSec('DB Verif 1: Status Misi 1 tersimpan completed dengan 3 bintang', 
        $row1 && $row1['status'] === 'completed' && (int)$row1['stars'] === 3);

    // Skenario 2: Akun baru (User B) mencoba menyelesaikan misi terakhir secara langsung (ID 9: Robot Mengulang)
    $res2 = $progService->completeMission($userIdB, 9, 0, 'Bypass Attempt', ['loop_count' => 4, 'actions' => ['Lompat', 'Maju']]);
    assertSec('Skenario 2: Menyelesaikan misi terakhir langsung (ID 9) DITOLAK oleh server', 
        $res2['success'] === false && strpos($res2['error'], 'terkunci') !== false);

    // Verifikasi database setelah Skenario 2: User B tidak memiliki progres tersimpan pada Misi 9
    $stmtDb2 = $pdo->prepare("SELECT * FROM mission_progress WHERE user_id = :uid AND mission_id = 9");
    $stmtDb2->execute([':uid' => $userIdB]);
    $row2 = $stmtDb2->fetch();
    assertSec('DB Verif 2: Misi 9 milik User B tetap tidak memiliki catatan completed', 
        empty($row2) || $row2['status'] !== 'completed');

    // Skenario 3: User B mencoba menyelesaikan Misi 2 (Jembatan Angka) tanpa menyelesaikan Misi 1
    $res3 = $progService->completeMission($userIdB, 2, 0, 'Skip Mission 1', ['selected_value' => 15]);
    assertSec('Skenario 3: Menyelesaikan Misi 2 yang terkunci DITOLAK server', 
        $res3['success'] === false && strpos($res3['error'], 'terkunci') !== false);

    // Skenario 4: User A menyelesaikan Misi 2 setelah prasyarat Misi 1 terpenuhi
    $res4 = $progService->completeMission($userIdA, 2, 0, 'Refleksi 2', ['selected_value' => 15]);
    assertSec('Skenario 4: Misi 2 BERHASIL diselesaikan setelah Misi 1 selesai', 
        $res4['success'] === true && $res4['is_first_clear'] === true);

    // Skenario 5: User A mengirim ulang penyelesaian Misi 1 (Replay)
    $stmtXpBefore = $pdo->prepare("SELECT total_xp FROM profiles WHERE user_id = :uid");
    $stmtXpBefore->execute([':uid' => $userIdA]);
    $xpBeforeReplay = (int)$stmtXpBefore->fetchColumn();

    $res5 = $progService->completeMission($userIdA, 1, 0, 'Replay Misi 1', ['donuts' => 2, 'change' => 1000]);
    assertSec('Skenario 5a: Replay Misi 1 berhasil dengan status is_first_clear = false', 
        $res5['success'] === true && $res5['is_first_clear'] === false);
    assertSec('Skenario 5b: Replay Misi 1 hanya memberikan bonus latihan (25 XP), bukan reward penuh', 
        $res5['total_awarded_xp'] === 25);

    // Skenario 6: Isolasi progres antarpengguna (User A dan User B)
    $stmtProgA = $pdo->prepare("SELECT status FROM mission_progress WHERE user_id = :uid AND mission_id = 2");
    $stmtProgA->execute([':uid' => $userIdA]);
    $progA = $stmtProgA->fetchColumn();

    $stmtProgB = $pdo->prepare("SELECT status FROM mission_progress WHERE user_id = :uid AND mission_id = 2");
    $stmtProgB->execute([':uid' => $userIdB]);
    $progB = $stmtProgB->fetchColumn();

    assertSec('Skenario 6: Progres User A (completed) terisolasi sempurna dari User B (locked/empty)', 
        $progA === 'completed' && ($progB === false || $progB === null || $progB === 'locked'));

    // Skenario 7: Validasi pembukaan Misi 3 setelah Misi 2 selesai
    $m3 = $progService->getMissionById(3);
    $isM3Available = $progService->isMissionAvailable($userIdA, $m3);
    assertSec('Skenario 7: Misi 3 otomatis menjadi available untuk User A setelah Misi 2 selesai', 
        $isM3Available === true);

    // Skenario 8: Verifikasi Atomic Transaction & Rollback
    // Simulasikan transaksi yang dibatalkan tidak meninggalkan jejak corrupt
    $countBefore = (int)$pdo->query("SELECT COUNT(*) FROM mission_attempts WHERE user_id = {$userIdA}")->fetchColumn();
    $pdo->beginTransaction();
    $pdo->prepare("INSERT INTO mission_attempts (user_id, mission_id, hints_used, is_success) VALUES (:uid, 1, 0, 1)")
        ->execute([':uid' => $userIdA]);
    $pdo->rollBack();

    $countAfter = (int)$pdo->query("SELECT COUNT(*) FROM mission_attempts WHERE user_id = {$userIdA}")->fetchColumn();
    assertSec('Skenario 8: Rollback database berhasil mengembalikan status tanpa jejak parsial', 
        $countBefore === $countAfter);

    // Skenario 9: Pembukaan misi lintas dunia terisolasi
    // Selesainya Misi 1 & 2 di Dunia 1 tidak boleh otomatis membuka Misi 5 (Dunia 2 Misi 2)
    $m5 = $progService->getMissionById(5);
    $isM5Available = $progService->isMissionAvailable($userIdA, $m5);
    assertSec('Skenario 9: Progres Dunia 1 tidak membocorkan pembukaan misi di Dunia 2 (Misi 5 tetap locked)', 
        $isM5Available === false);

} finally {
    // Teardown: Bersihkan akun uji dan seluruh relasi cascade secara bersih
    if ($userIdA > 0) {
        $pdo->prepare("DELETE FROM users WHERE id = :id")->execute([':id' => $userIdA]);
    }
    if ($userIdB > 0) {
        $pdo->prepare("DELETE FROM users WHERE id = :id")->execute([':id' => $userIdB]);
    }
}

echo "\n====================================================\n";
echo "  HASIL: {$passed} / {$total} SKENARIO KEAMANAN LULUS\n";
echo "====================================================\n";

if ($passed !== $total) {
    exit(1);
}
