-- MISSION KIDS Database Schema (MySQL/MariaDB)

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    nickname VARCHAR(60) NOT NULL,
    avatar_id VARCHAR(30) NOT NULL DEFAULT 'astro_cat',
    current_level INT UNSIGNED NOT NULL DEFAULT 1,
    total_xp INT UNSIGNED NOT NULL DEFAULT 0,
    preferred_world_id INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS worlds (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(100) NOT NULL,
    subtitle VARCHAR(150) NOT NULL,
    theme_color VARCHAR(20) NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS missions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    world_id INT UNSIGNED NOT NULL,
    slug VARCHAR(60) NOT NULL UNIQUE,
    title VARCHAR(120) NOT NULL,
    subtitle VARCHAR(200) NOT NULL,
    learning_objective TEXT NOT NULL,
    interaction_type VARCHAR(40) NOT NULL,
    xp_reward INT UNSIGNED NOT NULL DEFAULT 100,
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    config_json LONGTEXT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (world_id) REFERENCES worlds(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mission_progress (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    mission_id INT UNSIGNED NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'locked',
    stars TINYINT UNSIGNED NOT NULL DEFAULT 0,
    completed_at DATETIME NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_mission (user_id, mission_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mission_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    mission_id INT UNSIGNED NOT NULL,
    hints_used TINYINT UNSIGNED NOT NULL DEFAULT 0,
    is_success TINYINT(1) NOT NULL,
    reflection_answer TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS xp_transactions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    amount INT NOT NULL,
    source_type VARCHAR(50) NOT NULL,
    reference_id INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(60) NOT NULL UNIQUE,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    icon_name VARCHAR(50) NOT NULL,
    xp_reward INT UNSIGNED NOT NULL DEFAULT 50,
    criteria_type VARCHAR(50) NOT NULL,
    criteria_threshold INT UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS user_achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    achievement_id INT UNSIGNED NOT NULL,
    unlocked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_achievement (user_id, achievement_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (achievement_id) REFERENCES achievements(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- =============================================
-- SEED DATA: WORLDS, MISSIONS & ACHIEVEMENTS
-- =============================================

INSERT INTO worlds (id, slug, title, subtitle, theme_color, sort_order, is_active) VALUES (1, 'number-city', 'Number City', 'Petualangan Angka, Belanja & Pola Logika', '#F59E0B', 1, 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO worlds (id, slug, title, subtitle, theme_color, sort_order, is_active) VALUES (2, 'discovery-lab', 'Discovery Lab', 'Eksperimen Alam, Cahaya & Sains Nyata', '#10B981', 2, 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO worlds (id, slug, title, subtitle, theme_color, sort_order, is_active) VALUES (3, 'thinking-lab', 'Thinking Lab', 'Logika Algoritma & Petualangan Robot', '#6366F1', 3, 1) ON DUPLICATE KEY UPDATE title=VALUES(title);

INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (1, 1, 'toko-kue', 'Toko Kue Donat Bibi Bella', 'Bantu kasir menyiapkan pesanan dan menghitung uang kembalian!', 'Melatih operasi penjumlahan dan pengurangan sederhana serta pecahan uang.', 'match_sort', 100, 1, '{"scenario":"Pembeli ingin membeli 2 Donat Cokelat (Rp 2.000 per donat). Pembeli membayar dengan uang kertas Rp 5.000.","question":"Berapa total harga donat dan berapa koin kembalian yang harus ditaruh di nampan kasir?","items":[{"id":"donut_1","name":"Donat Cokelat","price":2000,"type":"goods","icon":"🍩"},{"id":"donut_2","name":"Donat Cokelat","price":2000,"type":"goods","icon":"🍩"},{"id":"coin_500","name":"Koin Rp 500","price":500,"type":"coin","icon":"🪙"},{"id":"coin_1000","name":"Koin Rp 1.000","price":1000,"type":"coin","icon":"🪙"},{"id":"coin_2000","name":"Koin Rp 2.000","price":2000,"type":"coin","icon":"🪙"}],"target_goods_count":2,"target_change":1000,"hints":[{"level":1,"text":"Coba hitung dulu: 2 donat @ Rp 2.000 berarti berapa ya? 2.000 + 2.000 = ... ?"},{"level":2,"text":"Total kuenya Rp 4.000. Jika uang pembeli Rp 5.000, hitung: 5.000 dikurangi 4.000!"},{"level":3,"text":"Letakkan 2 Donat dan 1 koin Rp 1.000 di nampan kasir!"}],"reflection":{"question":"Mengapa penting memeriksa uang kembalian saat berbelanja?","options":["Agar kita tahu jumlah uang yang kita miliki tetap tepat dan jujur.","Agar kasir memberikan semua donat di toko secara gratis.","Supaya kita bisa membuang koin ke jalan."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (2, 1, 'jembatan-angka', 'Jembatan Angka yang Hilang', 'Temukan angka loncat misterius untuk menyambung jembatan!', 'Mengenal pola deret hitung bertingkat dan lompatan angka.', 'match_sort', 100, 2, '{"scenario":"Balok penyeberangan jembatan memiliki pola deret: 3, 7, 11, [ ? ], 19.","question":"Balok nomor berapa yang harus dipasang untuk melengkapi jembatan?","pattern_step":4,"sequence":[3,7,11,null,19],"correct_value":15,"choices":[13,14,15,16],"hints":[{"level":1,"text":"Berapa jarak dari angka 3 ke angka 7? Dan dari 7 ke 11? Polanya melompat berapa angka?"},{"level":2,"text":"Setiap angka bertambah 4 (+4). Jadi, 11 ditambah 4 hasilnya berapa?"},{"level":3,"text":"11 + 4 = 15! Pasang balok angka 15 ke bagian jembatan yang kosong."}],"reflection":{"question":"Pola apa yang membuatmu menemukan angka jembatan yang hilang?","options":["Setiap papan selalu melompat bertambah 4 (+4)","Angkanya dipilih secara acak tanpa aturan","Setiap papan dikurangi 10"],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (3, 1, 'kota-pola', 'Taman Lampu Kristal Berpola', 'Pasang kristal warna lampu taman agar bersinar serasi!', 'Melatih pengenalan pola berulang visual dan keteraturan ritme.', 'match_sort', 100, 3, '{"scenario":"Lampu taman memiliki deret kristal: [Merah] [Kuning] [Biru] [Merah] [Kuning] [ ? ].","question":"Kristal warna apa yang harus dipasang pada slot terakhir agar lampu menyala?","pattern":["red","yellow","blue"],"sequence":["red","yellow","blue","red","yellow",null],"correct_value":"blue","choices":[{"color":"blue","label":"Kristal Biru","hex":"#3B82F6"},{"color":"green","label":"Kristal Hijau","hex":"#10B981"},{"color":"purple","label":"Kristal Ungu","hex":"#8B5CF6"}],"hints":[{"level":1,"text":"Lihat 3 warna pertama: Merah, Kuning, lalu apa?"},{"level":2,"text":"Pola warna ini berulang setiap 3 kristal: Merah - Kuning - Biru."},{"level":3,"text":"Setelah Merah dan Kuning, warna berikutnya pasti Biru! Pasang kristal biru."}],"reflection":{"question":"Mengapa mengenali pola membantu kita menyelesaikan masalah lebih cepat?","options":["Karena pola membantu kita memprediksi apa yang terjadi selanjutnya.","Karena pola membuat lampu meledak.","Pola hanya berguna untuk mencoret-coret buku."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (4, 2, 'tanaman-layu', 'Dokter Tanaman: Bunga Matahari', 'Bunga matahari lab layu! Berikan air dan sinar matahari yang cukup agar mekar!', 'Memahami kebutuhan dasar tumbuhan (air dan cahaya fotosintesis) melalui simulasi interaktif.', 'simulation', 100, 1, '{"scenario":"Bunga matahari mini di laboratorium tampak layu dan batangnya menunduk lesu. Sebagai Dokter Tanaman, atur air dan cahaya agar bunga segar kembali!","initial_state":{"water":15,"sunlight":20,"health":20},"target_ranges":{"water":{"min":60,"max":85,"label":"Air Lembab Ideal (60-85%)"},"sunlight":{"min":65,"max":90,"label":"Cahaya Terang Ideal (65-90%)"}},"hints":[{"level":1,"text":"Lihat tanahnya yang kering retak dan ruangan yang gelap. Apa 2 hal yang paling disukai tumbuhan?"},{"level":2,"text":"Gunakan gembor untuk menyiram air sampai indikator hijau, lalu geser tirai jendela agar sinar matahari masuk!"},{"level":3,"text":"Atur kadar air ke sekitar 75% dan buka tirai matahari hingga 80%. Bunga akan langsung tersenyum mekar!"}],"reflection":{"question":"Apa yang terjadi jika tanaman disiram air berlebihan hingga banjir?","options":["Akar tanaman bisa membusuk dan tanaman sulit bernapas.","Tanaman langsung berubah menjadi pohon raksasa seketika.","Tanaman tidak membutuhkan tanah sama sekali."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (5, 2, 'misteri-bayangan', 'Misteri Teater Bayangan Kelinci', 'Atur posisi senter agar bayangan kelinci pas dengan ukuran panggung pentas!', 'Memahami perambatan cahaya lurus dan pengaruh jarak sumber cahaya terhadap ukuran bayangan.', 'simulation', 100, 2, '{"scenario":"Di panggung teater boneka, siluet bayangan kelinci harus pas memenuhi garis target di layar pentas.","initial_state":{"torch_distance":80,"shadow_scale":45},"target_scale":{"min":75,"max":85},"hints":[{"level":1,"text":"Apa yang terjadi jika kamu mendekatkan senter ke arah boneka kelinci?"},{"level":2,"text":"Semakin dekat senter ke benda, bayangan di layar akan menjadi semakin BESAR!"},{"level":3,"text":"Geser senter mendekat ke angka jarak 25-30 agar ukuran bayangan membesar pas 80%!"}],"reflection":{"question":"Jika kita ingin membuat bayangan benda menjadi lebih kecil, apa yang harus dilakukan?","options":["Menjauhkan sumber cahaya dari benda.","Mendekatkan senter sedekat mungkin ke benda.","Mematikan lampu dan meniup layar."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (6, 2, 'perjalanan-air', 'Petualangan Tetes Air di Awan', 'Susun 3 tahapan siklus air alam agar hujan turun menyegarkan danau!', 'Mengenal siklus air alamiah: Penguapan (Evaporasi) -> Awan (Kondensasi) -> Hujan (Presipitasi).', 'match_sort', 100, 3, '{"scenario":"Danau buatan laboratorium kering saat musim panas. Bantu MIKO mengaktifkan mesin waktu siklus air dalam urutan yang benar!","slots":["Tahap 1: Penguapan","Tahap 2: Pembentukan Awan","Tahap 3: Hujan Turun"],"cards":[{"id":"card_evap","title":"Air Menguap ke Udara","stage":1,"desc":"Panas matahari mengubah air menjadi uap tak kasat mata."},{"id":"card_cond","title":"Uap Membentuk Awan","stage":2,"desc":"Uap air di langit yang dingin berkumpul menjadi awan tebal."},{"id":"card_prec","title":"Tetes Hujan Turun","stage":3,"desc":"Awan yang sudah sangat berat meneteskan air hujan kembali ke bumi."}],"hints":[{"level":1,"text":"Sebelum menjadi awan, air di danau harus terkena sinar matahari dulu dan menguap ke atas."},{"level":2,"text":"Urutannya: Air menguap -> Uap berkumpul jadi awan mendung -> Hujan turun ke bumi."},{"level":3,"text":"Letakkan kartu \\"Air Menguap\\" di kotak 1, \\"Membentuk Awan\\" di kotak 2, dan \\"Hujan Turun\\" di kotak 3!"}],"reflection":{"question":"Kemana perginya air hujan setelah jatuh ke tanah dan sungai?","options":["Mengalir kembali ke laut dan danau, lalu siklus menguap berulang lagi.","Hilang selamanya dan tidak pernah ada air lagi di bumi.","Berubah menjadi batu es raksasa di ruang angkasa."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (7, 3, 'robot-pulang', 'Robot Botty Pulang ke Rumah', 'Susun kartu perintah langkah agar Botty sampai ke stasiun daya baterai!', 'Melatih pemikiran komputasional berbasis urutan instruksi (sequence execution).', 'sequence_logic', 100, 1, '{"scenario":"Baterai Robot Botty hampir habis! Susun perintah kartu [Maju] dan [Putar] agar Botty tiba di stasiun cas tanpa menabrak batu.","grid_size":4,"start":{"x":0,"y":0,"dir":"right"},"target":{"x":2,"y":2},"obstacles":[{"x":1,"y":1},{"x":0,"y":2}],"available_commands":["FORWARD","TURN_RIGHT","TURN_LEFT"],"hints":[{"level":1,"text":"Arahkan Botty melangkah maju dulu, lalu belok ke arah stasiun pengisian baterai."},{"level":2,"text":"Hati-hati dengan batu di tengah grid! Botty bisa maju 2 langkah, putar kanan, lalu maju 2 langkah."},{"level":3,"text":"Susun urutan kartu: [Maju] -> [Maju] -> [Putar Kanan] -> [Maju] -> [Maju] lalu klik Jalankan!"}],"reflection":{"question":"Mengapa komputer atau robot harus diberi instruksi langkah demi langkah yang runtut?","options":["Karena robot hanya bisa menjalankan instruksi sesuai urutan yang kita tulis.","Karena robot bisa membaca pikiran kita tanpa instruksi.","Supaya robot bisa memakan baterai seperti camilan."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (8, 3, 'jalan-rahasia', 'Sensor Pintu Jalan Rahasia', 'Pilih jalur aman dengan membaca rambu kondisi sensor lampu warna!', 'Memahami konsep logika percabangan (Conditionals: IF / THEN) secara visual.', 'sequence_logic', 100, 2, '{"scenario":"Jembatan lurus terkunci lampu merah. Hanya jembatan dengan lampu sensor HIJAU yang aman untuk dilewati!","condition":"JIKA lampu Hijau -> Buka Jembatan Bawah; JIKA lampu Merah -> Hindari Jembatan Atas.","target_path":["DOWN","FORWARD","FORWARD","UP","FORWARD"],"hints":[{"level":1,"text":"Lihat warna lampu di jembatan atas dan bawah. Mana jembatan yang terbuka aman?"},{"level":2,"text":"Jembatan bawah menyala hijau! Arahkan Botty turun ke bawah terlebih dahulu."},{"level":3,"text":"Pilih rute: [Turun] -> [Maju] -> [Maju] -> [Naik] -> [Maju] ke garis akhir!"}],"reflection":{"question":"Kapan kita menggunakan aturan \\"JIKA... MAKA...\\" dalam kehidupan sehari-hari?","options":["JIKA hari hujan, MAKA kita membawa payung.","JIKA kita tidur, MAKA kita berlari keliling lapangan.","JIKA hari cerah, MAKA bintang malam terlihat di siang hari."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO missions (id, world_id, slug, title, subtitle, learning_objective, interaction_type, xp_reward, sort_order, config_json, is_active) VALUES (9, 3, 'robot-mengulang', 'Robot Pintar Kartu Mengulang (Loop)', 'Ringkas langkah Botty menaiki anak tangga dengan Kartu Perulangan!', 'Menumbuhkan pemahaman konsep perulangan (Loops) untuk efisiensi instruksi.', 'sequence_logic', 100, 3, '{"scenario":"Botty harus menaiki 4 anak tangga yang sama. Daripada menyusun 8 kartu panjang, gunakan kartu [Ulangi 4 Kali: (Lompat, Maju)]!","steps_count":4,"target_block":{"loop_times":4,"actions":["JUMP","FORWARD"]},"hints":[{"level":1,"text":"Setiap anak tangga membutuhkan 2 gerakan: Lompat ke atas, lalu Maju."},{"level":2,"text":"Karena ada 4 anak tangga yang sama persis, kita bisa memasukkan gerakan itu ke dalam Kartu Pengulang 4x!"},{"level":3,"text":"Pasang kartu [Ulangi 4x] dan masukkan [Lompat] + [Maju] di dalamnya!"}],"reflection":{"question":"Apa manfaat menggunakan kartu perulangan (loop) dibanding menyusun kartu yang sama berkali-kali?","options":["Membuat instruksi jauh lebih ringkas, rapi, dan hemat tenaga.","Membuat robot melambat hingga berhenti total.","Menghapus semua program yang ada di komputer."],"correct":0}}', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);

INSERT INTO achievements (id, slug, title, description, icon_name, xp_reward, criteria_type, criteria_threshold) VALUES (1, 'first-mission', 'Langkah Pertama', 'Berhasil menyelesaikan misi pertama di MISSION KIDS!', 'rocket', 50, 'total_missions', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO achievements (id, slug, title, description, icon_name, xp_reward, criteria_type, criteria_threshold) VALUES (2, 'number-explorer', 'Penjelajah Angka', 'Menyelesaikan seluruh misi di Number City!', 'calculator', 100, 'world_complete', 1) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO achievements (id, slug, title, description, icon_name, xp_reward, criteria_type, criteria_threshold) VALUES (3, 'little-scientist', 'Dokter Alam Cilik', 'Menyelesaikan seluruh misi eksperimen di Discovery Lab!', 'flask', 100, 'world_complete', 2) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO achievements (id, slug, title, description, icon_name, xp_reward, criteria_type, criteria_threshold) VALUES (4, 'logic-commander', 'Kapten Logika', 'Menyelesaikan seluruh misi pemrograman di Thinking Lab!', 'cpu', 100, 'world_complete', 3) ON DUPLICATE KEY UPDATE title=VALUES(title);
INSERT INTO achievements (id, slug, title, description, icon_name, xp_reward, criteria_type, criteria_threshold) VALUES (5, 'mission-master', 'Master Penjelajah Sejati', 'Luar biasa! Menyelesaikan seluruh 9 misi di MISSION KIDS!', 'trophy', 250, 'total_missions', 9) ON DUPLICATE KEY UPDATE title=VALUES(title);
