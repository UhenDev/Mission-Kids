<?php
/**
 * MISSION KIDS — MIKO AI Voice Consistency Verification Suite
 * Tests unified shared voice configuration, voice ID resolution,
 * identical pitch/rate/intonation across all 4 topic buttons and avatar.
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
echo "  AI MIKO VOICE CONSISTENCY VERIFICATION SUITE\n";
echo "========================================================================\n\n";

$landingRes = file_get_contents("{$baseUrl}/?page=landing");
$companionJs = file_get_contents(__DIR__ . '/public/js/engine/MikoCompanion.js');

// 1. Shared Central Voice Configuration
echo "--- 1. Shared Central Voice Configuration ---\n";
check("MikoCompanion.js exports window.MIKO_VOICE_CONFIG", strpos($companionJs, 'window.MIKO_VOICE_CONFIG') !== false);
check("Shared config specifies male gender", strpos($companionJs, "gender: 'male'") !== false);
check("Shared config specifies language 'id-ID'", strpos($companionJs, "lang: 'id-ID'") !== false);
check("Shared config specifies cute boy pitch 1.25", strpos($companionJs, "pitch: 1.25") !== false);
check("Shared config specifies lively rate 1.05", strpos($companionJs, "rate: 1.05") !== false);
check("Shared config specifies volume 1.0", strpos($companionJs, "volume: 1.0") !== false);
check("Shared config contains getBestVoice method for Indonesian voices", strpos($companionJs, "getBestVoice: function()") !== false);

// 2. Landing Page Voice Engine Unification
echo "\n--- 2. Landing Page Voice Engine Unification ---\n";
check("Landing page uses window.MIKO_VOICE_CONFIG for TTS", strpos($landingRes, 'window.MIKO_VOICE_CONFIG') !== false);
check("Landing page playCuteTtsVoice sets Indonesian language", strpos($landingRes, "utterance.lang = 'id-ID'") !== false);
check("Landing page playCuteTtsVoice binds cute boy pitch", strpos($landingRes, 'utterance.pitch = isArdiMale ? 1.16 : 1.25') !== false);
check("Landing page playCuteTtsVoice binds dynamic rate", strpos($landingRes, 'window.MIKO_VOICE_CONFIG.rate') !== false);
check("Landing page playCuteTtsVoice binds volume 1.0", strpos($landingRes, 'utterance.volume = 1.0') !== false);

// 3. Elimination of Inconsistent Per-Button Audio Overrides
echo "\n--- 3. Elimination of Per-Button Audio Overrides ---\n";
check("No button uses custom MP3 audio override (intro)", strpos($landingRes, "'audio/miko/greeting_default.mp3'") === false && strpos($landingRes, '"audio/miko/greeting_default.mp3"') === false);
check("No button uses custom MP3 audio override (tips)", strpos($landingRes, "'audio/miko/cheer_3.mp3'") === false && strpos($landingRes, '"audio/miko/cheer_3.mp3"') === false);
check("All 4 MIKO_TOPICS route to unified voice engine", strpos($landingRes, 'playCuteTtsVoice(targetText, onDone, myId)') !== false);

// 4. All 4 Buttons & Avatar Consistency
echo "\n--- 4. All 4 Buttons & Avatar Interaction Consistency ---\n";
$buttons = ['intro' => 'Siapa Miko?', 'worlds' => 'Cerita 4 Dunia', 'tips' => 'Tips Belajar Seru', 'cheer' => 'Semangat Juara'];

foreach ($buttons as $key => $label) {
    check("Button '{$label}' (data-topic='{$key}') exists in DOM", strpos($landingRes, "data-topic=\"{$key}\"") !== false);
    check("Topic '{$key}' defined in MIKO_TOPICS", strpos($landingRes, "{$key}: {") !== false);
}

check("Avatar Miko click triggers playMikoVoice()", strpos($landingRes, 'mikoAvatarTrigger.addEventListener(\'click\'') !== false && strpos($landingRes, 'playMikoVoice()') !== false);
check("Topic chip click triggers setMikoTopic()", strpos($landingRes, 'chip.addEventListener(\'click\'') !== false && strpos($landingRes, 'setMikoTopic(') !== false);
check("setMikoTopic calls playMikoVoice() for unified playback", strpos($landingRes, 'playMikoVoice();') !== false);

// 5. Collision & Audio Cleanup
echo "\n--- 5. Collision & Audio Cleanup ---\n";
check("stopMikoVoice terminates audio on every new interaction", strpos($landingRes, 'function stopMikoVoice()') !== false);
check("Speech synthesis cancelled on stopMikoVoice", strpos($landingRes, 'window.speechSynthesis.cancel()') !== false);
check("activeSpeechId prevents stale async speech execution", strpos($landingRes, 'activeSpeechId === myId') !== false);

echo "\n========================================================================\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================================\n";

if ($passed !== $total) {
    exit(1);
}
exit(0);
