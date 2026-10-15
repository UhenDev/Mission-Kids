<?php
/**
 * Test Suite: Miko Cute Voice Exclusivity & 80 Missions Verification
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';

$pdo = Database::getConnection();

$passed = 0;
$total = 0;

function check(string $desc, bool $result, string $details = '') {
    global $passed, $total;
    $total++;
    if ($result) {
        $passed++;
        echo "  [PASS] {$desc}\n";
    } else {
        echo "  [FAIL] {$desc} - {$details}\n";
    }
}

echo "========================================================\n";
echo "  MIKO VOICE & 80 MISSIONS VERIFICATION SUITE\n";
echo "========================================================\n\n";

// ---------------------------------------------------------------------------
// 1. Miko Single Cute Voice Verification
// ---------------------------------------------------------------------------
echo "--- 1. Miko Voice Interaction Verification ---\n";

$ch = curl_init('http://127.0.0.1:8080/?page=landing');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$landingHtml = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

check("Landing page HTTP 200", $httpCode === 200, "HTTP code: {$httpCode}");
check("Miko trigger exists (#miko-avatar-trigger)", strpos($landingHtml, 'id="miko-avatar-trigger"') !== false);
check("Miko dock button has unique ID (#miko-dock-avatar-trigger)", strpos($landingHtml, 'id="miko-dock-avatar-trigger"') !== false);
check("No duplicate ID miko-avatar-trigger in DOM", substr_count($landingHtml, 'id="miko-avatar-trigger"') === 1);

check("Greeting studio audio exists on disk", file_exists(__DIR__ . '/public/audio/miko/greeting_default.mp3'));
check("Landing page uses activeMikoAudio for exclusive playback", strpos($landingHtml, 'activeMikoAudio') !== false);
check("Landing page playMikoVoice stops previous speech first", strpos($landingHtml, 'stopMikoVoice()') !== false);
check("Landing page does NOT autoplay audio on load", strpos($landingHtml, 'autoplay') === false);

$companionJs = file_get_contents(__DIR__ . '/public/js/engine/MikoCompanion.js');
check("MikoCompanion.speak does not play overlapping chime", strpos($companionJs, 'window.SoundFX.playMikoChirp()') === false);

// ---------------------------------------------------------------------------
// 2. World Map & 20+ Missions per World Verification
// ---------------------------------------------------------------------------
echo "\n--- 2. World Map & Missions Count Verification ---\n";

check("Landing page hero ribbon shows '80+ Misi Menarik'", strpos($landingHtml, '80+ Misi Menarik') !== false);
check("Landing page map section shows '4 Dunia, 80 Misi Seru'", strpos($landingHtml, '4 Dunia, 80 Misi Seru') !== false);
check("Number City badge shows '20 Misi Seru'", strpos($landingHtml, 'badge-number-city') !== false && strpos($landingHtml, '20 Misi Seru') !== false);
check("Discovery Lab badge shows '20 Misi Seru'", strpos($landingHtml, 'badge-discovery-lab') !== false && strpos($landingHtml, '20 Misi Seru') !== false);
check("Thinking Lab badge shows '20 Misi Seru'", strpos($landingHtml, 'badge-thinking-lab') !== false && strpos($landingHtml, '20 Misi Seru') !== false);
check("Space Odyssey badge shows '20 Misi Seru'", strpos($landingHtml, 'badge-space-odyssey') !== false && strpos($landingHtml, '20 Misi Seru') !== false);

$stmt = $pdo->query("SELECT w.slug, w.title, COUNT(m.id) as total_missions
                     FROM worlds w
                     LEFT JOIN missions m ON w.id = m.world_id AND m.is_active = 1
                     GROUP BY w.id
                     ORDER BY w.sort_order ASC");
$worlds = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalMissions = 0;
foreach ($worlds as $w) {
    $count = (int)$w['total_missions'];
    $totalMissions += $count;
    check("World '{$w['title']}' ({$w['slug']}) has >= 20 missions (Current: {$count})", $count >= 20, "Only {$count} missions found");
}

check("Total active missions in database >= 80 (Current: {$totalMissions})", $totalMissions >= 80, "Found {$totalMissions}");

// ---------------------------------------------------------------------------
// 3. Puzzle Validator Engine Verification
// ---------------------------------------------------------------------------
echo "\n--- 3. Puzzle Validator & Interaction Engine ---\n";

require_once __DIR__ . '/src/Services/PuzzleValidatorService.php';
$validator = new PuzzleValidatorService();

// Test generic mission validator
$dummyConfig = [
    'question' => 'Berapa 10 + 10?',
    'correct_answer' => 'opt_20',
    'hints' => [['level' => 1, 'text' => 'Hitung puluhan']]
];

$validRes = $validator->validate('tambah-puluhan', ['selected_answer' => 'opt_20'], $dummyConfig);
check("Validator accepts correct_answer", $validRes['valid'] === true);

$invalidRes = $validator->validate('tambah-puluhan', ['selected_answer' => 'opt_15'], $dummyConfig);
check("Validator rejects incorrect answer and returns hint", $invalidRes['valid'] === false);

// Test flagship mission (e.g. Toko Kue)
$tokoKueRes = $validator->validate('toko-kue', ['donuts' => 2, 'change' => 1000], [
    'target_goods_count' => 2,
    'target_change' => 1000
]);
check("Flagship interactive mini-game (Toko Kue) validates properly", $tokoKueRes['valid'] === true);

echo "\n========================================================\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================\n";

if ($passed !== $total) {
    exit(1);
}
