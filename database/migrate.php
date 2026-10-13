<?php
/**
 * MISSION KIDS — Migration & Seeding CLI Runner
 * Sets up database tables and populates the 3 worlds, 9 missions, and badges.
 */

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';

echo "=== MISSION KIDS Database Setup ===\n";

try {
    $pdo = Database::getConnection();
    $driver = Database::getDriverUsed();
    echo "Connected using driver: [{$driver}]\n";

    if ($driver === 'mysql') {
        $schemaSql = file_get_contents(__DIR__ . '/schema.sql');
        $pdo->exec($schemaSql);
        echo "MySQL schema applied successfully.\n";
    } else {
        // SQLite compatible schema
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
        echo "SQLite schema applied successfully.\n";
    }

    // Seed Worlds
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
    echo "Worlds seeded.\n";

    // Retrieve World IDs
    $worldMap = [];
    $wRows = $pdo->query("SELECT id, slug FROM worlds")->fetchAll();
    foreach ($wRows as $row) {
        $worldMap[$row['slug']] = (int)$row['id'];
    }

    // Seed 9 Missions
    $missions = [
        // WORLD 1: NUMBER CITY
        [
            'world_id' => $worldMap['number-city'],
            'slug' => 'toko-kue',
            'title' => 'Toko Kue Donat Bibi Bella',
            'subtitle' => 'Bantu kasir menyiapkan pesanan dan menghitung uang kembalian!',
            'learning_objective' => 'Melatih operasi penjumlahan dan pengurangan sederhana serta pecahan uang.',
            'interaction_type' => 'match_sort',
            'xp_reward' => 100,
            'sort_order' => 1,
            'config_json' => json_encode([
                'scenario' => 'Pembeli ingin membeli 2 Donat Cokelat (Rp 2.000 per donat). Pembeli membayar dengan uang kertas Rp 5.000.',
                'question' => 'Berapa total harga donat dan berapa koin kembalian yang harus ditaruh di nampan kasir?',
                'items' => [
                    ['id' => 'donut_1', 'name' => 'Donat Cokelat', 'price' => 2000, 'type' => 'goods', 'icon' => '🍩'],
                    ['id' => 'donut_2', 'name' => 'Donat Cokelat', 'price' => 2000, 'type' => 'goods', 'icon' => '🍩'],
                    ['id' => 'coin_500', 'name' => 'Koin Rp 500', 'price' => 500, 'type' => 'coin', 'icon' => '🪙'],
                    ['id' => 'coin_1000', 'name' => 'Koin Rp 1.000', 'price' => 1000, 'type' => 'coin', 'icon' => '🪙'],
                    ['id' => 'coin_2000', 'name' => 'Koin Rp 2.000', 'price' => 2000, 'type' => 'coin', 'icon' => '🪙'],
                ],
                'target_goods_count' => 2,
                'target_change' => 1000,
                'hints' => [
                    ['level' => 1, 'text' => 'Coba hitung dulu: 2 donat @ Rp 2.000 berarti berapa ya? 2.000 + 2.000 = ... ?'],
                    ['level' => 2, 'text' => 'Total kuenya Rp 4.000. Jika uang pembeli Rp 5.000, hitung: 5.000 dikurangi 4.000!'],
                    ['level' => 3, 'text' => 'Letakkan 2 Donat dan 1 koin Rp 1.000 di nampan kasir!']
                ],
                'reflection' => [
                    'question' => 'Mengapa penting memeriksa uang kembalian saat berbelanja?',
                    'options' => [
                        'Agar kita tahu jumlah uang yang kita miliki tetap tepat dan jujur.',
                        'Agar kasir memberikan semua donat di toko secara gratis.',
                        'Supaya kita bisa membuang koin ke jalan.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['number-city'],
            'slug' => 'jembatan-angka',
            'title' => 'Jembatan Angka yang Hilang',
            'subtitle' => 'Temukan angka loncat misterius untuk menyambung jembatan!',
            'learning_objective' => 'Mengenal pola deret hitung bertingkat dan lompatan angka.',
            'interaction_type' => 'match_sort',
            'xp_reward' => 100,
            'sort_order' => 2,
            'config_json' => json_encode([
                'scenario' => 'Balok penyeberangan jembatan memiliki pola deret: 3, 7, 11, [ ? ], 19.',
                'question' => 'Balok nomor berapa yang harus dipasang untuk melengkapi jembatan?',
                'pattern_step' => 4,
                'sequence' => [3, 7, 11, null, 19],
                'correct_value' => 15,
                'choices' => [13, 14, 15, 16],
                'hints' => [
                    ['level' => 1, 'text' => 'Berapa jarak dari angka 3 ke angka 7? Dan dari 7 ke 11? Polanya melompat berapa angka?'],
                    ['level' => 2, 'text' => 'Setiap angka bertambah 4 (+4). Jadi, 11 ditambah 4 hasilnya berapa?'],
                    ['level' => 3, 'text' => '11 + 4 = 15! Pasang balok angka 15 ke bagian jembatan yang kosong.']
                ],
                'reflection' => [
                    'question' => 'Pola apa yang membuatmu menemukan angka jembatan yang hilang?',
                    'options' => [
                        'Setiap papan selalu melompat bertambah 4 (+4)',
                        'Angkanya dipilih secara acak tanpa aturan',
                        'Setiap papan dikurangi 10'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['number-city'],
            'slug' => 'kota-pola',
            'title' => 'Taman Lampu Kristal Berpola',
            'subtitle' => 'Pasang kristal warna lampu taman agar bersinar serasi!',
            'learning_objective' => 'Melatih pengenalan pola berulang visual dan keteraturan ritme.',
            'interaction_type' => 'match_sort',
            'xp_reward' => 100,
            'sort_order' => 3,
            'config_json' => json_encode([
                'scenario' => 'Lampu taman memiliki deret kristal: [Merah] [Kuning] [Biru] [Merah] [Kuning] [ ? ].',
                'question' => 'Kristal warna apa yang harus dipasang pada slot terakhir agar lampu menyala?',
                'pattern' => ['red', 'yellow', 'blue'],
                'sequence' => ['red', 'yellow', 'blue', 'red', 'yellow', null],
                'correct_value' => 'blue',
                'choices' => [
                    ['color' => 'blue', 'label' => 'Kristal Biru', 'hex' => '#3B82F6'],
                    ['color' => 'green', 'label' => 'Kristal Hijau', 'hex' => '#10B981'],
                    ['color' => 'purple', 'label' => 'Kristal Ungu', 'hex' => '#8B5CF6']
                ],
                'hints' => [
                    ['level' => 1, 'text' => 'Lihat 3 warna pertama: Merah, Kuning, lalu apa?'],
                    ['level' => 2, 'text' => 'Pola warna ini berulang setiap 3 kristal: Merah - Kuning - Biru.'],
                    ['level' => 3, 'text' => 'Setelah Merah dan Kuning, warna berikutnya pasti Biru! Pasang kristal biru.']
                ],
                'reflection' => [
                    'question' => 'Mengapa mengenali pola membantu kita menyelesaikan masalah lebih cepat?',
                    'options' => [
                        'Karena pola membantu kita memprediksi apa yang terjadi selanjutnya.',
                        'Karena pola membuat lampu meledak.',
                        'Pola hanya berguna untuk mencoret-coret buku.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],

        // WORLD 2: DISCOVERY LAB (Hero Vertical Slice)
        [
            'world_id' => $worldMap['discovery-lab'],
            'slug' => 'tanaman-layu',
            'title' => 'Dokter Tanaman: Bunga Matahari',
            'subtitle' => 'Bunga matahari lab layu! Berikan air dan sinar matahari yang cukup agar mekar!',
            'learning_objective' => 'Memahami kebutuhan dasar tumbuhan (air dan cahaya fotosintesis) melalui simulasi interaktif.',
            'interaction_type' => 'simulation',
            'xp_reward' => 100,
            'sort_order' => 1,
            'config_json' => json_encode([
                'scenario' => 'Bunga matahari mini di laboratorium tampak layu dan batangnya menunduk lesu. Sebagai Dokter Tanaman, atur air dan cahaya agar bunga segar kembali!',
                'initial_state' => ['water' => 15, 'sunlight' => 20, 'health' => 20],
                'target_ranges' => [
                    'water' => ['min' => 60, 'max' => 85, 'label' => 'Air Lembab Ideal (60-85%)'],
                    'sunlight' => ['min' => 65, 'max' => 90, 'label' => 'Cahaya Terang Ideal (65-90%)']
                ],
                'hints' => [
                    ['level' => 1, 'text' => 'Lihat tanahnya yang kering retak dan ruangan yang gelap. Apa 2 hal yang paling disukai tumbuhan?'],
                    ['level' => 2, 'text' => 'Gunakan gembor untuk menyiram air sampai indikator hijau, lalu geser tirai jendela agar sinar matahari masuk!'],
                    ['level' => 3, 'text' => 'Atur kadar air ke sekitar 75% dan buka tirai matahari hingga 80%. Bunga akan langsung tersenyum mekar!']
                ],
                'reflection' => [
                    'question' => 'Apa yang terjadi jika tanaman disiram air berlebihan hingga banjir?',
                    'options' => [
                        'Akar tanaman bisa membusuk dan tanaman sulit bernapas.',
                        'Tanaman langsung berubah menjadi pohon raksasa seketika.',
                        'Tanaman tidak membutuhkan tanah sama sekali.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['discovery-lab'],
            'slug' => 'misteri-bayangan',
            'title' => 'Misteri Teater Bayangan Kelinci',
            'subtitle' => 'Atur posisi senter agar bayangan kelinci pas dengan ukuran panggung pentas!',
            'learning_objective' => 'Memahami perambatan cahaya lurus dan pengaruh jarak sumber cahaya terhadap ukuran bayangan.',
            'interaction_type' => 'simulation',
            'xp_reward' => 100,
            'sort_order' => 2,
            'config_json' => json_encode([
                'scenario' => 'Di panggung teater boneka, siluet bayangan kelinci harus pas memenuhi garis target di layar pentas.',
                'initial_state' => ['torch_distance' => 80, 'shadow_scale' => 45],
                'target_scale' => ['min' => 75, 'max' => 85],
                'hints' => [
                    ['level' => 1, 'text' => 'Apa yang terjadi jika kamu mendekatkan senter ke arah boneka kelinci?'],
                    ['level' => 2, 'text' => 'Semakin dekat senter ke benda, bayangan di layar akan menjadi semakin BESAR!'],
                    ['level' => 3, 'text' => 'Geser senter mendekat ke angka jarak 25-30 agar ukuran bayangan membesar pas 80%!']
                ],
                'reflection' => [
                    'question' => 'Jika kita ingin membuat bayangan benda menjadi lebih kecil, apa yang harus dilakukan?',
                    'options' => [
                        'Menjauhkan sumber cahaya dari benda.',
                        'Mendekatkan senter sedekat mungkin ke benda.',
                        'Mematikan lampu dan meniup layar.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['discovery-lab'],
            'slug' => 'perjalanan-air',
            'title' => 'Petualangan Tetes Air di Awan',
            'subtitle' => 'Susun 3 tahapan siklus air alam agar hujan turun menyegarkan danau!',
            'learning_objective' => 'Mengenal siklus air alamiah: Penguapan (Evaporasi) -> Awan (Kondensasi) -> Hujan (Presipitasi).',
            'interaction_type' => 'match_sort',
            'xp_reward' => 100,
            'sort_order' => 3,
            'config_json' => json_encode([
                'scenario' => 'Danau buatan laboratorium kering saat musim panas. Bantu MIKO mengaktifkan mesin waktu siklus air dalam urutan yang benar!',
                'slots' => ['Tahap 1: Penguapan', 'Tahap 2: Pembentukan Awan', 'Tahap 3: Hujan Turun'],
                'cards' => [
                    ['id' => 'card_evap', 'title' => 'Air Menguap ke Udara', 'stage' => 1, 'desc' => 'Panas matahari mengubah air menjadi uap tak kasat mata.'],
                    ['id' => 'card_cond', 'title' => 'Uap Membentuk Awan', 'stage' => 2, 'desc' => 'Uap air di langit yang dingin berkumpul menjadi awan tebal.'],
                    ['id' => 'card_prec', 'title' => 'Tetes Hujan Turun', 'stage' => 3, 'desc' => 'Awan yang sudah sangat berat meneteskan air hujan kembali ke bumi.']
                ],
                'hints' => [
                    ['level' => 1, 'text' => 'Sebelum menjadi awan, air di danau harus terkena sinar matahari dulu dan menguap ke atas.'],
                    ['level' => 2, 'text' => 'Urutannya: Air menguap -> Uap berkumpul jadi awan mendung -> Hujan turun ke bumi.'],
                    ['level' => 3, 'text' => 'Letakkan kartu "Air Menguap" di kotak 1, "Membentuk Awan" di kotak 2, dan "Hujan Turun" di kotak 3!']
                ],
                'reflection' => [
                    'question' => 'Kemana perginya air hujan setelah jatuh ke tanah dan sungai?',
                    'options' => [
                        'Mengalir kembali ke laut dan danau, lalu siklus menguap berulang lagi.',
                        'Hilang selamanya dan tidak pernah ada air lagi di bumi.',
                        'Berubah menjadi batu es raksasa di ruang angkasa.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],

        // WORLD 3: THINKING LAB
        [
            'world_id' => $worldMap['thinking-lab'],
            'slug' => 'robot-pulang',
            'title' => 'Robot Botty Pulang ke Rumah',
            'subtitle' => 'Susun kartu perintah langkah agar Botty sampai ke stasiun daya baterai!',
            'learning_objective' => 'Melatih pemikiran komputasional berbasis urutan instruksi (sequence execution).',
            'interaction_type' => 'sequence_logic',
            'xp_reward' => 100,
            'sort_order' => 1,
            'config_json' => json_encode([
                'scenario' => 'Baterai Robot Botty hampir habis! Susun perintah kartu [Maju] dan [Putar] agar Botty tiba di stasiun cas tanpa menabrak batu.',
                'grid_size' => 4,
                'start' => ['x' => 0, 'y' => 0, 'dir' => 'right'],
                'target' => ['x' => 2, 'y' => 2],
                'obstacles' => [['x' => 1, 'y' => 1], ['x' => 0, 'y' => 2]],
                'available_commands' => ['FORWARD', 'TURN_RIGHT', 'TURN_LEFT'],
                'hints' => [
                    ['level' => 1, 'text' => 'Arahkan Botty melangkah maju dulu, lalu belok ke arah stasiun pengisian baterai.'],
                    ['level' => 2, 'text' => 'Hati-hati dengan batu di tengah grid! Botty bisa maju 2 langkah, putar kanan, lalu maju 2 langkah.'],
                    ['level' => 3, 'text' => 'Susun urutan kartu: [Maju] -> [Maju] -> [Putar Kanan] -> [Maju] -> [Maju] lalu klik Jalankan!']
                ],
                'reflection' => [
                    'question' => 'Mengapa komputer atau robot harus diberi instruksi langkah demi langkah yang runtut?',
                    'options' => [
                        'Karena robot hanya bisa menjalankan instruksi sesuai urutan yang kita tulis.',
                        'Karena robot bisa membaca pikiran kita tanpa instruksi.',
                        'Supaya robot bisa memakan baterai seperti camilan.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['thinking-lab'],
            'slug' => 'jalan-rahasia',
            'title' => 'Sensor Pintu Jalan Rahasia',
            'subtitle' => 'Pilih jalur aman dengan membaca rambu kondisi sensor lampu warna!',
            'learning_objective' => 'Memahami konsep logika percabangan (Conditionals: IF / THEN) secara visual.',
            'interaction_type' => 'sequence_logic',
            'xp_reward' => 100,
            'sort_order' => 2,
            'config_json' => json_encode([
                'scenario' => 'Jembatan lurus terkunci lampu merah. Hanya jembatan dengan lampu sensor HIJAU yang aman untuk dilewati!',
                'condition' => 'JIKA lampu Hijau -> Buka Jembatan Bawah; JIKA lampu Merah -> Hindari Jembatan Atas.',
                'target_path' => ['DOWN', 'FORWARD', 'FORWARD', 'UP', 'FORWARD'],
                'hints' => [
                    ['level' => 1, 'text' => 'Lihat warna lampu di jembatan atas dan bawah. Mana jembatan yang terbuka aman?'],
                    ['level' => 2, 'text' => 'Jembatan bawah menyala hijau! Arahkan Botty turun ke bawah terlebih dahulu.'],
                    ['level' => 3, 'text' => 'Pilih rute: [Turun] -> [Maju] -> [Maju] -> [Naik] -> [Maju] ke garis akhir!']
                ],
                'reflection' => [
                    'question' => 'Kapan kita menggunakan aturan "JIKA... MAKA..." dalam kehidupan sehari-hari?',
                    'options' => [
                        'JIKA hari hujan, MAKA kita membawa payung.',
                        'JIKA kita tidur, MAKA kita berlari keliling lapangan.',
                        'JIKA hari cerah, MAKA bintang malam terlihat di siang hari.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['thinking-lab'],
            'slug' => 'robot-mengulang',
            'title' => 'Robot Pintar Kartu Mengulang (Loop)',
            'subtitle' => 'Ringkas langkah Botty menaiki anak tangga dengan Kartu Perulangan!',
            'learning_objective' => 'Menumbuhkan pemahaman konsep perulangan (Loops) untuk efisiensi instruksi.',
            'interaction_type' => 'sequence_logic',
            'xp_reward' => 100,
            'sort_order' => 3,
            'config_json' => json_encode([
                'scenario' => 'Botty harus menaiki 4 anak tangga yang sama. Daripada menyusun 8 kartu panjang, gunakan kartu [Ulangi 4 Kali: (Lompat, Maju)]!',
                'steps_count' => 4,
                'target_block' => ['loop_times' => 4, 'actions' => ['JUMP', 'FORWARD']],
                'hints' => [
                    ['level' => 1, 'text' => 'Setiap anak tangga membutuhkan 2 gerakan: Lompat ke atas, lalu Maju.'],
                    ['level' => 2, 'text' => 'Karena ada 4 anak tangga yang sama persis, kita bisa memasukkan gerakan itu ke dalam Kartu Pengulang 4x!'],
                    ['level' => 3, 'text' => 'Pasang kartu [Ulangi 4x] dan masukkan [Lompat] + [Maju] di dalamnya!']
                ],
                'reflection' => [
                    'question' => 'Apa manfaat menggunakan kartu perulangan (loop) dibanding menyusun kartu yang sama berkali-kali?',
                    'options' => [
                        'Membuat instruksi jauh lebih ringkas, rapi, dan hemat tenaga.',
                        'Membuat robot melambat hingga berhenti total.',
                        'Menghapus semua program yang ada di komputer.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],

        // WORLD 4: SPACE ODYSSEY
        [
            'world_id' => $worldMap['space-odyssey'],
            'slug' => 'roket-angkasa',
            'title' => 'Peluncuran Roket Antariksa',
            'subtitle' => 'Atur level bahan bakar dan sudut luncur roket agar sampai ke stasiun orbit!',
            'learning_objective' => 'Memahami hubungan proporsi bahan bakar dan sudut peluncuran roket secara interaktif.',
            'interaction_type' => 'simulation',
            'xp_reward' => 100,
            'sort_order' => 1,
            'config_json' => json_encode([
                'scenario' => 'Roket Bintang Explorer siap meluncur menuju stasiun luar angkasa orbit! Atur bahan bakar roket antara 70% sampai 85% dan sudut elevasi antara 45 sampai 60 derajat!',
                'initial_state' => ['fuel' => 30, 'angle' => 20],
                'target_ranges' => [
                    'fuel' => ['min' => 70, 'max' => 85, 'label' => 'Bahan Bakar Ideal (70% - 85%)'],
                    'angle' => ['min' => 45, 'max' => 60, 'label' => 'Sudut Elevasi Ideal (45° - 60°)']
                ],
                'hints' => [
                    ['level' => 1, 'text' => 'Geser tuas bahan bakar ke atas hingga tangki terisi cukup untuk menembus atmosfer.'],
                    ['level' => 2, 'text' => 'Bahan bakar butuh sekitar 70-85%. Sudut moncong roket jangan terlalu mendatar, arahkan sekitar 45-60 derajat.'],
                    ['level' => 3, 'text' => 'Atur bahan bakar menjadi 75% dan sudut ke 50 derajat, lalu klik tombol Luncurkan Roket!']
                ],
                'reflection' => [
                    'question' => 'Mengapa roket membutuhkan sudut peluncuran dan bahan bakar yang tepat untuk mencapai orbit?',
                    'options' => [
                        'Supaya memiliki daya dorong yang cukup untuk melepaskan diri dari gravitasi bumi menuju lintasan yang tepat.',
                        'Supaya roket bisa berenang di dalam air laut.',
                        'Karena roket hanya bisa meluncur saat lampu jalan menyala.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['space-odyssey'],
            'slug' => 'rasi-bintang',
            'title' => 'Peta Koordinat Rasi Bintang',
            'subtitle' => 'Temukan koordinat bintang terang Polaris pada grid radar teleskop!',
            'learning_objective' => 'Mengenalkan sistem koordinat Kartesius sederhana (X, Y) untuk navigasi antariksa.',
            'interaction_type' => 'match_sort',
            'xp_reward' => 100,
            'sort_order' => 2,
            'config_json' => json_encode([
                'scenario' => 'Teleskop luar angkasa menangkap bintang Polaris yang bersinar terang pada koordinat sumbu X mendatar dan sumbu Y tegak!',
                'question' => 'Berapa koordinat bintang Polaris pada radar teleskop (Sumbu X mendatar, Sumbu Y tegak)?',
                'target_coord' => ['x' => 4, 'y' => 6],
                'correct_value' => '4,6',
                'choices' => [
                    ['value' => '4,6', 'label' => 'Koordinat (X: 4, Y: 6)'],
                    ['value' => '6,4', 'label' => 'Koordinat (X: 6, Y: 4)'],
                    ['value' => '2,5', 'label' => 'Koordinat (X: 2, Y: 5)'],
                    ['value' => '5,3', 'label' => 'Koordinat (X: 5, Y: 3)']
                ],
                'hints' => [
                    ['level' => 1, 'text' => 'Tarik garis dari bintang Polaris lurus ke bawah untuk membaca angka pada sumbu X.'],
                    ['level' => 2, 'text' => 'Sumbu mendatar X menunjukkan angka 4, lalu tarik garis lurus ke kiri ke sumbu tegak Y.'],
                    ['level' => 3, 'text' => 'Sumbu mendatar X = 4 dan sumbu tegak Y = 6. Pilih opsi Koordinat (X: 4, Y: 6)!']
                ],
                'reflection' => [
                    'question' => 'Mengapa para astronot dan pelaut menggunakan koordinat untuk menentukan posisi?',
                    'options' => [
                        'Agar dapat menentukan lokasi titik secara tepat dan tidak tersesat di ruang angkasa yang luas.',
                        'Agar bintang-bintang bisa bertukar tempat.',
                        'Supaya roket bisa berjalan mundur tanpa kemudi.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
        [
            'world_id' => $worldMap['space-odyssey'],
            'slug' => 'rover-mars',
            'title' => 'Petualangan Rover Penjelajah Mars',
            'subtitle' => 'Kirim instruksi arah agar Rover robot melewati jalur aman menghindari kawah meteor!',
            'learning_objective' => 'Melatih perencanaan rute spasial berurutan untuk menghindari rintangan bahaya.',
            'interaction_type' => 'sequence_logic',
            'xp_reward' => 100,
            'sort_order' => 3,
            'config_json' => json_encode([
                'scenario' => 'Rover penjelajah Mars mendarat di grid awal [0,0]. Di sebelah kanan [1,0] ada kawah meteor curam! Pandu Rover melalui rute aman ke Stasiun Riset di [2,1]!',
                'start' => ['x' => 0, 'y' => 0],
                'goal' => ['x' => 2, 'y' => 1],
                'hazards' => [['x' => 1, 'y' => 0]],
                'hints' => [
                    ['level' => 1, 'text' => 'Jangan langsung jalan ke kanan karena ada kawah berbahaya di posisi (1,0)!'],
                    ['level' => 2, 'text' => 'Arahkan Rover turun ke bawah dulu (Bawah), lalu melangkah ke kanan (Kanan, Kanan) menuju stasiun.'],
                    ['level' => 3, 'text' => 'Pilih urutan rute: [Turun / Bawah] -> [Kanan] -> [Kanan] untuk mencapai stasiun riset dengan selamat!']
                ],
                'reflection' => [
                    'question' => 'Mengapa robot penjelajah di planet Mars harus diprogram dengan rute penghindar rintangan?',
                    'options' => [
                        'Karena sinyal bumi membutuhkan waktu lama untuk sampai ke Mars, sehingga robot harus mengikuti instruksi rute aman terencana.',
                        'Karena robot Mars suka bermain lompat tali di kawah.',
                        'Karena di Mars tidak ada udara dan robot harus tidur siang.'
                    ],
                    'correct' => 0
                ]
            ], JSON_UNESCAPED_UNICODE)
        ],
    ];

    $stmtMission = $pdo->prepare("INSERT " . ($driver === 'mysql' ? "IGNORE" : "OR IGNORE") . " INTO missions (world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json) VALUES (:world_id, :slug, :title, :subtitle, :learning_objective, :interaction_type, :xp_reward, :sort_order, :config_json)");
    foreach ($missions as $m) {
        $stmtMission->execute($m);
    }
    echo "12 Missions seeded.\n";

    // Seed Achievements
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
    $pdo->exec("UPDATE achievements SET criteria_threshold = 12, description = 'Luar biasa! Menyelesaikan seluruh 12 misi di MISSION KIDS!' WHERE slug = 'mission-master'");
    echo "6 Achievements seeded.\n";

    echo "=== Migration & Seeding COMPLETED SUCCESSFULLY ===\n";
} catch (Exception $e) {
    echo "Migration Error: " . $e->getMessage() . "\n";
    exit(1);
}
