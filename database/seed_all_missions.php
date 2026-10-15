<?php
/**
 * MISSION KIDS — Master Missions Seeder
 * Seeds at least 20 rich interactive missions for EACH of the 4 worlds (80 missions total).
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

$pdo = Database::getConnection();

// Retrieve World IDs
$worldMap = [];
$wRows = $pdo->query("SELECT id, slug FROM worlds")->fetchAll(PDO::FETCH_ASSOC);
foreach ($wRows as $row) {
    $worldMap[$row['slug']] = (int)$row['id'];
}

echo "Found worlds: " . implode(', ', array_keys($worldMap)) . "\n";

// Load 80 Missions Data Definitions
require_once __DIR__ . '/missions_data.php';

$stmt = $pdo->prepare("INSERT INTO missions (
    world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active
) VALUES (
    :world_id, :slug, :title, :subtitle, :learning_objective, :interaction_type, :xp_reward, :sort_order, :config_json, 1
) ON CONFLICT(slug) DO UPDATE SET
    title = excluded.title,
    subtitle = excluded.subtitle,
    learning_objective = excluded.learning_objective,
    interaction_type = excluded.interaction_type,
    xp_reward = excluded.xp_reward,
    sort_order = excluded.sort_order,
    config_json = excluded.config_json,
    is_active = 1
");

$count = 0;
foreach ($allWorldMissions as $m) {
    $stmt->execute([
        ':world_id' => $worldMap[$m['world_slug']],
        ':slug' => $m['slug'],
        ':title' => $m['title'],
        ':subtitle' => $m['subtitle'],
        ':learning_objective' => $m['learning_objective'],
        ':interaction_type' => $m['interaction_type'],
        ':xp_reward' => $m['xp_reward'] ?? 100,
        ':sort_order' => $m['sort_order'],
        ':config_json' => json_encode($m['config'], JSON_UNESCAPED_UNICODE)
    ]);
    $count++;
}

echo "Successfully seeded {$count} missions across all worlds!\n";

$counts = $pdo->query("SELECT w.title, COUNT(m.id) as total FROM worlds w LEFT JOIN missions m ON w.id = m.world_id GROUP BY w.id ORDER BY w.sort_order ASC")->fetchAll(PDO::FETCH_ASSOC);
foreach ($counts as $c) {
    echo "  - {$c['title']}: {$c['total']} missions\n";
}
