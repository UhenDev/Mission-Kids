<?php
/**
 * MISSION KIDS — Dynamic 3D Human Avatars Verification Test
 */

declare(strict_types=1);

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/src/Helpers/Avatar.php';
require_once __DIR__ . '/src/Services/AuthService.php';

echo "\n======================================================\n";
echo "  MISSION KIDS — DYNAMIC 3D HUMAN AVATARS TEST SUITE\n";
echo "======================================================\n\n";

$testsPassed = 0;
$totalTests = 0;

function assertCondition(string $name, bool $condition, string $details = ''): void {
    global $testsPassed, $totalTests;
    $totalTests++;
    if ($condition) {
        $testsPassed++;
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name} - {$details}\n";
    }
}

// 1. Verify 8 Human Characters
$expectedChars = ['kian', 'sera', 'raka', 'nara', 'dika', 'bayu', 'fajar', 'luna'];
$allAvatars = Avatar::all();

assertCondition("Total Avatars is exactly 8", count($allAvatars) === 8, "Got: " . count($allAvatars));

foreach ($expectedChars as $charId) {
    assertCondition("Avatar '{$charId}' exists in Avatar::all()", isset($allAvatars[$charId]));
    
    $char = $allAvatars[$charId] ?? [];
    $hasFields = !empty($char['name']) && !empty($char['role']) && !empty($char['title']) && 
                 !empty($char['desc']) && !empty($char['image']) && !empty($char['thumb']);
    assertCondition("Avatar '{$charId}' has complete metadata", $hasFields);

    // Verify Asset Files on Disk
    $fullImagePath = __DIR__ . '/public/' . ($char['image'] ?? '');
    $thumbImagePath = __DIR__ . '/public/' . ($char['thumb'] ?? '');

    assertCondition("Asset image exists for '{$charId}'", file_exists($fullImagePath), $fullImagePath);
    assertCondition("Asset thumb exists for '{$charId}'", file_exists($thumbImagePath), $thumbImagePath);

    if (file_exists($fullImagePath)) {
        assertCondition("Asset image size > 10KB for '{$charId}'", filesize($fullImagePath) > 10240);
    }
    if (file_exists($thumbImagePath)) {
        assertCondition("Asset thumb size > 2KB for '{$charId}'", filesize($thumbImagePath) > 2048);
    }
}

// 2. Test Avatar validation & normalization
assertCondition("Avatar::isValid('kian') is true", Avatar::isValid('kian'));
assertCondition("Avatar::isValid('luna') is true", Avatar::isValid('luna'));
assertCondition("Avatar::isValid('invalid_alien') is false", !Avatar::isValid('invalid_alien'));
assertCondition("Avatar::normalize('astro_cat') maps to 'kian'", Avatar::normalize('astro_cat') === 'kian');
assertCondition("Avatar::normalize('super_bear') maps to 'raka'", Avatar::normalize('super_bear') === 'raka');
assertCondition("Avatar::normalize('clever_fox') maps to 'sera'", Avatar::normalize('clever_fox') === 'sera');

// 3. Test Registration and Profile persistence for each character
$auth = new AuthService();
$pdo = Database::getConnection();

foreach ($expectedChars as $charId) {
    $charInfo = $allAvatars[$charId];
    $testUser = 'user_' . $charId . '_' . substr(uniqid(), -5);
    $reg = $auth->register($testUser, 'pass1234', 'Kak ' . $charInfo['name'], $charId);
    
    assertCondition("Register student with avatar '{$charId}'", $reg['success'] === true, $reg['error'] ?? '');
    $userId = (int)($reg['user_id'] ?? 0);

    // Check DB row
    $stmt = $pdo->prepare("SELECT nickname, avatar_id FROM profiles WHERE user_id = :uid LIMIT 1");
    $stmt->execute([':uid' => $userId]);
    $prof = $stmt->fetch(PDO::FETCH_ASSOC);

    assertCondition("DB profiles.avatar_id correctly stored as '{$charId}'", ($prof['avatar_id'] ?? '') === $charId);

    // Check Profile Retrieval
    $studentProf = $auth->getStudentProfile($userId);
    assertCondition("Profile retrieval returns avatar_id '{$charId}'", ($studentProf['avatar_id'] ?? '') === $charId);
}

// 4. Test HTTP Register Page Output
$ch = curl_init('http://127.0.0.1:8080/?page=register');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 5
]);
$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

assertCondition("GET /?page=register returns HTTP 200", $httpCode === 200);
assertCondition("Register HTML contains auth-hero-character-img", strpos($html, 'id="auth-hero-character-img"') !== false);
assertCondition("Register HTML contains auth-visual-char-title", strpos($html, 'id="auth-visual-char-title"') !== false);
assertCondition("Register HTML contains auth-visual-char-desc", strpos($html, 'id="auth-visual-char-desc"') !== false);
assertCondition("Register HTML contains avatar-grid-8", strpos($html, 'class="avatar-grid-8"') !== false);

foreach ($expectedChars as $charId) {
    assertCondition("Register page contains radio for '{$charId}'", strpos($html, 'value="' . $charId . '"') !== false);
    assertCondition("Register page contains thumb for '{$charId}'", strpos($html, $charId . '-thumb.png') !== false);
}

echo "\n======================================================\n";
echo "  FINAL RESULT: {$testsPassed} / {$totalTests} TESTS PASSED\n";
echo "======================================================\n\n";

if ($testsPassed === $totalTests) {
    exit(0);
} else {
    exit(1);
}
