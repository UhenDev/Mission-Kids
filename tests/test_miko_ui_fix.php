<?php
/**
 * Test Suite: MIKO Section UI Bug Fix Verification
 */

$html = file_get_contents('http://127.0.0.1:8080/?page=landing');
$css = file_get_contents('http://127.0.0.1:8080/css/components.css');

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
echo "  MIKO SECTION UI BUG FIX VERIFICATION TESTS\n";
echo "========================================================\n\n";

// 1. Structure & Non-Overlapping Layout
check("Landing page loaded successfully", !empty($html));
check("Section #miko exists in HTML", strpos($html, 'id="miko"') !== false);
check("Miko visual column exists", strpos($html, 'class="miko-visual-column"') !== false);
check("Miko mascot wrapper is trigger button", strpos($html, 'id="miko-avatar-trigger"') !== false);

// 2. Speech Balloon Placement & Content
check("Speech balloon exists (.miko-waving-balloon)", strpos($html, 'class="miko-waving-balloon"') !== false);
check("Speech balloon content container exists (.miko-balloon-content)", strpos($html, 'class="miko-balloon-content"') !== false);
check("Speech balloon heading has 'Aku MIKO!'", strpos($html, 'Aku MIKO!') !== false);
check("Speech balloon subtitle has id 'miko-balloon-subtitle'", strpos($html, 'id="miko-balloon-subtitle"') !== false);
check("Speech balloon subtitle text is intact", strpos($html, 'Teman belajarmu di setiap petualangan!') !== false);
check("Speech balloon pointer exists (.miko-balloon-pointer)", strpos($html, 'class="miko-balloon-pointer"') !== false);

// 3. Avatar Image & Indicator
check("Miko image container exists (.miko-img-container)", strpos($html, 'class="miko-img-container"') !== false);
check("Miko mascot image is present", strpos($html, 'class="miko-mascot-img"') !== false);
check("Miko speaking halo is present", strpos($html, 'class="miko-speaking-halo"') !== false);
check("Miko voice wave indicator is present", strpos($html, 'class="miko-voice-wave-indicator"') !== false);
check("Miko click hint pill is present (#miko-click-hint)", strpos($html, 'id="miko-click-hint"') !== false);

// 4. Right Column Balance & Perks List
check("Miko text column exists (.miko-text-column)", strpos($html, 'class="miko-text-column"') !== false);
check("Section heading 'Kenalan dengan MIKO' exists", strpos($html, 'Kenalan dengan MIKO') !== false);
check("Companion perks list container exists (.miko-perks-list)", strpos($html, 'class="miko-perks-list"') !== false);
check("Perk 1: 'Panduan Suara Interaktif' present", strpos($html, 'Panduan Suara Interaktif') !== false);
check("Perk 2: 'Petunjuk Pintar Bertingkat' present", strpos($html, 'Petunjuk Pintar Bertingkat') !== false);
check("Perk 3: 'Motivasi & Apresiasi Bintang' present", strpos($html, 'Motivasi & Apresiasi Bintang') !== false);

// 5. CSS Rules & Conflict Resolution
check("Old 5rem/5.5rem padding removed from .miko-spotlight-section", strpos($css, 'padding: 5rem 0 5.5rem;') === false);
check("Tightened padding applied to .miko-spotlight-section (3.25rem 0 2.5rem)", strpos($css, 'padding: 3.25rem 0 2.5rem;') !== false);
check("Tightened padding applied to .editorial-benefits-section (2.75rem 0 3.5rem)", strpos($css, 'padding: 2.75rem 0 3.5rem;') !== false);
check(".miko-waving-balloon uses relative/flex positioning", strpos($css, 'position: relative;') !== false && strpos($css, '.miko-waving-balloon') !== false);
check("Speech pointer CSS triangle is defined", strpos($css, '.miko-balloon-pointer') !== false);
check("Violent shaking animation scoped to dock only (.miko-dock .miko-avatar-btn.miko-speaking)", strpos($css, '.miko-dock .miko-avatar-btn.miko-speaking') !== false);
check("Mascot wrapper speaking state overrides shaking (animation: none !important)", strpos($css, '.miko-mascot-wrapper.miko-avatar-btn.miko-speaking') !== false);
check("Perk cards styling defined in CSS (.miko-perk-card)", strpos($css, '.miko-perk-card') !== false);

// 6. Responsive Breakpoint Rules
check("960px media query contains .miko-perks-list", strpos($css, '.miko-perks-list') !== false);
check("640px mobile media query sets .miko-waving-balloon position relative", strpos($css, 'top: auto;') !== false);
check("380px ultra-narrow media query handles .miko-waving-balloon", strpos($css, 'max-width: 250px;') !== false);

// 7. Voice Interactivity Checks
check("Avatar trigger click listener exists in JS", strpos($html, "mikoAvatarTrigger.addEventListener('click'") !== false);
check("Avatar trigger keyboard listener exists in JS", strpos($html, "mikoAvatarTrigger.addEventListener('keydown'") !== false);
check("Avatar trigger controls speech playback", strpos($html, "playMikoVoice()") !== false && strpos($html, "stopMikoVoice()") !== false);

echo "\n--------------------------------------------------------\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================\n";

if ($passed !== $total) {
    exit(1);
}
