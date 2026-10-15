<?php
/**
 * MISSION KIDS — All Pages MIKO AI Voice Verification Suite
 * Tests MIKO voice integration across EVERY single page in the application:
 * 1. Landing Page (?page=landing)
 * 2. Login Page (?page=login)
 * 3. Register Page (?page=register)
 * 4. Student Dashboard / Home (?page=home)
 * 5. Worlds Selection / Maps (?page=worlds)
 * 6. Achievements Page (?page=achievements)
 * 7. Student Profile / Progress (?page=progress)
 * 8. Mission Gameplay Page (?page=mission&slug=toko-kue)
 * 9. Dynamic Neural TTS Endpoint (?page=api&action=miko_tts)
 */

declare(strict_types=1);

$baseUrl = 'http://127.0.0.1:8080';
$passed = 0;
$total = 0;

function check(string $desc, bool $condition, string $detail = '') {
    global $passed, $total;
    $total++;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$desc}\n";
    } else {
        echo "  [FAIL] {$desc} " . ($detail ? "({$detail})" : "") . "\n";
    }
}

echo "========================================================================\n";
echo "  MISSION KIDS: ALL PAGES MIKO AI VOICE VERIFICATION\n";
echo "========================================================================\n\n";

$cookieFile = tempnam(sys_get_temp_dir(), 'mk_voice_test_');

function makeReq(string $url, string $method = 'GET', $data = null, array $headers = []): array {
    global $cookieFile;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if (is_array($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    }

    $mergedHeaders = array_merge(['Connection: close'], $headers);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $mergedHeaders);

    $body = curl_exec($ch);
    $info = curl_getinfo($ch);
    $error = curl_error($ch);
    curl_close($ch);

    return [
        'code' => $info['http_code'],
        'body' => (string)$body,
        'error' => $error,
        'url' => $info['url']
    ];
}

// 1. Audio Files on Disk
echo "--- 1. Audio Assets on Disk ---\n";
$requiredClips = [
    'greeting_default.mp3',
    'topic_intro.mp3',
    'topic_worlds.mp3',
    'topic_tips.mp3',
    'topic_cheer.mp3',
    'greeting_companion.mp3',
    'cheer_1.mp3',
    'cheer_2.mp3',
    'cheer_3.mp3',
    'cheer_4.mp3',
    'cheer_5.mp3',
    'avatar_greeting_1.mp3',
    'avatar_greeting_2.mp3',
    'avatar_greeting_3.mp3',
    'avatar_greeting_4.mp3',
    'avatar_greeting_5.mp3',
    'hint_preparing.mp3',
    'hint_level_1.mp3',
    'hint_level_2.mp3',
    'hint_level_3.mp3',
    'mission_welcome.mp3',
    'mission_retry.mp3',
    'mission_xp.mp3',
    'mission_success.mp3',
    'guide_toko_kue.mp3',
    'guide_jembatan_angka.mp3',
    'guide_kota_pola.mp3',
    'guide_tanaman_layu.mp3',
    'guide_misteri_bayangan.mp3',
    'guide_perjalanan_air.mp3',
    'guide_robot_pulang.mp3',
    'guide_jalan_rahasia.mp3',
    'guide_robot_mengulang.mp3',
    'guide_roket_angkasa.mp3',
    'guide_rasi_bintang.mp3',
    'guide_rover_mars.mp3'
];

$audioDir = __DIR__ . '/public/audio/miko';
foreach ($requiredClips as $clip) {
    $path = "{$audioDir}/{$clip}";
    check("Audio clip '{$clip}' exists (>10KB)", file_exists($path) && filesize($path) > 10000, "Size: " . (file_exists($path) ? filesize($path) : 0));
}

// 2. Public / Guest Pages
echo "\n--- 2. Public / Guest Pages ---\n";

// Landing Page
$r1 = makeReq("{$baseUrl}/?page=landing");
check("Landing page HTTP 200", $r1['code'] === 200);
check("Landing loads MikoCompanion.js?v=5.2", strpos($r1['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Landing has Miko avatar trigger", strpos($r1['body'], 'id="miko-avatar-trigger"') !== false);
check("Landing has Miko speech card", strpos($r1['body'], 'id="miko-speech-card"') !== false);
check("Landing has all 4 topic buttons", strpos($r1['body'], 'data-topic="intro"') !== false && strpos($r1['body'], 'data-topic="worlds"') !== false && strpos($r1['body'], 'data-topic="tips"') !== false && strpos($r1['body'], 'data-topic="cheer"') !== false);

// Login Page
$r2 = makeReq("{$baseUrl}/?page=login");
check("Login page HTTP 200", $r2['code'] === 200);
check("Login page loads MikoCompanion.js?v=5.2", strpos($r2['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Login page includes miko-dock floating companion", strpos($r2['body'], 'id="miko-dock"') !== false);

// Register Page
$r3 = makeReq("{$baseUrl}/?page=register");
check("Register page HTTP 200", $r3['code'] === 200);
check("Register page loads MikoCompanion.js?v=5.2", strpos($r3['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Register page includes miko-dock floating companion", strpos($r3['body'], 'id="miko-dock"') !== false);

// Register student to access authenticated pages
preg_match('/name="csrf_token" value="([^"]+)"/', $r3['body'], $m);
$csrf = $m[1] ?? '';
$u = 'tester_voice_' . time();
$rReg = makeReq("{$baseUrl}/?page=register", 'POST', [
    'csrf_token' => $csrf,
    'nickname' => 'Petualang Cilik',
    'username' => $u,
    'password' => 'pass123',
    'avatar_id' => 'clever_fox'
]);
check("Registration successful", $rReg['code'] === 200 && strpos($rReg['url'], 'page=home') !== false);

// 3. Authenticated Student Pages
echo "\n--- 3. Authenticated Student Pages ---\n";

// Home Page
$r4 = makeReq("{$baseUrl}/?page=home");
check("Student Home HTTP 200", $r4['code'] === 200);
check("Student Home loads MikoCompanion.js?v=5.2", strpos($r4['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Student Home includes miko-dock", strpos($r4['body'], 'id="miko-dock"') !== false);
check("Student Home has living avatar disc (#hero-avatar-disc)", strpos($r4['body'], 'id="hero-avatar-disc"') !== false);

// Worlds Page
$r5 = makeReq("{$baseUrl}/?page=worlds");
check("Worlds Page HTTP 200", $r5['code'] === 200);
check("Worlds Page loads MikoCompanion.js?v=5.2", strpos($r5['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Worlds Page includes miko-dock", strpos($r5['body'], 'id="miko-dock"') !== false);

// Achievements Page
$r6 = makeReq("{$baseUrl}/?page=achievements");
check("Achievements Page HTTP 200", $r6['code'] === 200);
check("Achievements Page loads MikoCompanion.js?v=5.2", strpos($r6['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Achievements Page includes miko-dock", strpos($r6['body'], 'id="miko-dock"') !== false);

// Progress Page
$r7 = makeReq("{$baseUrl}/?page=progress");
check("Progress Page HTTP 200", $r7['code'] === 200);
check("Progress Page loads MikoCompanion.js?v=5.2", strpos($r7['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Progress Page includes miko-dock", strpos($r7['body'], 'id="miko-dock"') !== false);

// Mission Play Page
$r8 = makeReq("{$baseUrl}/?page=mission&slug=toko-kue");
check("Mission Play HTTP 200", $r8['code'] === 200);
check("Mission Play loads MikoCompanion.js?v=5.2", strpos($r8['body'], 'MikoCompanion.js?v=5.2') !== false);
check("Mission Play loads MissionEngine.js?v=5.2", strpos($r8['body'], 'MissionEngine.js?v=5.2') !== false);
check("Mission Play includes miko-dock", strpos($r8['body'], 'id="miko-dock"') !== false);
check("Mission Play has guide listen button (#btn-listen-miko-guide)", strpos($r8['body'], 'id="btn-listen-miko-guide"') !== false);
check("Mission Play has modal challenge voice button (#btn-modal-speak-miko)", strpos($r8['body'], 'id="btn-modal-speak-miko"') !== false);
check("Mission Play has reward screen voice replay button (#btn-replay-reward-miko)", strpos($r8['body'], 'id="btn-replay-reward-miko"') !== false);

// 4. Dynamic Neural TTS Endpoint
echo "\n--- 4. Dynamic Neural TTS Endpoint ---\n";
$ttsUrl = "{$baseUrl}/?page=api&action=miko_tts&text=" . urlencode("Semangat belajar bersama Miko");
$r9 = makeReq($ttsUrl);
check("API miko_tts returns HTTP 200", $r9['code'] === 200);
$json = json_decode($r9['body'], true);
check("API miko_tts returns success: true", !empty($json['success']));
check("API miko_tts returns valid audio_url", !empty($json['audio_url']) && strpos($json['audio_url'], '/audio/miko/cache/') === 0);

@unlink($cookieFile);

echo "\n========================================================================\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================================\n";

if ($passed !== $total) {
    exit(1);
}
exit(0);
