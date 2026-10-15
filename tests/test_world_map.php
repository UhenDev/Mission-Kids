<?php
/**
 * Test Suite: Mission Kids Interactive World Map Redesign Verification
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
echo "  INTERACTIVE WORLD MAP REDESIGN ACCEPTANCE TESTS\n";
echo "========================================================\n\n";

check("HTTP 200 on landing page", $httpCode === 200, "Received: {$httpCode}");

// 1. Check unified map wrapper exists
check("Interactive map stage exists (#world-map-stage)", strpos($html, 'id="world-map-stage"') !== false);
check("Interactive map wrapper class present", strpos($html, 'interactive-world-map-wrapper') !== false);
check("Image points to clean panorama asset", strpos($html, 'assets/images/worlds_adventure_map.jpg') !== false);

// 2. Acceptance Criterion: The 4 separate cards MUST NOT exist under the map
check("Old worlds-interactive-grid completely removed", strpos($html, 'worlds-interactive-grid') === false);
check("Old world-node-card completely removed", strpos($html, 'world-node-card') === false);

// 3. Acceptance Criterion: 4 islands must be directly clickable hotspots
check("Number City interactive zone exists", strpos($html, 'data-world-slug="number-city"') !== false);
check("Discovery Lab interactive zone exists", strpos($html, 'data-world-slug="discovery-lab"') !== false);
check("Thinking Lab interactive zone exists", strpos($html, 'data-world-slug="thinking-lab"') !== false);
check("Space Odyssey interactive zone exists", strpos($html, 'data-world-slug="space-odyssey"') !== false);

// 4. Hitboxes and Badges for each island
check("Number City badge exists with 3 / 5 Misi", strpos($html, 'id="badge-number-city"') !== false && strpos($html, 'Number City') !== false);
check("Discovery Lab badge exists with 2 / 5 Misi", strpos($html, 'id="badge-discovery-lab"') !== false && strpos($html, 'Discovery Lab') !== false);
check("Thinking Lab badge exists with 2 / 5 Misi", strpos($html, 'id="badge-thinking-lab"') !== false && strpos($html, 'Thinking Lab') !== false);
check("Space Odyssey badge exists with 1 / 5 Misi", strpos($html, 'id="badge-space-odyssey"') !== false && strpos($html, 'Space Odyssey') !== false);

// 5. Pins for each island
check("Number City pin marker exists", strpos($html, 'pin-number') !== false);
check("Discovery Lab pin marker exists", strpos($html, 'pin-discovery') !== false);
check("Thinking Lab pin marker exists", strpos($html, 'pin-thinking') !== false);
check("Space Odyssey pin marker exists", strpos($html, 'pin-space') !== false);

// 6. Floating Overlay Pills
check("Bottom-left MIKO helper pill present", strpos($html, 'map-helper-pill') !== false && strpos($html, 'Klik pada pulau untuk menjelajahi') !== false);
check("Bottom-right Explore All Worlds button present", strpos($html, 'id="btn-explore-all-worlds"') !== false && strpos($html, 'Jelajahi Semua Dunia') !== false);

// 7. Interactive World Detail Modal
check("World detail modal dialog exists (#world-detail-modal)", strpos($html, 'id="world-detail-modal"') !== false);
check("Modal has close button", strpos($html, 'id="btn-close-world-modal"') !== false);
check("Modal has start CTA button", strpos($html, 'id="btn-modal-start-cta"') !== false);
check("Modal has missions list container", strpos($html, 'id="modal-missions-list"') !== false);

// 8. Client data & accessibility
check("WORLD_MAP_DATA JSON embedded in page", strpos($html, 'window.WORLD_MAP_DATA =') !== false);
check("Accessible aria labels and roles", strpos($html, 'role="region"') !== false && strpos($html, 'aria-label="Peta Interaktif') !== false);

echo "\n--------------------------------------------------------\n";
echo "RESULT: {$passed} / {$total} TESTS PASSED\n";
echo "========================================================\n";

if ($passed !== $total) {
    exit(1);
}
