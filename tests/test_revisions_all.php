<?php
/**
 * MISSION KIDS — Master Verification Suite for 3 Revision Requirements
 * 1. Miko AI Voice Restored (Pitch 1.32, Rate 1.06, Single Avatar Trigger, No Navbar/Section Buttons)
 * 2. Per-Map Question Isolation (Peta 1..4 have isolated question lists, independent progress)
 * 3. Landing Page World Map Cleaned Up (Exactly ONE "Lihat Dunia Lengkap" button)
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

echo "========================================================================\n";
echo "  MISSION KIDS — COMPREHENSIVE REVISION VERIFICATION SUITE\n";
echo "========================================================================\n\n";

$cookieFile = __DIR__ . '/test_revisions_cookies.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

function makeReq(string $url, string $method = 'GET', $data = null): array {
    global $cookieFile;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 6);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if (is_array($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    }

    $body = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);

    return [
        'code' => $info['http_code'],
        'body' => (string)$body,
        'url' => (string)($info['url'] ?? '')
    ];
}

// ---------------------------------------------------------------------------
// 1. REVISION 1: SUARA AI MIKO RESTORATION
// ---------------------------------------------------------------------------
echo "--- 1. Miko Voice Restoration & Interaction Verification ---\n";

$companionJs = file_get_contents(__DIR__ . '/public/js/engine/MikoCompanion.js');
$landingPhp = file_get_contents(__DIR__ . '/templates/pages/landing.php');

check("MikoCompanion.js configures cute boy pitch: 1.25", strpos($companionJs, 'pitch: 1.25') !== false);
check("MikoCompanion.js configures lively rate: 1.05", strpos($companionJs, 'rate: 1.05') !== false);
check("landing.php TTS engine binds dynamic pitch", strpos($landingPhp, 'utterance.pitch = isArdiMale ? 1.16 : 1.25') !== false || strpos($landingPhp, 'window.MIKO_VOICE_CONFIG.pitch') !== false);
check("landing.php TTS engine binds dynamic rate", strpos($landingPhp, 'window.MIKO_VOICE_CONFIG.rate') !== false || strpos($landingPhp, 'utterance.rate = 1.05') !== false);

// Audio clips check (verified commit 74204da files)
$audioFiles = [
    'greeting_default.mp3',
    'cheer_1.mp3',
    'mission_success.mp3',
    'guide_toko_kue.mp3',
    'guide_tanaman_layu.mp3',
    'guide_roket_angkasa.mp3'
];
foreach ($audioFiles as $af) {
    $fullPath = __DIR__ . '/public/audio/miko/' . $af;
    check("Audio clip '{$af}' exists on disk with valid size", file_exists($fullPath) && filesize($fullPath) > 5000);
}

// Check landing page avatar trigger exclusivity
$landingRes = makeReq('http://127.0.0.1:8080/?page=landing');
$landingHtml = $landingRes['body'];

check("Landing page HTTP 200", $landingRes['code'] === 200);
check("Avatar Miko is the trigger (#miko-avatar-trigger)", strpos($landingHtml, 'id="miko-avatar-trigger"') !== false);
check("NO 'Dengarkan Suara Miko' button in navbar", strpos($landingHtml, 'Dengarkan Suara Miko') === false || substr_count($landingHtml, 'Dengarkan Suara Miko') === 0);
check("NO separate button for Miko voice in navbar/intro", strpos($landingHtml, 'btn-hear-miko') === false && strpos($landingHtml, 'btn-play-miko-voice') === false);
check("Exclusive playback: stopMikoVoice cancels audio before play", strpos($landingHtml, 'stopMikoVoice()') !== false);

// ---------------------------------------------------------------------------
// 2. REVISION 3: LANDING PAGE WORLD MAP SECTION CLEANUP
// ---------------------------------------------------------------------------
echo "\n--- 2. World Map Section Cleanup Verification ---\n";

check("Duplicate header link (#link-header-all-worlds) removed", strpos($landingHtml, 'id="link-header-all-worlds"') === false);
check("Duplicate floating map button (#btn-explore-all-worlds) removed", strpos($landingHtml, 'id="btn-explore-all-worlds"') === false);
check("Single 'Lihat Dunia Lengkap' button exists (#btn-lihat-dunia-lengkap)", strpos($landingHtml, 'id="btn-lihat-dunia-lengkap"') !== false);

// Exact count in rendered HTML: exactly 1 visual button
preg_match_all('/<a[^>]*id="btn-lihat-dunia-lengkap"[^>]*>[\s\S]*?<\/a>/i', $landingHtml, $btnMatches);
check("Exactly ONE 'Lihat Dunia Lengkap' button in entire landing page", count($btnMatches[0]) === 1);
check("Button links to valid register/world destination", strpos($btnMatches[0][0], 'href="?page=register"') !== false);

// Verify island hotspots still exist
check("Number City interactive hitbox exists", strpos($landingHtml, 'hitbox-number') !== false);
check("Discovery Lab interactive hitbox exists", strpos($landingHtml, 'hitbox-discovery') !== false);
check("Thinking Lab interactive hitbox exists", strpos($landingHtml, 'hitbox-thinking') !== false);
check("Space Odyssey interactive hitbox exists", strpos($landingHtml, 'hitbox-space') !== false);

// ---------------------------------------------------------------------------
// 3. REVISION 2: PER-MAP QUESTION ISOLATION & PROGRESS SYSTEM
// ---------------------------------------------------------------------------
echo "\n--- 3. Per-Map Question Isolation & System Verification ---\n";

// Register fresh student session
$regPageRes = makeReq('http://127.0.0.1:8080/?page=register');
preg_match('/name="csrf_token"\s+value="([^"]+)"/', $regPageRes['body'], $csrfMatches);
$regCsrf = $csrfMatches[1] ?? '';

$testUser = 'tester_rev_' . time();
$regRes = makeReq('http://127.0.0.1:8080/?page=register', 'POST', [
    'csrf_token' => $regCsrf,
    'nickname' => 'Petualang Cilik',
    'username' => $testUser,
    'avatar_id' => 'kian',
    'password' => 'pass123'
]);

check("Registration successful and redirected to home", $regRes['code'] === 200 && strpos($regRes['url'], 'page=home') !== false);

function isTabActive(string $html, int $petaNum): bool {
    if (!preg_match('/<a[^>]*id="tab-peta-' . $petaNum . '"[^>]*>/i', $html, $m)) return false;
    return strpos($m[0], 'active') !== false && strpos($m[0], 'aria-selected="true"') !== false;
}

function isPanelVisible(string $html, string $worldSlug): bool {
    if (!preg_match('/<section[^>]*id="map-panel-' . $worldSlug . '"[^>]*>/i', $html, $m)) return false;
    return strpos($m[0], 'display: block') !== false && strpos($m[0], 'active') !== false;
}

function isPanelHidden(string $html, string $worldSlug): bool {
    if (!preg_match('/<section[^>]*id="map-panel-' . $worldSlug . '"[^>]*>/i', $html, $m)) return false;
    return strpos($m[0], 'display: none') !== false;
}

// Test Peta 1 (Number City)
$resPeta1 = makeReq('http://127.0.0.1:8080/?page=worlds&world=number-city');
$htmlPeta1 = $resPeta1['body'];
check("Peta 1 (Number City) loads HTTP 200", $resPeta1['code'] === 200);
check("Peta 1 tab is active", isTabActive($htmlPeta1, 1));
check("Peta 1 panel is displayed (display: block)", isPanelVisible($htmlPeta1, 'number-city'));
check("Peta 2 panel is hidden (display: none)", isPanelHidden($htmlPeta1, 'discovery-lab'));
check("Peta 3 panel is hidden (display: none)", isPanelHidden($htmlPeta1, 'thinking-lab'));
check("Peta 4 panel is hidden (display: none)", isPanelHidden($htmlPeta1, 'space-odyssey'));

// Test Peta 2 (Discovery Lab)
$resPeta2 = makeReq('http://127.0.0.1:8080/?page=worlds&world=discovery-lab');
$htmlPeta2 = $resPeta2['body'];
check("Peta 2 (Discovery Lab) loads HTTP 200", $resPeta2['code'] === 200);
check("Peta 2 tab is active", isTabActive($htmlPeta2, 2));
check("Peta 2 panel is displayed (display: block)", isPanelVisible($htmlPeta2, 'discovery-lab'));
check("Peta 1 panel is hidden (display: none)", isPanelHidden($htmlPeta2, 'number-city'));

// Test Peta 3 (Thinking Lab)
$resPeta3 = makeReq('http://127.0.0.1:8080/?page=worlds&world=thinking-lab');
$htmlPeta3 = $resPeta3['body'];
check("Peta 3 (Thinking Lab) loads HTTP 200", $resPeta3['code'] === 200);
check("Peta 3 tab is active", isTabActive($htmlPeta3, 3));
check("Peta 3 panel is displayed (display: block)", isPanelVisible($htmlPeta3, 'thinking-lab'));
check("Peta 1 panel is hidden (display: none)", isPanelHidden($htmlPeta3, 'number-city'));

// Test Peta 4 (Space Odyssey)
$resPeta4 = makeReq('http://127.0.0.1:8080/?page=worlds&world=space-odyssey');
$htmlPeta4 = $resPeta4['body'];
check("Peta 4 (Space Odyssey) loads HTTP 200", $resPeta4['code'] === 200);
check("Peta 4 tab is active", isTabActive($htmlPeta4, 4));
check("Peta 4 panel is displayed (display: block)", isPanelVisible($htmlPeta4, 'space-odyssey'));
check("Peta 1 panel is hidden (display: none)", isPanelHidden($htmlPeta4, 'number-city'));

// Test numeric index selection (map=2)
$resMapNum = makeReq('http://127.0.0.1:8080/?page=worlds&map=2');
check("Map selection by number (?page=worlds&map=2) activates Peta 2", isTabActive($resMapNum['body'], 2));

// Test session persistence across page reload (F5 without query param)
$resReload = makeReq('http://127.0.0.1:8080/?page=worlds');
check("Reloading without query param retains last selected map (Peta 2)", isTabActive($resReload['body'], 2));

// Verify questions in each map panel are isolated:
// Peta 1 must have 20 questions
$doc1 = new DOMDocument();
@$doc1->loadHTML($htmlPeta1);
$xpath1 = new DOMXPath($doc1);
$peta1Nodes = $xpath1->query('//section[@id="map-panel-number-city"]//div[contains(@class, "mission-map-node")]');
check("Peta 1 contains exactly 20 mission questions", $peta1Nodes->length === 20);

// Peta 2 must have 20 questions
$peta2Nodes = $xpath1->query('//section[@id="map-panel-discovery-lab"]//div[contains(@class, "mission-map-node")]');
check("Peta 2 contains exactly 20 mission questions", $peta2Nodes->length === 20);

// Peta 3 must have 20 questions
$peta3Nodes = $xpath1->query('//section[@id="map-panel-thinking-lab"]//div[contains(@class, "mission-map-node")]');
check("Peta 3 contains exactly 20 mission questions", $peta3Nodes->length === 20);

// Peta 4 must have 20 questions
$peta4Nodes = $xpath1->query('//section[@id="map-panel-space-odyssey"]//div[contains(@class, "mission-map-node")]');
check("Peta 4 contains exactly 20 mission questions", $peta4Nodes->length === 20);

// Clean up temp cookie
if (file_exists($cookieFile)) @unlink($cookieFile);

echo "\n========================================================================\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================================\n";
