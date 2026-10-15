<?php
/**
 * Test Suite: MIKO Voice Interaction Simplification Verification
 */

$ch = curl_init('http://127.0.0.1:8080/?page=landing');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

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
echo "  MIKO VOICE INTERACTION SIMPLIFICATION TESTS\n";
echo "========================================================\n\n";

check("HTTP 200 on landing page", $httpCode === 200, "Received code: {$httpCode}");

// 1. Navbar Verification
check("Navbar does not have 'btn-sound-toggle-guest'", strpos($html, 'id="btn-sound-toggle-guest"') === false);
check("Navbar does not have 'Suara MIKO' button", strpos($html, 'class="nav-sound-text">Suara MIKO') === false);
check("Navbar retains balanced login button ('btn-nav-auth-login')", strpos($html, 'class="btn-kid btn-nav-auth-login"') !== false);
check("Navbar retains balanced register button ('btn-nav-auth-register')", strpos($html, 'class="btn-kid btn-nav-auth-register"') !== false);

// 2. "Kenalan dengan MIKO" Section Verification
check("Section #miko does NOT have 'btn-miko-voice-action'", strpos($html, 'id="btn-miko-voice-action"') === false);
check("Section #miko does NOT have old button text 'Dengar Suara MIKO'", strpos($html, 'Dengar Suara MIKO') === false);
check("Section #miko retains title 'Kenalan dengan MIKO'", strpos($html, 'Kenalan dengan MIKO') !== false);
check("Section #miko retains narrative description", strpos($html, 'MIKO adalah AI Companion yang selalu menemani') !== false);

// 3. Interactive Avatar Verification
check("Miko avatar is interactive button (#miko-avatar-trigger)", strpos($html, 'id="miko-avatar-trigger"') !== false);
check("Miko avatar has role='button'", strpos($html, 'role="button"') !== false);
check("Miko avatar has tabindex='0'", strpos($html, 'tabindex="0"') !== false);
check("Miko avatar has aria-label 'Klik Miko untuk mendengarkan suaraku!'", strpos($html, 'aria-label="Klik Miko untuk mendengarkan suaraku!"') !== false);
check("Miko avatar has title tooltip 'Klik Miko untuk mendengarkan suaraku!'", strpos($html, 'title="Klik Miko untuk mendengarkan suaraku!"') !== false);

// 4. Visual Feedback Indicators
check("Speaking halo element present (.miko-speaking-halo)", strpos($html, 'class="miko-speaking-halo"') !== false);
check("Voice wave indicator element present (.miko-voice-wave-indicator)", strpos($html, 'class="miko-voice-wave-indicator"') !== false);
check("Interactive hint pill present (#miko-click-hint)", strpos($html, 'id="miko-click-hint"') !== false);
check("Hint pill text contains 'Klik Miko untuk mendengarkan suaraku!'", strpos($html, 'Klik Miko untuk mendengarkan suaraku!') !== false);

// 5. JavaScript Implementation Verification
check("JavaScript binds to miko-avatar-trigger", strpos($html, "document.getElementById('miko-avatar-trigger')") !== false);
check("JavaScript handles click event on avatar", strpos($html, "mikoAvatarTrigger.addEventListener('click'") !== false);
check("JavaScript handles keyboard keydown on avatar", strpos($html, "mikoAvatarTrigger.addEventListener('keydown'") !== false);
check("JavaScript prevents duplicate audio playback via stopMikoVoice", strpos($html, "function stopMikoVoice()") !== false);
check("JavaScript plays star sound and companion message on click", strpos($html, "playMikoVoice()") !== false);
check("No automatic audio autoplay on page load", strpos($html, "autoplay") === false);

echo "\n--------------------------------------------------------\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================\n";

if ($passed !== $total) {
    exit(1);
}
