<?php
/**
 * MISSION KIDS — Comprehensive Concurrency & Race Condition Test Suite
 * Spawns multiple parallel PHP processes with independent database connections
 * to rigorously verify serialization, idempotency, atomic XP updates, and replay caps.
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Services/AuthService.php';

echo "\n===============================================================\n";
echo "  MISSION KIDS: MULTI-PROCESS CONCURRENCY & RACE TEST SUITE\n";
echo "===============================================================\n\n";

$pdo = Database::getConnection();
$driver = Database::getDriverUsed();
echo "Active Database Driver: {$driver}\n\n";

$auth = new AuthService();
$passed = 0;
$total = 0;

function assertRace(string $name, bool $condition, string $details = ''): void {
    global $passed, $total;
    $total++;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name} - {$details}\n";
    }
}

function runParallelProcesses(array $commands): array {
    $processes = [];
    $pipes = [];

    // Launch all processes simultaneously
    foreach ($commands as $i => $cmd) {
        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w']
        ];
        $proc = proc_open($cmd, $descriptors, $pipes[$i]);
        if (is_resource($proc)) {
            $processes[$i] = $proc;
        }
    }

    $results = [];
    // Collect output from all parallel processes
    foreach ($processes as $i => $proc) {
        $stdout = stream_get_contents($pipes[$i][1]);
        $stderr = stream_get_contents($pipes[$i][2]);
        fclose($pipes[$i][0]);
        fclose($pipes[$i][1]);
        fclose($pipes[$i][2]);
        $status = proc_close($proc);
        $results[$i] = [
            'status' => $status,
            'stdout' => $stdout,
            'stderr' => $stderr,
            'data' => json_decode(trim($stdout), true)
        ];
    }

    return $results;
}

// -----------------------------------------------------------------------------
// Test Suite 1: Concurrent First-Clear (Two Identical Requests)
// -----------------------------------------------------------------------------
echo "--- TEST SUITE 1: CONCURRENT FIRST-CLEAR (2 PARALLEL PROCESSES) ---\n";
$u1 = 'race_fc_' . time() . '_' . rand(100, 999);
$reg1 = $auth->register($u1, 'pass123', 'Siswa FC', 'astro_cat');
$uid1 = (int)($reg1['user_id'] ?? 0);

$solM1 = base64_encode(json_encode(['donuts' => 2, 'change' => 1000]));
$refM1 = base64_encode('Agar kita tahu jumlah uang yang kita miliki tetap tepat dan jujur.');
$emptyRef = '-';

// Spawn 2 parallel processes attempting first-clear at the exact same moment
$cmd1 = "php worker_complete_mission.php {$uid1} 1 0 {$refM1} {$solM1}";
$cmd2 = "php worker_complete_mission.php {$uid1} 1 0 {$refM1} {$solM1}";

$res1 = runParallelProcesses([$cmd1, $cmd2]);

// Query database verification
$stmtTxFc = $pdo->prepare("SELECT source_type, COUNT(*) as cnt, SUM(amount) as total FROM xp_transactions WHERE user_id = :uid GROUP BY source_type");
$stmtTxFc->execute([':uid' => $uid1]);
$txSummary = [];
while ($row = $stmtTxFc->fetch()) {
    $txSummary[$row['source_type']] = ['cnt' => (int)$row['cnt'], 'total' => (int)$row['total']];
}

$stmtProfFc = $pdo->prepare("SELECT total_xp FROM profiles WHERE user_id = :uid LIMIT 1");
$stmtProfFc->execute([':uid' => $uid1]);
$profXpFc = (int)$stmtProfFc->fetchColumn();

// Verify that mission_clear was awarded exactly ONCE
$clearCnt = $txSummary['mission_clear']['cnt'] ?? 0;
assertRace('1.1. Reward First-Clear (mission_clear) DIBERIKAN TEPAT SATU KALI', $clearCnt === 1, "Count: {$clearCnt}");

// Verify that first_try_bonus was NOT duplicated
$firstTryCnt = $txSummary['first_try_bonus']['cnt'] ?? 0;
assertRace('1.2. Bonus First-Try (50 XP) TIDAK PERNAH DIGANDAKAN', $firstTryCnt === 1, "Count: {$firstTryCnt}");

// Verify that reflection_bonus was NOT duplicated
$refCnt = $txSummary['reflection_bonus']['cnt'] ?? 0;
assertRace('1.3. Bonus Refleksi (30 XP) TIDAK PERNAH DIGANDAKAN', $refCnt === 1, "Count: {$refCnt}");

// Verify that profile total_xp equals exact sum of transactions
$stmtSumTx = $pdo->prepare("SELECT SUM(amount) FROM xp_transactions WHERE user_id = :uid");
$stmtSumTx->execute([':uid' => $uid1]);
$sumXp = (int)$stmtSumTx->fetchColumn();
assertRace('1.4. Total XP di profil KONSISTEN dengan total riwayat transaksi XP', $profXpFc === $sumXp, "Profile XP: {$profXpFc}, Sum TX: {$sumXp}");

// -----------------------------------------------------------------------------
// Test Suite 2: Concurrent Replays (5 Parallel Processes Exceeding Replay Cap)
// -----------------------------------------------------------------------------
echo "\n--- TEST SUITE 2: CONCURRENT REPLAYS (5 PARALLEL PROCESSES) ---\n";
$u2 = 'race_rep_' . time() . '_' . rand(100, 999);
$reg2 = $auth->register($u2, 'pass123', 'Siswa Replay', 'super_bear');
$uid2 = (int)($reg2['user_id'] ?? 0);

// Step 1: Complete mission 1 first legitimately
exec("php worker_complete_mission.php {$uid2} 1 0 {$refM1} {$solM1}");

// Step 2: Now fire 5 concurrent replay processes simultaneously!
$repCmds = [];
for ($i = 0; $i < 5; $i++) {
    $repCmds[] = "php worker_complete_mission.php {$uid2} 1 0 {$emptyRef} {$solM1}";
}
$resRep = runParallelProcesses($repCmds);

// Query database verification
$stmtRepCnt = $pdo->prepare("SELECT COUNT(*) FROM xp_transactions WHERE user_id = :uid AND source_type = 'mission_replay'");
$stmtRepCnt->execute([':uid' => $uid2]);
$replaysAwarded = (int)$stmtRepCnt->fetchColumn();

assertRace('2.1. Batas Replay (Maks 3x) DITEGAKKAN KETAT saat 5 request konkuren', $replaysAwarded === 3, "Awarded: {$replaysAwarded}");

// Check replay transactions sum
$stmtRepSum = $pdo->prepare("SELECT SUM(amount) FROM xp_transactions WHERE user_id = :uid AND source_type = 'mission_replay'");
$stmtRepSum->execute([':uid' => $uid2]);
$replayXpSum = (int)$stmtRepSum->fetchColumn();
assertRace('2.2. Total XP latihan ulang tepat 75 XP (25 x 3)', $replayXpSum === 75, "Total Replay XP: {$replayXpSum}");

// Profile XP matches sum
$stmtProfRep = $pdo->prepare("SELECT total_xp FROM profiles WHERE user_id = :uid LIMIT 1");
$stmtProfRep->execute([':uid' => $uid2]);
$profXpRep = (int)$stmtProfRep->fetchColumn();

$stmtSumTx2 = $pdo->prepare("SELECT SUM(amount) FROM xp_transactions WHERE user_id = :uid");
$stmtSumTx2->execute([':uid' => $uid2]);
$sumXp2 = (int)$stmtSumTx2->fetchColumn();
assertRace('2.3. Total XP profil sama dengan total transaksi XP (tanpa lost update)', $profXpRep === $sumXp2, "Profile: {$profXpRep}, TX: {$sumXp2}");

// -----------------------------------------------------------------------------
// Test Suite 3: Cross-User Concurrency (User A & User B Do Not Block Each Other)
// -----------------------------------------------------------------------------
echo "\n--- TEST SUITE 3: CROSS-USER CONCURRENCY (NON-BLOCKING) ---\n";
$uA = 'race_usrA_' . time() . '_' . rand(100, 999);
$uB = 'race_usrB_' . time() . '_' . rand(100, 999);
$regA = $auth->register($uA, 'pass123', 'Siswa A', 'astro_cat');
$regB = $auth->register($uB, 'pass123', 'Siswa B', 'super_bear');
$uidA = (int)($regA['user_id'] ?? 0);
$uidB = (int)($regB['user_id'] ?? 0);

$cmdA = "php worker_complete_mission.php {$uidA} 1 0 {$refM1} {$solM1}";
$cmdB = "php worker_complete_mission.php {$uidB} 1 0 {$refM1} {$solM1}";

$resCross = runParallelProcesses([$cmdA, $cmdB]);

$dataA = $resCross[0]['data'] ?? [];
$dataB = $resCross[1]['data'] ?? [];

assertRace('3.1. Pengguna A berhasil menyelesaikan misi saat paralel dengan Pengguna B', !empty($dataA['success']));
assertRace('3.2. Pengguna B berhasil menyelesaikan misi saat paralel dengan Pengguna A', !empty($dataB['success']));

// -----------------------------------------------------------------------------
// Test Suite 4: Mid-Transaction Rollback Consistency
// -----------------------------------------------------------------------------
echo "\n--- TEST SUITE 4: MID-TRANSACTION ROLLBACK ATOMICITY ---\n";
$u4 = 'race_rb_' . time() . '_' . rand(100, 999);
$reg4 = $auth->register($u4, 'pass123', 'Siswa Rollback', 'astro_cat');
$uid4 = (int)($reg4['user_id'] ?? 0);

// Simulate transaction rollback test
$pdo->beginTransaction();
$pdo->prepare("UPDATE profiles SET total_xp = total_xp + 500 WHERE user_id = :uid")->execute([':uid' => $uid4]);
$pdo->prepare("INSERT INTO xp_transactions (user_id, amount, source_type, reference_id) VALUES (:uid, 500, 'cheat', 1)")->execute([':uid' => $uid4]);
$pdo->rollBack();

$stmtProfRb = $pdo->prepare("SELECT total_xp FROM profiles WHERE user_id = :uid LIMIT 1");
$stmtProfRb->execute([':uid' => $uid4]);
$profXpRb = (int)$stmtProfRb->fetchColumn();

$stmtTxRb = $pdo->prepare("SELECT COUNT(*) FROM xp_transactions WHERE user_id = :uid");
$stmtTxRb->execute([':uid' => $uid4]);
$txCntRb = (int)$stmtTxRb->fetchColumn();

assertRace('4.1. Rollback transaksi membatalkan penambahan XP profil (tetap 0)', $profXpRb === 0);
assertRace('4.2. Rollback transaksi tidak meninggalkan catatan transaksi yatim (tetap 0)', $txCntRb === 0);

echo "\n===============================================================\n";
echo "  CONCURRENCY TEST SUMMARY: {$passed} / {$total} PASSED\n";
echo "===============================================================\n\n";

if ($passed === $total) {
    exit(0);
} else {
    exit(1);
}
