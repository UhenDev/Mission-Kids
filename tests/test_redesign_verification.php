<?php
/**
 * MISSION KIDS — Redesign Verification Test Script
 * Verifies Footer differentiation, creator credit, login layout, and register avatar portrait selection
 */

declare(strict_types=1);

$loginHtml = file_get_contents('http://127.0.0.1:8080/?page=login');
$regHtml = file_get_contents('http://127.0.0.1:8080/?page=register');
$landHtml = file_get_contents('http://127.0.0.1:8080/?page=landing');

$passed = 0;
$total = 0;

function check(string $label, bool $condition): void {
    global $passed, $total;
    $total++;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$label}\n";
    } else {
        echo "  [FAIL] {$label}\n";
    }
}

echo "\n======================================================\n";
echo "  REDESIGN VERIFICATION: FOOTER, LOGIN & REGISTER\n";
echo "======================================================\n\n";

echo "--- 1. Verification of Login Footer ---\n";
check("Login uses app-auth-footer (not app-main-footer)", strpos($loginHtml, 'app-auth-footer') !== false && strpos($loginHtml, 'app-main-footer') === false);
check("Login footer contains exact credit: 'Website ini dibuat oleh Hendrik Wildansyah.'", strpos($loginHtml, 'Website ini dibuat oleh Hendrik Wildansyah.') !== false);
check("Login footer has NO navbar links (footer-nav-links removed)", strpos($loginHtml, 'footer-nav-links') === false);
check("Login footer has copyright line", strpos($loginHtml, 'MISSION KIDS. All rights reserved.') !== false);

echo "\n--- 2. Verification of Register Footer ---\n";
check("Register uses app-auth-footer (not app-main-footer)", strpos($regHtml, 'app-auth-footer') !== false && strpos($regHtml, 'app-main-footer') === false);
check("Register footer contains exact credit: 'Website ini dibuat oleh Hendrik Wildansyah.'", strpos($regHtml, 'Website ini dibuat oleh Hendrik Wildansyah.') !== false);
check("Register footer has NO navbar links (footer-nav-links removed)", strpos($regHtml, 'footer-nav-links') === false);
check("Register footer has copyright line", strpos($regHtml, 'MISSION KIDS. All rights reserved.') !== false);

echo "\n--- 3. Verification of Landing Footer (Main Footer) ---\n";
check("Landing page retains app-main-footer", strpos($landHtml, 'app-main-footer') !== false);
check("Landing page includes exact credit: 'Website ini dibuat oleh Hendrik Wildansyah.'", strpos($landHtml, 'Website ini dibuat oleh Hendrik Wildansyah.') !== false);
check("Landing page footer retains quick nav links", strpos($landHtml, 'footer-nav-links') !== false);

echo "\n--- 4. Verification of Register Character Selection & Hero Preview ---\n";
check("Register contains hero character img (auth-hero-character-img)", strpos($regHtml, 'id="auth-hero-character-img"') !== false);
check("Register contains dynamic char title (auth-visual-char-title)", strpos($regHtml, 'id="auth-visual-char-title"') !== false);
check("Register contains dynamic char role badge (auth-visual-char-role)", strpos($regHtml, 'id="auth-visual-char-role"') !== false);
check("Register contains dynamic char desc (auth-visual-char-desc)", strpos($regHtml, 'id="auth-visual-char-desc"') !== false);
check("Register contains illustrated podium stage (auth-stage-podium)", strpos($regHtml, 'class="auth-stage-podium"') !== false);
check("Register contains avatar grid (avatar-grid-8)", strpos($regHtml, 'class="avatar-grid-8"') !== false);
check("Register contains portrait thumb wrapper (avatar-pick-thumb-wrapper)", strpos($regHtml, 'class="avatar-pick-thumb-wrapper"') !== false);
check("Register contains character name (avatar-pick-name)", strpos($regHtml, 'class="avatar-pick-name"') !== false);
check("Register contains character role pill (avatar-pick-role)", strpos($regHtml, 'class="avatar-pick-role"') !== false);
check("Register contains checkmark badge (avatar-pick-badge)", strpos($regHtml, 'class="avatar-pick-badge"') !== false);

$avatars = ['kian', 'sera', 'raka', 'nara', 'dika', 'bayu', 'fajar', 'luna'];
foreach ($avatars as $av) {
    check("Register contains radio option for avatar '{$av}'", strpos($regHtml, "value=\"{$av}\"") !== false);
    check("Register contains portrait image for avatar '{$av}'", strpos($regHtml, "{$av}-thumb.png") !== false);
}

echo "\n--- 5. Verification of Login Card ---\n";
check("Login contains .login-master-card", strpos($loginHtml, 'class="login-master-card"') !== false);
check("Login contains .login-panel-visual", strpos($loginHtml, 'class="login-panel-visual"') !== false);
check("Login contains .login-panel-form", strpos($loginHtml, 'class="login-panel-form"') !== false);
check("Login contains .login-submit-btn", strpos($loginHtml, 'id="btn-submit-login"') !== false);
check("Login contains help modal dialog", strpos($loginHtml, 'id="help-modal"') !== false);

echo "\n======================================================\n";
echo "  RESULT: {$passed} / {$total} VERIFICATION CHECKS PASSED\n";
echo "======================================================\n\n";

if ($passed === $total) {
    exit(0);
} else {
    exit(1);
}
