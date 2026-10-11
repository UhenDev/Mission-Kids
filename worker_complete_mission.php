<?php
/**
 * MISSION KIDS — Background Worker for Concurrency Testing
 * Invoked by test_concurrency_race.php to execute completeMission in parallel processes.
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Services/MissionProgressService.php';

$userId = (int)($argv[1] ?? 0);
$missionId = (int)($argv[2] ?? 1);
$hintsUsed = (int)($argv[3] ?? 0);
$refArg = $argv[4] ?? '';
$reflection = ($refArg !== '' && $refArg !== '-') ? (base64_decode($refArg) ?: $refArg) : null;
$payloadArg = $argv[5] ?? '';
$payloadJson = ($payloadArg !== '' && $payloadArg !== '-') ? (base64_decode($payloadArg) ?: $payloadArg) : '{}';
$solutionPayload = json_decode($payloadJson, true) ?: [];

if ($userId <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid userId']);
    exit(1);
}

// Ensure each process uses its own fresh PDO connection
$progressService = new MissionProgressService();
$result = $progressService->completeMission($userId, $missionId, $hintsUsed, $reflection, $solutionPayload);

echo json_encode($result);
exit(0);
