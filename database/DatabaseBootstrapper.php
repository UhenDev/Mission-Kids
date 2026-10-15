<?php
/**
 * MISSION KIDS — Modular Database Bootstrapper
 * Idempotently creates tables and seeds default data (4 worlds, 80 missions, badges)
 * without deleting or overwriting any existing users, profiles, or progress.
 */

declare(strict_types=1);

class DatabaseBootstrapper
{
    public static function run(PDO $pdo, string $driver): void
    {
        if ($driver === 'mysql') {
            $schemaFile = __DIR__ . '/schema.sql';
            if (file_exists($schemaFile)) {
                $pdo->exec(file_get_contents($schemaFile));
            }
        } else {
            // SQLite Compatible Schema
            $sqliteSchema = "
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                role TEXT NOT NULL DEFAULT 'student',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
            );

            CREATE TABLE IF NOT EXISTS profiles (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL UNIQUE,
                nickname TEXT NOT NULL,
                avatar_id TEXT NOT NULL DEFAULT 'astro_cat',
                current_level INTEGER NOT NULL DEFAULT 1,
                total_xp INTEGER NOT NULL DEFAULT 0,
                preferred_world_id INTEGER NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS worlds (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                title TEXT NOT NULL,
                subtitle TEXT NOT NULL,
                theme_color TEXT NOT NULL,
                sort_order INTEGER NOT NULL DEFAULT 1,
                is_active INTEGER NOT NULL DEFAULT 1
            );

            CREATE TABLE IF NOT EXISTS missions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                world_id INTEGER NOT NULL,
                slug TEXT NOT NULL UNIQUE,
                title TEXT NOT NULL,
                subtitle TEXT NOT NULL,
                learning_objective TEXT NOT NULL,
                interaction_type TEXT NOT NULL,
                xp_reward INTEGER NOT NULL DEFAULT 100,
                sort_order INTEGER NOT NULL DEFAULT 1,
                config_json TEXT NOT NULL,
                is_active INTEGER NOT NULL DEFAULT 1,
                FOREIGN KEY (world_id) REFERENCES worlds(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS mission_progress (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                mission_id INTEGER NOT NULL,
                status TEXT NOT NULL DEFAULT 'locked',
                stars INTEGER NOT NULL DEFAULT 0,
                completed_at DATETIME NULL,
                updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                UNIQUE (user_id, mission_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS mission_attempts (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                mission_id INTEGER NOT NULL,
                hints_used INTEGER NOT NULL DEFAULT 0,
                is_success INTEGER NOT NULL,
                reflection_answer TEXT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS xp_transactions (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                amount INTEGER NOT NULL,
                source_type TEXT NOT NULL,
                reference_id INTEGER NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            );

            CREATE TABLE IF NOT EXISTS achievements (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                title TEXT NOT NULL,
                description TEXT NOT NULL,
                icon_name TEXT NOT NULL,
                xp_reward INTEGER NOT NULL DEFAULT 50,
                criteria_type TEXT NOT NULL,
                criteria_threshold INTEGER NOT NULL DEFAULT 1
            );

            CREATE TABLE IF NOT EXISTS user_achievements (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id INTEGER NOT NULL,
                achievement_id INTEGER NOT NULL,
                unlocked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                UNIQUE (user_id, achievement_id),
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                FOREIGN KEY (achievement_id) REFERENCES achievements(id) ON DELETE CASCADE
            );
            ";
            $pdo->exec($sqliteSchema);
        }

        // 1. Seed Worlds (Idempotent)
        $worlds = [
            [
                'slug' => 'number-city',
                'title' => 'Number City',
                'subtitle' => 'Petualangan Angka, Belanja & Pola Logika',
                'theme_color' => '#F59E0B',
                'sort_order' => 1,
            ],
            [
                'slug' => 'discovery-lab',
                'title' => 'Discovery Lab',
                'subtitle' => 'Eksperimen Alam, Cahaya & Sains Nyata',
                'theme_color' => '#10B981',
                'sort_order' => 2,
            ],
            [
                'slug' => 'thinking-lab',
                'title' => 'Thinking Lab',
                'subtitle' => 'Logika Algoritma & Petualangan Robot',
                'theme_color' => '#6366F1',
                'sort_order' => 3,
            ],
            [
                'slug' => 'space-odyssey',
                'title' => 'Space Odyssey',
                'subtitle' => 'Petualangan Antariksa, Gravitasi & Koordinat Roket',
                'theme_color' => '#8B5CF6',
                'sort_order' => 4,
            ],
        ];

        $stmtWorld = $pdo->prepare("INSERT " . ($driver === 'mysql' ? "IGNORE" : "OR IGNORE") . " INTO worlds (slug, title, subtitle, theme_color, sort_order) VALUES (:slug, :title, :subtitle, :theme_color, :sort_order)");
        foreach ($worlds as $w) {
            $stmtWorld->execute($w);
        }

        // Retrieve World IDs
        $worldMap = [];
        $wRows = $pdo->query("SELECT id, slug FROM worlds")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($wRows as $row) {
            $worldMap[$row['slug']] = (int)$row['id'];
        }

        // 2. Seed All 80 Missions
        $missionsFile = __DIR__ . '/missions_data.php';
        if (file_exists($missionsFile)) {
            require_once $missionsFile;

            if (isset($allWorldMissions) && is_array($allWorldMissions)) {
                $stmtMission = $pdo->prepare("INSERT " . ($driver === 'mysql' ? "IGNORE" : "OR IGNORE") . " INTO missions (world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json) VALUES (:world_id, :slug, :title, :subtitle, :learning_objective, :interaction_type, :xp_reward, :sort_order, :config_json)");
                foreach ($allWorldMissions as $m) {
                    if (!isset($worldMap[$m['world_slug']])) {
                        continue;
                    }
                    $stmtMission->execute([
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
                }
            }
        }

        // 3. Seed Achievements
        $achievements = [
            [
                'slug' => 'first-mission',
                'title' => 'Langkah Pertama',
                'description' => 'Berhasil menyelesaikan misi pertama di MISSION KIDS!',
                'icon_name' => 'rocket',
                'xp_reward' => 50,
                'criteria_type' => 'total_missions',
                'criteria_threshold' => 1
            ],
            [
                'slug' => 'number-explorer',
                'title' => 'Penjelajah Angka',
                'description' => 'Menyelesaikan seluruh misi di Number City!',
                'icon_name' => 'calculator',
                'xp_reward' => 100,
                'criteria_type' => 'world_complete',
                'criteria_threshold' => $worldMap['number-city'] ?? 1
            ],
            [
                'slug' => 'little-scientist',
                'title' => 'Dokter Alam Cilik',
                'description' => 'Menyelesaikan seluruh misi eksperimen di Discovery Lab!',
                'icon_name' => 'flask',
                'xp_reward' => 100,
                'criteria_type' => 'world_complete',
                'criteria_threshold' => $worldMap['discovery-lab'] ?? 2
            ],
            [
                'slug' => 'logic-commander',
                'title' => 'Kapten Logika',
                'description' => 'Menyelesaikan seluruh misi pemrograman di Thinking Lab!',
                'icon_name' => 'cpu',
                'xp_reward' => 100,
                'criteria_type' => 'world_complete',
                'criteria_threshold' => $worldMap['thinking-lab'] ?? 3
            ],
            [
                'slug' => 'space-cadet',
                'title' => 'Astronot Bintang Cilik',
                'description' => 'Menyelesaikan seluruh misi penjelajahan antariksa di Space Odyssey!',
                'icon_name' => 'satellite',
                'xp_reward' => 100,
                'criteria_type' => 'world_complete',
                'criteria_threshold' => $worldMap['space-odyssey'] ?? 4
            ],
            [
                'slug' => 'mission-master',
                'title' => 'Master Penjelajah Sejati',
                'description' => 'Luar biasa! Menyelesaikan seluruh 12 misi di MISSION KIDS!',
                'icon_name' => 'trophy',
                'xp_reward' => 250,
                'criteria_type' => 'total_missions',
                'criteria_threshold' => 12
            ]
        ];

        $stmtAch = $pdo->prepare("INSERT " . ($driver === 'mysql' ? "IGNORE" : "OR IGNORE") . " INTO achievements (slug, title, description, icon_name, xp_reward, criteria_type, criteria_threshold) VALUES (:slug, :title, :description, :icon_name, :xp_reward, :criteria_type, :criteria_threshold)");
        foreach ($achievements as $a) {
            $stmtAch->execute($a);
        }
    }
}
