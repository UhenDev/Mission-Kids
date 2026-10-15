<?php
/**
 * MISSION KIDS — Login Page Test Script
 * Verifies HTTP rendering, form elements, CSRF, valid login, invalid login, and error handling
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Services/AuthService.php';

echo "\n======================================================\n";
echo "  MISSION KIDS — LOGIN PAGE AUTOMATED VERIFICATION\n";
echo "======================================================\n\n";

$testsPassed = 0;
$totalTests = 0;

function assertCheck(string $name, bool $condition, string $details = ''): void {
    global $testsPassed, $totalTests;
    $totalTests++;
    if ($condition) {
        $testsPassed++;
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name} - {$details}\n";
    }
}

// 1. Check landscape image exists and is readable
$landscapePath = __DIR__ . '/public/assets/images/login-adventure-landscape.jpg';
assertCheck("Landscape asset file exists on disk", file_exists($landscapePath), $landscapePath);
if (file_exists($landscapePath)) {
    assertCheck("Landscape asset file size > 50KB", filesize($landscapePath) > 50000);
}

// 2. Fetch GET /?page=login
$cookieFile = sys_get_temp_dir() . '/mk_cookie_' . uniqid() . '.txt';

$ch = curl_init('http://127.0.0.1:8080/?page=login');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_TIMEOUT => 5
]);
$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

assertCheck("GET /?page=login returns HTTP 200", $httpCode === 200);

// 3. Inspect DOM elements for reference fidelity
assertCheck("Contains .login-page-section wrapper", strpos($html, 'class="login-page-section"') !== false);
assertCheck("Contains .login-master-card element", strpos($html, 'class="login-master-card"') !== false);
assertCheck("Contains .login-panel-visual element", strpos($html, 'class="login-panel-visual"') !== false);
assertCheck("Contains .login-panel-form element", strpos($html, 'class="login-panel-form"') !== false);
assertCheck("Contains headline 'Petualangan Hebatmu'", strpos($html, 'Petualangan Hebatmu') !== false);
assertCheck("Contains title 'Masuk ke Akun Anda'", strpos($html, 'Masuk ke Akun Anda') !== false);
assertCheck("Contains 'Nama Pengguna' label", strpos($html, 'Nama Pengguna') !== false);
assertCheck("Contains 'Kata Sandi' label", strpos($html, 'Kata Sandi') !== false);
assertCheck("Contains 'Ingat saya' checkbox", strpos($html, 'Ingat saya') !== false);
assertCheck("Contains 'Bantuan?' trigger", strpos($html, 'Bantuan?') !== false);
assertCheck("Contains Help Modal dialog", strpos($html, 'id="help-modal"') !== false);
assertCheck("Contains 'Masuk ➔' submit button", strpos($html, 'id="btn-submit-login"') !== false);
assertCheck("Contains 'Daftar sekarang' link", strpos($html, '?page=register') !== false);
assertCheck("Contains navbar brand and buttons", strpos($html, 'btn-nav-auth-login') !== false && strpos($html, 'btn-nav-auth-register') !== false);
assertCheck("Navbar does not contain removed sound button", strpos($html, 'btn-sound-toggle-guest') === false);

// 4. Extract CSRF token
preg_match('/name="csrf_token"\s+value="([^"]+)"/', $html, $matches);
$csrfToken = $matches[1] ?? '';
assertCheck("Extracted valid CSRF token from login form", strlen($csrfToken) === 64);

// 5. Test invalid login attempt (wrong credentials)
$ch = curl_init('http://127.0.0.1:8080/?page=login');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'csrf_token' => $csrfToken,
        'username' => 'nonexistent_kid_9999',
        'password' => 'wrong_password_123'
    ]),
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_TIMEOUT => 5
]);
$badLoginHtml = curl_exec($ch);
$badCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

assertCheck("Invalid login returns HTTP 200 with error page", $badCode === 200);
assertCheck("Error page displays friendly error banner", strpos($badLoginHtml, 'Nama pengguna atau kata sandi') !== false);

// 6. Test successful student login flow
$auth = new AuthService();
$testUser = 'login_user_' . substr(uniqid(), -5);
$reg = $auth->register($testUser, 'rahasia123', 'Budi Hebat', 'kian');
assertCheck("Created test student account", $reg['success'] === true);

// Get fresh CSRF
$ch = curl_init('http://127.0.0.1:8080/?page=login');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_TIMEOUT => 5
]);
$freshHtml = curl_exec($ch);
curl_close($ch);
preg_match('/name="csrf_token"\s+value="([^"]+)"/', $freshHtml, $matches);
$freshCsrf = $matches[1] ?? '';

// Submit valid credentials
$ch = curl_init('http://127.0.0.1:8080/?page=login');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => http_build_query([
        'csrf_token' => $freshCsrf,
        'username' => $testUser,
        'password' => 'rahasia123',
        'remember_me' => '1'
    ]),
    CURLOPT_COOKIEJAR => $cookieFile,
    CURLOPT_COOKIEFILE => $cookieFile,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_TIMEOUT => 5
]);
$successHtml = curl_exec($ch);
$finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
curl_close($ch);

assertCheck("Valid login redirects successfully to home", strpos($finalUrl, 'page=home') !== false);
assertCheck("Dashboard welcomes student by nickname", strpos($successHtml, 'Halo, Budi Hebat!') !== false);

@unlink($cookieFile);

echo "\n======================================================\n";
echo "  FINAL RESULT: {$testsPassed} / {$totalTests} TESTS PASSED\n";
echo "======================================================\n\n";

if ($testsPassed === $totalTests) {
    exit(0);
} else {
    exit(1);
}
