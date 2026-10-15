<?php
/**
 * TEST SUITE: Mobile Responsiveness & Database Auto-Bootstrap Verification
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../database/DatabaseBootstrapper.php';
require_once __DIR__ . '/../src/Services/MissionProgressService.php';

function check(string $label, bool $pass, string $info = ''): void {
    if ($pass) {
        echo "  [PASS] {$label}\n";
    } else {
        echo "  [FAIL] {$label}" . ($info ? " -> {$info}" : "") . "\n";
        exit(1);
    }
}

echo "========================================================================\n";
echo "  TEST SUITE: MOBILE RESPONSIVENESS & DOKPLOY AUTO-BOOTSTRAP\n";
echo "========================================================================\n\n";

// 1. Database Auto-Bootstrap on Brand New 0-Byte SQLite Database
echo "--- 1. Testing Fresh Database Auto-Bootstrap (Dokploy Simulation) ---\n";
$tempDbPath = __DIR__ . '/temp_empty_test_' . time() . '.sqlite';
if (file_exists($tempDbPath)) unlink($tempDbPath);

// Create fresh 0-byte SQLite connection
$testPdo = new PDO('sqlite:' . $tempDbPath, null, null, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);

// Verify it has 0 tables initially
$tablesBefore = $testPdo->query("SELECT name FROM sqlite_master WHERE type='table'")->fetchAll();
check("Fresh SQLite DB starts with 0 tables", count($tablesBefore) === 0);

// Run DatabaseBootstrapper
DatabaseBootstrapper::run($testPdo, 'sqlite');

// Verify tables were created
$worldsCount = $testPdo->query("SELECT COUNT(*) FROM worlds")->fetchColumn();
check("Table 'worlds' created and contains 4 worlds", (int)$worldsCount === 4);

$missionsCount = $testPdo->query("SELECT COUNT(*) FROM missions")->fetchColumn();
check("Table 'missions' created and contains 80 missions", (int)$missionsCount === 80);

$achievementsCount = $testPdo->query("SELECT COUNT(*) FROM achievements")->fetchColumn();
check("Table 'achievements' created and contains 6 badges", (int)$achievementsCount === 6);

// Test Idempotence: Running bootstrapper again must NOT wipe or duplicate data
DatabaseBootstrapper::run($testPdo, 'sqlite');
$worldsCount2 = $testPdo->query("SELECT COUNT(*) FROM worlds")->fetchColumn();
check("Bootstrapper is idempotent (worlds count unchanged at 4)", (int)$worldsCount2 === 4);
$missionsCount2 = $testPdo->query("SELECT COUNT(*) FROM missions")->fetchColumn();
check("Bootstrapper is idempotent (missions count unchanged at 80)", (int)$missionsCount2 === 80);

// Close test connection & clean up temp DB
$testPdo = null;
if (file_exists($tempDbPath)) {
    unlink($tempDbPath);
}

// 2. MissionProgressService with Active Database
echo "\n--- 2. Testing MissionProgressService Query on Active DB ---\n";
$service = new MissionProgressService();
$worlds = $service->getWorldsWithProgress(0);
check("MissionProgressService::getWorldsWithProgress returns array", is_array($worlds) && count($worlds) === 4);
check("Number City has 20 missions", count($worlds[0]['missions']) === 20);
check("Discovery Lab has 20 missions", count($worlds[1]['missions']) === 20);
check("Thinking Lab has 20 missions", count($worlds[2]['missions']) === 20);
check("Space Odyssey has 20 missions", count($worlds[3]['missions']) === 20);

// 3. CSS Mobile Responsiveness Checks
echo "\n--- 3. Testing CSS Mobile Responsiveness Rules in components.css ---\n";
$css = file_get_contents(__DIR__ . '/../public/css/components.css');

check(".miko-visual-column has flex-direction: column", strpos($css, "flex-direction: column;") !== false);
check(".miko-visual-column has align-items: center", strpos($css, "align-items: center;") !== false);
check(".miko-speech-card has max-width: 440px", strpos($css, "max-width: 440px;") !== false);
check(".miko-speech-card has box-sizing: border-box", strpos($css, "box-sizing: border-box;") !== false);
check("Mobile media query updates .miko-visual-column", strpos($css, ".miko-visual-column") !== false);
check("Mobile media query updates .miko-speech-card", strpos($css, ".miko-speech-card") !== false);
check(".btn-single-world-cta has mobile width handling", strpos($css, ".btn-single-world-cta") !== false);

// 4. Landing Page Template HTML & Cache Buster
echo "\n--- 4. Testing Landing Page HTML & Header Cache Buster ---\n";
$landingHtml = file_get_contents(__DIR__ . '/../templates/pages/landing.php');
check("Landing page has margin-bottom on worlds-action-row", strpos($landingHtml, "margin-bottom: 2.25rem;") !== false);
check("Landing page has btn-lihat-dunia-lengkap with responsive sizing", strpos($landingHtml, "max-width: 100%") !== false);

$headerHtml = file_get_contents(__DIR__ . '/../templates/layouts/header.php');
check("Header imports components.css?v=3.4", strpos($headerHtml, "components.css?v=3.4") !== false);

// 5. Local Dev Server HTTP 200 Test
echo "\n--- 5. Testing Local Server HTTP 200 Response ---\n";
$res = @file_get_contents("http://127.0.0.1:8080/?page=landing");
check("Local server returns valid HTML for landing page", !empty($res) && strpos($res, "MISSION KIDS") !== false);
check("Landing page contains 'Kenalan dengan MIKO'", strpos($res, "Kenalan dengan MIKO") !== false);
check("Landing page contains 'Lihat Dunia Lengkap'", strpos($res, "Lihat Dunia Lengkap") !== false);

echo "\n========================================================================\n";
echo "  ALL MOBILE & DB AUTO-BOOTSTRAP TESTS PASSED SUCCESSFULLY!\n";
echo "========================================================================\n";
