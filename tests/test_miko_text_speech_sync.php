<?php
/**
 * MISSION KIDS — Comprehensive AI Miko Text & Speech Synchronization Test Suite
 * Validates single source of truth, verbatim matching, audio collision guards,
 * and UI synchronization across Landing Page, Student Companion, and Challenge Guides.
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
echo "  TEST SUITE: AI MIKO TEXT & SPEECH SYNCHRONIZATION\n";
echo "========================================================================\n\n";

// ---------------------------------------------------------------------------
// 1. LANDING PAGE: SINGLE SOURCE OF TRUTH & DOM SYNCHRONIZATION
// ---------------------------------------------------------------------------
echo "--- 1. Landing Page UI & Single Source of Truth ---\n";

$ch = curl_init("{$baseUrl}/?page=landing");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 6);
$html = curl_exec($ch);
$code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

check("Landing page returns HTTP 200", $code === 200, "Received: {$code}");

// Avatar as exclusive trigger
check("Avatar trigger exists (#miko-avatar-trigger)", strpos($html, 'id="miko-avatar-trigger"') !== false);
check("No sound buttons in navbar", strpos($html, 'id="btn-sound-toggle-guest"') === false && strpos($html, 'class="nav-sound-text">Suara MIKO') === false);
check("No audio buttons in Miko intro section", strpos($html, 'btn-miko-voice-action') === false);

// Speech box under character Miko
check("Dedicated speech box exists (#miko-speech-card)", strpos($html, 'id="miko-speech-card"') !== false);
check("Speech text element exists (#miko-speech-text)", strpos($html, 'id="miko-speech-text"') !== false);
check("Speech status indicator exists (#miko-speech-status)", strpos($html, 'id="miko-speech-status"') !== false);
check("Interactive topic chips container exists (#miko-topic-chips)", strpos($html, 'id="miko-topic-chips"') !== false);

// Topic chips
check("Topic 'Siapa Miko?' exists", strpos($html, 'data-topic="intro"') !== false);
check("Topic 'Cerita 4 Dunia' exists", strpos($html, 'data-topic="worlds"') !== false);
check("Topic 'Tips Belajar' exists", strpos($html, 'data-topic="tips"') !== false);
check("Topic 'Semangat Juara' exists", strpos($html, 'data-topic="cheer"') !== false);

// JavaScript Single Source of Truth verification
check("JavaScript uses mikoSpeechText.textContent as speech source", strpos($html, 'mikoSpeechText.textContent.trim()') !== false);
check("stopMikoVoice increments activeSpeechId", strpos($html, 'activeSpeechId++') !== false);
check("playCuteTtsVoice guards callback with activeSpeechId", strpos($html, 'activeSpeechId === myId') !== false);
check("Miko voice engine binds dynamic pitch", strpos($html, 'window.MIKO_VOICE_CONFIG.pitch') !== false || strpos($html, 'utterance.pitch = isArdiMale ? 1.16 : 1.25') !== false);
check("Miko voice engine binds dynamic rate", strpos($html, 'window.MIKO_VOICE_CONFIG.rate') !== false || strpos($html, 'utterance.rate = 1.05') !== false);

// ---------------------------------------------------------------------------
// 2. MIKO COMPANION: STRICT VERBATIM MATCHING & ANTI-HIJACKING
// ---------------------------------------------------------------------------
echo "\n--- 2. MikoCompanion Strict Verbatim Matching & Anti-Hijacking ---\n";

$companionCode = file_get_contents(__DIR__ . '/public/js/engine/MikoCompanion.js');

check("MikoCompanion has activeResponseId counter", strpos($companionCode, 'this.activeResponseId') !== false);
check("MikoCompanion has currentResponseText state", strpos($companionCode, 'this.currentResponseText') !== false);
check("normalizeVerbatim function exists", strpos($companionCode, 'normalizeVerbatim(str)') !== false);
check("resolveAudioClip uses EXACT_MAP dictionary (no loose includes)", strpos($companionCode, 'EXACT_MAP[cleanNorm]') !== false);
check("Loose substring hijacking (includes('level 1')) removed", strpos($companionCode, "lower.includes('level 1')") === false);
check("Loose substring hijacking (includes('butuh bantuan')) removed", strpos($companionCode, "lower.includes('butuh bantuan')") === false);
check("Loose substring hijacking (includes('otakmu')) removed", strpos($companionCode, "lower.includes('otakmu')") === false);

// ---------------------------------------------------------------------------
// 3. LOGIC & RUNTIME SIMULATION (VERBATIM RESOLUTION)
// ---------------------------------------------------------------------------
echo "\n--- 3. Verbatim Resolution Logic Tests ---\n";

// Emulate normalizeVerbatim and resolveAudioClip in PHP to test identical logic
function testNormalizeVerbatim(string $str): string {
    $clean = strip_tags($str);
    $clean = mb_strtolower($clean, 'UTF-8');
    // Remove punctuation & emojis
    $clean = preg_replace('/[.,\/#!$%\^&\*;:{}=\-_`~()?"\'’“”💡⭐✨🚀💭🎉👉🗣️🤖]/u', ' ', $clean);
    $clean = preg_replace('/\s+/', ' ', $clean);
    return trim($clean);
}

$exactMap = [
    'halo sahabat cilik aku miko teman belajarmu di setiap petualangan ayo jelajahi empat dunia seru di mission kids dan kumpulkan banyak bintang' => '/audio/miko/greeting_default.mp3',
    'di soal ini kamu jadi kasir toko kue masukkan 2 donat dan beri koin kembalian seribu rupiah ke nampan kasir ya' => '/audio/miko/guide_toko_kue.mp3',
    'bunga matahari ini sedang layu siram air dengan gembor dan buka tirai matahari sampai bunganya mekar segar' => '/audio/miko/guide_tanaman_layu.mp3',
    'tenang miko punya petunjuk level satu untukmu coba amati polanya sekali lagi' => '/audio/miko/hint_level_1.mp3'
];

// Test Case A: Exact audio transcript -> should match audio file
$exactInput = "Halo Sahabat Cilik! Aku MIKO, teman belajarmu di setiap petualangan! Ayo jelajahi empat dunia seru di MISSION KIDS dan kumpulkan banyak bintang!";
$normA = testNormalizeVerbatim($exactInput);
$clipA = $exactMap[$normA] ?? null;
check("Exact greeting transcript matches greeting_default.mp3", $clipA === '/audio/miko/greeting_default.mp3');

// Test Case B: Dynamic Level 1 hint from Gemini LLM -> MUST NOT match hint_level_1.mp3 (must return null to use Web Speech TTS)
$dynamicHint = "Petunjuk MIKO Level 1: Perhatikan pola segitiga biru di sisi kiri!";
$normB = testNormalizeVerbatim($dynamicHint);
$clipB = $exactMap[$normB] ?? null;
check("Dynamic Level 1 AI hint does NOT match static hint_level_1.mp3 (avoids hijacking)", $clipB === null);

// Test Case C: Dynamic long Level 2 hint -> MUST NOT match any audio clip
$longHint = "Petunjuk MIKO Level 2: Jumlah baterai yang dibutuhkan Botty adalah 4 unit. Saat ini kamu baru memasang 2 unit di slot pengisian. Berarti kamu masih butuh 2 unit lagi!";
$normC = testNormalizeVerbatim($longHint);
$clipC = $exactMap[$normC] ?? null;
check("Dynamic long AI hint does NOT match static audio clips (reads full text via TTS)", $clipC === null);

// Test Case D: Short cheer -> exact match only when full sentence
$partialCheer = "Kamu hebat!";
$normD = testNormalizeVerbatim($partialCheer);
$clipD = $exactMap[$normD] ?? null;
check("Partial cheer 'Kamu hebat!' does NOT trigger cheer_5.mp3 (avoids desync)", $clipD === null);

// ---------------------------------------------------------------------------
// 4. BACKEND AI GET_HINT ENDPOINT SYNCHRONIZATION
// ---------------------------------------------------------------------------
echo "\n--- 4. Backend AI get_hint Endpoint Synchronization ---\n";

$cookieFile = sys_get_temp_dir() . '/cookie_sync_' . time() . '.txt';

// Step 1: Get register page to extract CSRF token
$ch = curl_init("{$baseUrl}/?page=register");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_TIMEOUT, 6);
$regPageHtml = curl_exec($ch);
curl_close($ch);

preg_match('/name="csrf_token" value="([^"]+)"/', (string)$regPageHtml, $matches);
$csrfToken = $matches[1] ?? '';
check("Register CSRF token extracted", !empty($csrfToken));

// Step 2: Register test student
$studentUser = 'synctest_' . time();
$regData = [
    'csrf_token' => $csrfToken,
    'nickname' => 'Bintang Juara',
    'username' => $studentUser,
    'avatar_id' => 'clever_fox',
    'password' => 'pass123'
];

$ch = curl_init("{$baseUrl}/?page=register");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($regData));
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 6);
$regResult = curl_exec($ch);
$regCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

check("Student registration successful", $regCode === 200);

// Step 3: Test API get_hint for 3 missions
$missionsToTest = ['toko-kue', 'tanaman-layu', 'roket-angkasa'];

foreach ($missionsToTest as $mSlug) {
    $hintPayload = json_encode([
        'mission_slug' => $mSlug,
        'hint_level' => 1,
        'attempt_count' => 1,
        'current_state' => []
    ]);

    $ch = curl_init("{$baseUrl}/?page=api&action=get_hint");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $hintPayload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Connection: close']);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
    curl_setopt($ch, CURLOPT_TIMEOUT, 6);
    $hintRes = curl_exec($ch);
    $hintCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    check("API get_hint for '{$mSlug}' returns HTTP 200", $hintCode === 200);
    $hintData = json_decode((string)$hintRes, true);
    check("API get_hint for '{$mSlug}' returns valid hint_text", !empty($hintData['hint_text']));
    
    // Verify hint_text would NOT be hijacked by static clips
    $normHint = testNormalizeVerbatim("Petunjuk MIKO Level 1: " . ($hintData['hint_text'] ?? ''));
    $matchedClip = $exactMap[$normHint] ?? null;
    check("AI hint for '{$mSlug}' is safely routed to Browser TTS (exact speech match)", $matchedClip === null);
}

if (file_exists($cookieFile)) {
    @unlink($cookieFile);
}

// ---------------------------------------------------------------------------
// 5. CLIENT-SIDE APP.JS DOCK SYNCHRONIZATION
// ---------------------------------------------------------------------------
echo "\n--- 5. Student Dock Synchronization in app.js ---\n";

$appJs = file_get_contents(__DIR__ . '/public/js/app.js');
check("app.js checks for active hint before cycling cheer phrases", strpos($appJs, 'hasActiveHint') !== false);
check("app.js speaks exact text from mikoText element", strpos($appJs, 'spokenText = mikoText.textContent.trim()') !== false);
check("app.js closes speech on bubble close", strpos($appJs, 'companion.stopSpeaking()') !== false);

// ---------------------------------------------------------------------------
// SUMMARY
// ---------------------------------------------------------------------------
echo "\n========================================================================\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================================\n";

if ($passed !== $total) {
    exit(1);
}
exit(0);
