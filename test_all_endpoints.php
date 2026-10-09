<?php
/**
 * Comprehensive Automated Endpoint and Flow Verification for MISSION KIDS
 */

$baseUrl = 'http://127.0.0.1:8080';
$cookieFile = __DIR__ . '/test_flow_cookies.txt';
if (file_exists($cookieFile)) unlink($cookieFile);

function makeRequest(string $url, string $method = 'GET', $data = null, array $headers = []) {
    global $cookieFile;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        if (is_array($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
    }

    if (!empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    $body = curl_exec($ch);
    $info = curl_getinfo($ch);
    $error = curl_error($ch);
    curl_close($ch);

    return [
        'code' => $info['http_code'],
        'body' => $body,
        'error' => $error,
        'url' => $info['url']
    ];
}

$tests = [];
function assertTest(string $name, bool $condition, string $detail = '') {
    global $tests;
    $tests[] = ['name' => $name, 'pass' => $condition, 'detail' => $detail];
    $status = $condition ? '[PASS]' : '[FAIL]';
    echo "  {$status} {$name}" . ($condition ? '' : " - {$detail}") . "\n";
}

echo "==========================================\n";
echo "  MISSION KIDS ENDPOINT & FLOW VERIFICATION\n";
echo "==========================================\n\n";

// 1. Landing Page
$res = makeRequest($baseUrl . '/?page=landing');
assertTest('GET /?page=landing (HTTP 200)', $res['code'] === 200, "Code: {$res['code']}");
assertTest('Landing has title & branding', strpos($res['body'], 'MISSION KIDS') !== false && strpos($res['body'], 'Petualangan Misimu Dimulai di Sini.') !== false);
assertTest('Landing has CSS links', strpos($res['body'], 'design-system.css') !== false);

// 2. Login Page
$res = makeRequest($baseUrl . '/?page=login');
assertTest('GET /?page=login (HTTP 200)', $res['code'] === 200);
assertTest('Login contains form & CSRF', strpos($res['body'], 'name="csrf_token"') !== false);
preg_match('/name="csrf_token" value="([^"]+)"/', $res['body'], $matches);
$loginCsrf = $matches[1] ?? '';

// 3. Register Page
$res = makeRequest($baseUrl . '/?page=register');
assertTest('GET /?page=register (HTTP 200)', $res['code'] === 200);
preg_match('/name="csrf_token" value="([^"]+)"/', $res['body'], $matches);
$regCsrf = $matches[1] ?? '';
assertTest('Register CSRF extracted', !empty($regCsrf));

// 4. Registration Flow
$testUser = 'tester_' . time();
$regData = [
    'csrf_token' => $regCsrf,
    'nickname' => 'Petualang Cilik',
    'username' => $testUser,
    'avatar_id' => 'clever_fox',
    'password' => 'pass123'
];
$res = makeRequest($baseUrl . '/?page=register', 'POST', $regData);
assertTest('POST /?page=register succeeds and redirects to home', $res['code'] === 200 && strpos($res['url'], 'page=home') !== false);
assertTest('Home displays student greeting', strpos($res['body'], 'Halo, Petualang Cilik!') !== false);

// 5. Student Authenticated Pages
$res = makeRequest($baseUrl . '/?page=home');
assertTest('GET /?page=home (HTTP 200)', $res['code'] === 200);
assertTest('Home contains worlds & skills', strpos($res['body'], 'Dunia Petualangan') !== false && strpos($res['body'], 'Jejak Keterampilan Belajar') !== false);

$res = makeRequest($baseUrl . '/?page=worlds');
assertTest('GET /?page=worlds (HTTP 200)', $res['code'] === 200);
assertTest('Worlds displays 3 worlds', strpos($res['body'], 'Number City') !== false && strpos($res['body'], 'Discovery Lab') !== false && strpos($res['body'], 'Thinking Lab') !== false);

$res = makeRequest($baseUrl . '/?page=achievements');
assertTest('GET /?page=achievements (HTTP 200)', $res['code'] === 200);
assertTest('Achievements page rendered', strpos($res['body'], 'Ruang Medali Petualang Cilik') !== false);

$res = makeRequest($baseUrl . '/?page=progress');
assertTest('GET /?page=progress (HTTP 200)', $res['code'] === 200);
assertTest('Progress page rendered', strpos($res['body'], 'Perjalanan Keterampilan Cilik') !== false);

// 6. Test All 9 Mission Game Pages
$missions = [
    'toko-kue', 'jembatan-angka', 'kota-pola',
    'tanaman-layu', 'misteri-bayangan', 'perjalanan-air',
    'robot-pulang', 'jalan-rahasia', 'robot-mengulang'
];

foreach ($missions as $mSlug) {
    $res = makeRequest($baseUrl . '/?page=mission&slug=' . $mSlug);
    assertTest("GET /?page=mission&slug={$mSlug}", $res['code'] === 200 && strpos($res['body'], 'CURRENT_MISSION') !== false);
}

// 7. Test API get_hint
$hintPayload = json_encode([
    'mission_slug' => 'tanaman-layu',
    'hint_level' => 1,
    'attempt_count' => 0,
    'current_state' => ['water' => 20, 'sunlight' => 20]
]);
$res = makeRequest($baseUrl . '/?page=api&action=get_hint', 'POST', $hintPayload, ['Content-Type: application/json']);
$hintData = json_decode($res['body'], true);
assertTest('POST API get_hint returns success', !empty($hintData['success']) && !empty($hintData['hint_text']));

// 8. Test API record_attempt (With CSRF)
$attemptPayload = json_encode([
    'mission_id' => 4,
    'hints_used' => 1,
    'is_success' => true,
    'reflection_answer' => 'Tanaman butuh air dan matahari secukupnya'
]);
$res = makeRequest($baseUrl . '/?page=api&action=record_attempt', 'POST', $attemptPayload, [
    'Content-Type: application/json',
    'X-CSRF-Token: ' . $regCsrf
]);
$attemptData = json_decode($res['body'], true);
assertTest('POST API record_attempt returns success', !empty($attemptData['success']));

// 9. Test API complete_mission: CSRF Reject Test without Token
$badCompRes = makeRequest($baseUrl . '/?page=api&action=complete_mission', 'POST', json_encode(['mission_id' => 4]), [
    'Content-Type: application/json'
]);
assertTest('POST API complete_mission rejects missing CSRF (HTTP 403)', $badCompRes['code'] === 403);

// 10. Test API complete_mission (With valid CSRF)
$compPayload = json_encode([
    'mission_id' => 4,
    'hints_used' => 0,
    'reflection_answer' => 'Tanaman butuh air dan sinar matahari yang cukup seimbang.'
]);
$res = makeRequest($baseUrl . '/?page=api&action=complete_mission', 'POST', $compPayload, [
    'Content-Type: application/json',
    'X-CSRF-Token: ' . $regCsrf
]);
$compData = json_decode($res['body'], true);
assertTest('POST API complete_mission awards XP and stars', !empty($compData['success']) && isset($compData['stars']) && $compData['stars'] >= 1);

// 11. Test API update_profile (With CSRF)
$profPayload = json_encode([
    'nickname' => 'Kapten Bintang',
    'avatar_id' => 'super_bear'
]);
$res = makeRequest($baseUrl . '/?page=api&action=update_profile', 'POST', $profPayload, [
    'Content-Type: application/json',
    'X-CSRF-Token: ' . $regCsrf
]);
$profData = json_decode($res['body'], true);
assertTest('POST API update_profile returns success', !empty($profData['success']));

// 11. Test Logout
$res = makeRequest($baseUrl . '/?page=logout');
assertTest('GET /?page=logout redirects to landing', $res['code'] === 200 && strpos($res['url'], 'page=landing') !== false);

// 12. Cleanup cookie
if (file_exists($cookieFile)) unlink($cookieFile);

$passed = count(array_filter($tests, fn($t) => $t['pass']));
$total = count($tests);

echo "\n==========================================\n";
echo "  FINAL RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "==========================================\n";

if ($passed !== $total) {
    exit(1);
}
