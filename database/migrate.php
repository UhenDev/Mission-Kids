<?php
/**
 * MISSION KIDS — Migration & Seeding CLI Runner
 * Sets up database tables and populates the 4 worlds, 80 missions, and badges.
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/DatabaseBootstrapper.php';

echo "=== MISSION KIDS Database Setup ===\n";

try {
    $pdo = Database::getConnection();
    $driver = Database::getDriverUsed();
    echo "Connected using driver: [{$driver}]\n";

    DatabaseBootstrapper::run($pdo, $driver);

    $worldsCount = $pdo->query("SELECT COUNT(*) FROM worlds")->fetchColumn();
    $missionsCount = $pdo->query("SELECT COUNT(*) FROM missions")->fetchColumn();
    $achievementsCount = $pdo->query("SELECT COUNT(*) FROM achievements")->fetchColumn();

    echo "Status:\n";
    echo "  - Worlds: {$worldsCount}\n";
    echo "  - Missions: {$missionsCount}\n";
    echo "  - Achievements: {$achievementsCount}\n";
    echo "=== Migration & Seeding COMPLETED SUCCESSFULLY ===\n";
} catch (Exception $e) {
    echo "Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
