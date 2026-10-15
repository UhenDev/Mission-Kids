<?php
/**
 * MISSION KIDS — Master Missions Dataset (80 Missions: 20 per World)
 */

declare(strict_types=1);

$allWorldMissions = [
    // =========================================================================
    // WORLD 1: NUMBER CITY (20 MISI NUMERASI & ARITMETIKA)
    // =========================================================================
    [
        'world_slug' => 'number-city',
        'slug' => 'toko-kue',
        'title' => 'Toko Kue Donat Bibi Bella',
        'subtitle' => 'Bantu kasir menyiapkan pesanan dan menghitung uang kembalian!',
        'learning_objective' => 'Melatih operasi penjumlahan dan pengurangan sederhana serta pecahan uang.',
        'interaction_type' => 'match_sort',
        'xp_reward' => 100,
        'sort_order' => 1,
        'config' => [
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
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'jembatan-angka',
        'title' => 'Jembatan Angka yang Hilang',
        'subtitle' => 'Temukan angka loncat misterius untuk menyambung jembatan Number City!',
        'learning_objective' => 'Mengenal pola deret bilangan dan lompatan aritmetika bertingkat.',
        'interaction_type' => 'match_sort',
        'xp_reward' => 100,
        'sort_order' => 2,
        'config' => [
            'scenario' => 'Jembatan kayu terputus! Ada papan bertuliskan: 2, 4, [ ? ], 8, 10. Pasang balok angka yang tepat agar Miko bisa menyeberang!',
            'question' => 'Berapa angka yang hilang pada jembatan deret bilangan lompat dua?',
            'sequence' => [2, 4, null, 8, 10],
            'choices' => [5, 6, 7],
            'correct_value' => 6,
            'correct_answer' => '6',
            'hints' => [
                ['level' => 1, 'text' => 'Perhatikan jarak dari 2 ke 4, bertambah berapa ya? Betul, bertambah 2!'],
                ['level' => 2, 'text' => 'Setelah angka 4, tambahkan 2 lagi. 4 + 2 = ... ?'],
                ['level' => 3, 'text' => 'Pilih angka 6 untuk melengkapi jembatan!']
            ],
            'reflection' => [
                'question' => 'Kapan kita sering menggunakan hitungan melompat dalam kehidupan sehari-hari?',
                'options' => [
                    'Saat menghitung pasang sepatu (dua-dua) atau kelipatan lima pada jam.',
                    'Saat kita sedang tidur pulas di malam hari.',
                    'Saat kita meniup lilin ulang tahun.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'kota-pola',
        'title' => 'Taman Lampu Kristal Berpola',
        'subtitle' => 'Pasang kristal warna lampu taman agar bersinar dalam harmoni ritme pola!',
        'learning_objective' => 'Pengenalan pola berulang visual (AB-AB-AB) dan keteraturan urutan.',
        'interaction_type' => 'match_sort',
        'xp_reward' => 100,
        'sort_order' => 3,
        'config' => [
            'scenario' => 'Lampu taman kota memiliki urutan kristal: Merah, Biru, Merah, Biru, Merah, [ ? ]. Lampu terakhir belum terpasang!',
            'question' => 'Kristal warna apa yang harus dipasang agar pola lampu taman menyala sempurna?',
            'pattern' => ['Merah', 'Biru', 'Merah', 'Biru', 'Merah', null],
            'choices' => ['Kuning', 'Biru', 'Hijau'],
            'correct_color' => 'Biru',
            'correct_answer' => 'Biru',
            'hints' => [
                ['level' => 1, 'text' => 'Perhatikan urutannya: setelah Merah selalu muncul warna apa?'],
                ['level' => 2, 'text' => 'Pola bergantian: Merah lalu Biru, lalu Merah lalu Biru.'],
                ['level' => 3, 'text' => 'Pilih kristal warna Biru!']
            ],
            'reflection' => [
                'question' => 'Mengapa lampu lalu lintas di jalan raya juga menggunakan pola warna yang teratur?',
                'options' => [
                    'Supaya pengendara mudah mengerti kapan harus berhenti dan jalan dengan aman.',
                    'Supaya jalan raya terlihat seperti panggung konser musik.',
                    'Supaya mobil bisa berjalan mundur terus-menerus.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'keranjang-buah',
        'title' => 'Pasar Buah Segar Paman Sam',
        'subtitle' => 'Hitung total buah segar pesanan kelinci di pasar Number City!',
        'learning_objective' => 'Penjumlahan dua kelompok benda konkret hingga bilangan 20.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 4,
        'config' => [
            'scenario' => 'Paman Sam memiliki 7 buah Apel Merah 🍎 dan 8 buah Jeruk Manis 🍊 di keranjang belanja.',
            'question' => 'Berapa jumlah seluruh buah segar yang ada di dalam keranjang belanja?',
            'visual_hint' => '🍎 7 Apel + 🍊 8 Jeruk = ?',
            'options' => [
                ['id' => '13', 'text' => '13 Buah Segar', 'icon' => '🍇'],
                ['id' => '15', 'text' => '15 Buah Segar', 'icon' => '🍎'],
                ['id' => '16', 'text' => '16 Buah Segar', 'icon' => '🍊'],
                ['id' => '14', 'text' => '14 Buah Segar', 'icon' => '🍋']
            ],
            'correct_answer' => '15',
            'hints' => [
                ['level' => 1, 'text' => 'Coba simpan angka 7 di kepalamu, lalu hitung maju 8 langkah.'],
                ['level' => 2, 'text' => '7 + 3 = 10, lalu tambahkan sisa 5 lagi. 10 + 5 = ... ?'],
                ['level' => 3, 'text' => 'Jawabannya adalah 15 buah!']
            ],
            'reflection' => [
                'question' => 'Mengapa buah-buahan baik dikonsumsi setiap hari?',
                'options' => [
                    'Mengandung vitamin dan serat yang membuat tubuh kuat dan sehat.',
                    'Karena buah rasanya seperti batu es.',
                    'Supaya kita tidak perlu minum air putih lagi.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'menara-balok',
        'title' => 'Menara Balok Warna-Warni',
        'subtitle' => 'Hitung sisa balok setelah menara kastel diperbaiki oleh arsitek cilik!',
        'learning_objective' => 'Operasi pengurangan dengan benda susun balok konkret.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 5,
        'config' => [
            'scenario' => 'Menara kastel semula tersusun dari 18 balok batu 🧱. Angin kencang menjatuhkan 6 balok batu ke tanah.',
            'question' => 'Berapa banyak balok batu yang masih kokoh berdiri di menara kastel?',
            'visual_hint' => '🧱 18 Balok Semula - 6 Balok Jatuh = ?',
            'options' => [
                ['id' => '10', 'text' => '10 Balok Berdiri', 'icon' => '🏰'],
                ['id' => '12', 'text' => '12 Balok Berdiri', 'icon' => '🧱'],
                ['id' => '14', 'text' => '14 Balok Berdiri', 'icon' => '🏗️'],
                ['id' => '11', 'text' => '11 Balok Berdiri', 'icon' => '🏯']
            ],
            'correct_answer' => '12',
            'hints' => [
                ['level' => 1, 'text' => 'Kurangkan angka satuannya dulu: 8 dikurangi 6 sama dengan berapa?'],
                ['level' => 2, 'text' => '8 - 6 = 2, ditambah 1 puluhan (10) menjadi 12.'],
                ['level' => 3, 'text' => 'Pilih 12 balok batu!']
            ],
            'reflection' => [
                'question' => 'Mengapa pondasi bangunan harus dibuat kuat dan seimbang?',
                'options' => [
                    'Agar bangunan tidak mudah roboh saat terkena guncangan atau beban berat.',
                    'Agar warnanya bisa berubah menjadi pelangi.',
                    'Supaya burung tidak bisa hinggap di atap.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'jam-ajaib',
        'title' => 'Jam Dinding Ajaib Kastel',
        'subtitle' => 'Membaca jarum jam analog waktu petualangan Miko dimulai!',
        'learning_objective' => 'Membaca waktu tepat dan setengah jam pada jam analog.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 6,
        'config' => [
            'scenario' => 'Lonceng kastel berbunyi! Jarum pendek menunjuk ke angka 4, dan jarum panjang menunjuk tepat ke angka 12.',
            'question' => 'Pukul berapakah jam dinding kastel saat lonceng berdentang?',
            'visual_hint' => '🕰️ Jarum Pendek di 4 | Jarum Panjang di 12',
            'options' => [
                ['id' => '12', 'text' => 'Pukul 12.00 Tepat', 'icon' => '🕛'],
                ['id' => '4', 'text' => 'Pukul 04.00 Tepat', 'icon' => '🕓'],
                ['id' => '6', 'text' => 'Pukul 06.00 Tepat', 'icon' => '🕕'],
                ['id' => '4.30', 'text' => 'Pukul 04.30', 'icon' => '🕟']
            ],
            'correct_answer' => '4',
            'hints' => [
                ['level' => 1, 'text' => 'Jarum pendek menunjukkan jam, jarum panjang menunjukkan menit.'],
                ['level' => 2, 'text' => 'Jarum panjang di angka 12 berarti menitnya 00 (tepat).'],
                ['level' => 3, 'text' => 'Karena jarum pendek di 4, maka pukul 04.00 tepat!']
            ],
            'reflection' => [
                'question' => 'Mengapa bangun pagi tepat waktu membuat hari kita lebih menyenangkan?',
                'options' => [
                    'Kita punya cukup waktu sarapan, bersiap santai, dan tidak terburu-buru.',
                    'Supaya kita bisa menonton TV seharian penuh tanpa belajar.',
                    'Supaya matahari berhenti bersinar di langit.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'pizzaria-pecahan',
        'title' => 'Pesta Pizza Ceria',
        'subtitle' => 'Bagi pizza hangat menjadi potongan yang adil untuk sahabat petualang!',
        'learning_objective' => 'Mengenal konsep dasar pecahan sederhana (1/2, 1/4).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 7,
        'config' => [
            'scenario' => 'Sebuah loyang pizza bulat 🍕 dipotong menjadi 4 bagian sama besar. Kian memakan 1 potong.',
            'question' => 'Berapa nilai pecahan untuk 1 potong pizza yang dimakan Kian dari seluruh loyang?',
            'visual_hint' => '🍕 1 Potong dari 4 Bagian Sama Besar = ?',
            'options' => [
                ['id' => '1/2', 'text' => 'Setengah (1/2 Bagian)', 'icon' => '🍕'],
                ['id' => '1/4', 'text' => 'Seperempat (1/4 Bagian)', 'icon' => '🍕'],
                ['id' => '1/3', 'text' => 'Sepertiga (1/3 Bagian)', 'icon' => '🍕'],
                ['id' => '4/1', 'text' => 'Empat Utuh (4/1 Bagian)', 'icon' => '🥧']
            ],
            'correct_answer' => '1/4',
            'hints' => [
                ['level' => 1, 'text' => 'Ada 4 potong sama besar seluruhnya. Yang diambil adalah 1 potong.'],
                ['level' => 2, 'text' => 'Dalam pecahan ditulis: 1 di atas (pembilang) dan 4 di bawah (penyebut).'],
                ['level' => 3, 'text' => 'Pilih 1/4 (seperempat)!']
            ],
            'reflection' => [
                'question' => 'Mengapa saat berbagi makanan dengan teman potongannya harus sama rata?',
                'options' => [
                    'Agar adil dan semua teman merasa dihargai dengan gembira.',
                    'Supaya teman tidak mau bermain dengan kita lagi.',
                    'Supaya piring kita menjadi pecah.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'kebun-wortel',
        'title' => 'Kebun Wortel Kelinci Cerdik',
        'subtitle' => 'Hitung kelompok wortel panen menggunakan konsep perkalian dasar!',
        'learning_objective' => 'Perkalian sebagai penjumlahan berulang benda teratur.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 8,
        'config' => [
            'scenario' => 'Ada 4 petak kebun wortel 🥕. Setiap petak ditanami 3 batang wortel segar.',
            'question' => 'Berapa total wortel yang bisa dipanen oleh kelinci cerdik? (4 × 3 = ?)',
            'visual_hint' => '🥕🥕🥕 + 🥕🥕🥕 + 🥕🥕🥕 + 🥕🥕🥕 = ?',
            'options' => [
                ['id' => '9', 'text' => '9 Batang Wortel', 'icon' => '🥕'],
                ['id' => '12', 'text' => '12 Batang Wortel', 'icon' => '🥕'],
                ['id' => '15', 'text' => '15 Batang Wortel', 'icon' => '🥕'],
                ['id' => '7', 'text' => '7 Batang Wortel', 'icon' => '🌱']
            ],
            'correct_answer' => '12',
            'hints' => [
                ['level' => 1, 'text' => 'Hitung penjumlahan berulang: 3 + 3 + 3 + 3.'],
                ['level' => 2, 'text' => '3 + 3 = 6. Lalu 6 + 6 = 12.'],
                ['level' => 3, 'text' => '4 kelompok dari 3 wortel menghasilkan 12 wortel!']
            ],
            'reflection' => [
                'question' => 'Apa keuntungan mengetahui rumus perkalian dibanding menjumlahkan satu per satu?',
                'options' => [
                    'Kita bisa menghitung jumlah banyak barang dengan jauh lebih cepat dan tepat.',
                    'Perkalian membuat kita lupa cara menghitung.',
                    'Supaya kita tidak perlu menulis angka lagi di kertas.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'timbangan-hewan',
        'title' => 'Timbangan Jungkat-Jungkit Satwa',
        'subtitle' => 'Bandingkan berat satwa di taman bermain Number City!',
        'learning_objective' => 'Konsep perbandingan berat (lebih berat, lebih ringan, seimbang).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 9,
        'config' => [
            'scenario' => 'Di papan jungkat-jungkit ⚖️, Gajah Cilik 🐘 duduk di sisi kiri dan posisinya turun ke bawah tanah, sedangkan Kucing 🐱 di sisi kanan terangkat tinggi ke atas.',
            'question' => 'Berdasarkan jungkat-jungkit tersebut, siapakah yang bobotnya LEBIH BERAT?',
            'visual_hint' => '🐘 Sisi Kiri Turun Ke Bawah ⬇️ vs 🐱 Sisi Kanan Terangkat Ke Atas ⬆️',
            'options' => [
                ['id' => 'gajah', 'text' => 'Gajah Cilik Lebih Berat', 'icon' => '🐘'],
                ['id' => 'kucing', 'text' => 'Kucing Lebih Berat', 'icon' => '🐱'],
                ['id' => 'sama', 'text' => 'Keduanya Sama Berat', 'icon' => '⚖️'],
                ['id' => 'tidak_tahu', 'text' => 'Jungkat-Jungkit Rusak', 'icon' => '❓']
            ],
            'correct_answer' => 'gajah',
            'hints' => [
                ['level' => 1, 'text' => 'Sisi jungkat-jungkit yang turun ke bawah adalah sisi yang ditekan beban lebih besar.'],
                ['level' => 2, 'text' => 'Benda yang lebih berat akan menekan papan ke arah bawah.'],
                ['level' => 3, 'text' => 'Pilih Gajah Cilik Lebih Berat!']
            ],
            'reflection' => [
                'question' => 'Jika kita ingin jungkat-jungkit menjadi seimbang (lurus rata), apa yang harus dilakukan?',
                'options' => [
                    'Berat beban di kedua sisi papan harus bernilai sama besar.',
                    'Kedua hewan harus melompat ke kolam renang.',
                    'Mengecat jungkat-jungkit dengan warna kuning.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'bus-sekolah',
        'title' => 'Halte Bus Sekolah Ceria',
        'subtitle' => 'Hitung penumpang bus kuning ramah anak di jalan kota!',
        'learning_objective' => 'Operasi hitung gabungan penjumlahan dan pengurangan bertahap.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 10,
        'config' => [
            'scenario' => 'Bus sekolah kuning 🚌 awalnya membawa 10 anak. Di halte pertama naik 5 anak 👦👧, lalu di halte kedua turun 3 anak.',
            'question' => 'Berapa banyak anak yang sekarang ada di dalam bus sekolah?',
            'visual_hint' => '10 Penumpang Awal + 5 Naik - 3 Turun = ?',
            'options' => [
                ['id' => '11', 'text' => '11 Anak di Dalam Bus', 'icon' => '🎒'],
                ['id' => '12', 'text' => '12 Anak di Dalam Bus', 'icon' => '🚌'],
                ['id' => '15', 'text' => '15 Anak di Dalam Bus', 'icon' => '🧒'],
                ['id' => '8', 'text' => '8 Anak di Dalam Bus', 'icon' => '🚏']
            ],
            'correct_answer' => '12',
            'hints' => [
                ['level' => 1, 'text' => 'Hitung dulu halte pertama: 10 ditambah 5 = 15.'],
                ['level' => 2, 'text' => 'Lalu kurangkan halte kedua: 15 dikurangi 3 = ... ?'],
                ['level' => 3, 'text' => '15 - 3 = 12 anak!']
            ],
            'reflection' => [
                'question' => 'Mengapa kita harus tertib antre saat naik dan turun dari bus sekolah?',
                'options' => [
                    'Agar semua penumpang aman, tidak saling dorong, dan tidak ada yang terjatuh.',
                    'Supaya bus berjalan lebih lambat seperti kura-kura.',
                    'Supaya supir bus mematikan mesinnya.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'tangga-bilangan',
        'title' => 'Lompat Tangga Bilangan Genap',
        'subtitle' => 'Bantu robot melompati anak tangga bilangan genap!',
        'learning_objective' => 'Membedakan konsep bilangan ganjil dan bilangan genap.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 11,
        'config' => [
            'scenario' => 'Botty harus melompat hanya di anak tangga bertuliskan BILANGAN GENAP (bisa dibagi dua tanpa sisa).',
            'question' => 'Di antara angka berikut, manakah yang merupakan BILANGAN GENAP?',
            'visual_hint' => 'Pilihan: 7, 9, 14, 15',
            'options' => [
                ['id' => '7', 'text' => 'Angka 7', 'icon' => '🪜'],
                ['id' => '14', 'text' => 'Angka 14 (Genap)', 'icon' => '⚡'],
                ['id' => '9', 'text' => 'Angka 9', 'icon' => '🪜'],
                ['id' => '15', 'text' => 'Angka 15', 'icon' => '🪜']
            ],
            'correct_answer' => '14',
            'hints' => [
                ['level' => 1, 'text' => 'Bilangan genap berakhiran 0, 2, 4, 6, atau 8.'],
                ['level' => 2, 'text' => 'Angka 14 jika dibagi 2 menghasilkan 7 pasang tepat tanpa sisa.'],
                ['level' => 3, 'text' => 'Pilih angka 14!']
            ],
            'reflection' => [
                'question' => 'Mengapa sepatu kita selalu dijual dalam jumlah genap (sepasang = 2 buah)?',
                'options' => [
                    'Karena kita memiliki dua kaki (kiri dan kanan) yang butuh perlindungan sepasang.',
                    'Karena angka ganjil dilarang oleh toko sepatu.',
                    'Supaya kotak sepatunya lebih berat.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'akuarium-ikan',
        'title' => 'Akuarium Ikan Warna Pelangi',
        'subtitle' => 'Bandingkan jumlah ikan mas dan ikan cupang di akuarium kaca!',
        'learning_objective' => 'Membandingkan dua kuantitas menggunakan simbol lebih besar (>).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 12,
        'config' => [
            'scenario' => 'Akuarium A berisi 24 ikan neon bercahaya 🐟. Akuarium B berisi 16 ikan guppy 🐠.',
            'question' => 'Tanda perbandingan matematika yang benar untuk 24 ... 16 adalah?',
            'visual_hint' => '24 Ikan Neon [ ? ] 16 Ikan Guppy',
            'options' => [
                ['id' => '>', 'text' => '> (Lebih Besar / Lebih Banyak)', 'icon' => '🐟'],
                ['id' => '<', 'text' => '< (Lebih Kecil / Lebih Sedikit)', 'icon' => '🐠'],
                ['id' => '=', 'text' => '= (Sama Banyak)', 'icon' => '⚖️'],
                ['id' => '!=', 'text' => 'Tidak Berisi Ikan', 'icon' => '🌊']
            ],
            'correct_answer' => '>',
            'hints' => [
                ['level' => 1, 'text' => '24 lebih banyak daripada 16.'],
                ['level' => 2, 'text' => 'Mulut tanda perbandingan (>) selalu terbuka ke arah angka yang lebih besar.'],
                ['level' => 3, 'text' => 'Pilih tanda lebih besar (>)!']
            ],
            'reflection' => [
                'question' => 'Mengapa ikan di akuarium membutuhkan filter gelembung udara?',
                'options' => [
                    'Untuk mengalirkan oksigen segar agar ikan bisa bernapas dan air tetap jernih.',
                    'Agar ikan bisa bermain bola air sepanjang hari.',
                    'Supaya air akuarium berubah menjadi sirup manis.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'celengan-koin',
        'title' => 'Tabungan Koin Impian',
        'subtitle' => 'Hitung total koin tabungan logam untuk membeli buku petualangan!',
        'learning_objective' => 'Menjumlahkan nilai mata uang koin ratusan dan ribuan rupiah.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 13,
        'config' => [
            'scenario' => 'Dika memiliki 3 koin Rp 1.000 🪙 dan 2 koin Rp 500 🪙 di dalam celengan ayamnya.',
            'question' => 'Berapa total nilai uang koin yang dikumpulkan Dika?',
            'visual_hint' => '(3 × Rp 1.000) + (2 × Rp 500) = ?',
            'options' => [
                ['id' => '3500', 'text' => 'Rp 3.500', 'icon' => '🪙'],
                ['id' => '4000', 'text' => 'Rp 4.000', 'icon' => '💰'],
                ['id' => '4500', 'text' => 'Rp 4.500', 'icon' => '🪙'],
                ['id' => '5000', 'text' => 'Rp 5.000', 'icon' => '💵']
            ],
            'correct_answer' => '4000',
            'hints' => [
                ['level' => 1, 'text' => 'Hitung koin seribuan dulu: 3 × 1.000 = 3.000.'],
                ['level' => 2, 'text' => 'Hitung koin lima ratusan: 500 + 500 = 1.000.'],
                ['level' => 3, 'text' => '3.000 + 1.000 = Rp 4.000!']
            ],
            'reflection' => [
                'question' => 'Apa manfaat membiasakan diri menabung sedikit demi sedikit sejak kecil?',
                'options' => [
                    'Kita belajar berhemat dan bisa membeli barang impian sendiri di masa depan.',
                    'Supaya uang kita habis dalam satu hari.',
                    'Supaya celengan kita cepat dibuang ke tempat sampah.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'pohon-apel',
        'title' => 'Petik Apel Merah & Hijau',
        'subtitle' => 'Jumlahkan hasil petik buah apel kebun kota Number City!',
        'learning_objective' => 'Penjumlahan bersusun dua digit tanpa menyimpan.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 14,
        'config' => [
            'scenario' => 'Nara memetik 23 Apel Merah 🍎 di pagi hari dan 14 Apel Hijau 🍏 di sore hari.',
            'question' => 'Berapa total seluruh buah apel yang berhasil dipetik Nara? (23 + 14 = ?)',
            'visual_hint' => 'Puluhan: 20 + 10 = 30 | Satuan: 3 + 4 = 7',
            'options' => [
                ['id' => '35', 'text' => '35 Buah Apel', 'icon' => '🍏'],
                ['id' => '37', 'text' => '37 Buah Apel', 'icon' => '🍎'],
                ['id' => '39', 'text' => '39 Buah Apel', 'icon' => '🍎'],
                ['id' => '47', 'text' => '47 Buah Apel', 'icon' => '🧺']
            ],
            'correct_answer' => '37',
            'hints' => [
                ['level' => 1, 'text' => 'Jumlahkan satuannya dulu: 3 + 4 = 7.'],
                ['level' => 2, 'text' => 'Jumlahkan puluhannya: 2 + 1 = 3.'],
                ['level' => 3, 'text' => 'Gabungkan puluhan dan satuan menjadi 37!']
            ],
            'reflection' => [
                'question' => 'Mengapa petani menunggu buah matang sebelum memetiknya dari pohon?',
                'options' => [
                    'Buah matang rasanya manis, berair, dan aman untuk pencernaan.',
                    'Supaya pohonnya tidak menangis.',
                    'Agar buah bisa dimakan ulat sampai habis.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'pesta-balon',
        'title' => 'Pembagian Balon Ulang Tahun',
        'subtitle' => 'Bagikan balon pesta secara adil dan merata kepada sahabat cilik!',
        'learning_objective' => 'Konsep pembagian dasar sebagai pembagian merata (sharing equally).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 15,
        'config' => [
            'scenario' => 'Ada 18 balon warna pelangi 🎈 yang akan dibagikan secara adil kepada 3 anak yang sedang berulang tahun.',
            'question' => 'Berapa banyak balon yang didapatkan oleh masing-masing anak? (18 ÷ 3 = ?)',
            'visual_hint' => '🎈 18 Balon dibagi rata ke 👦 👧 🧒 3 Anak = ?',
            'options' => [
                ['id' => '5', 'text' => '5 Balon per Anak', 'icon' => '🎈'],
                ['id' => '6', 'text' => '6 Balon per Anak', 'icon' => '🎈'],
                ['id' => '7', 'text' => '7 Balon per Anak', 'icon' => '🎈'],
                ['id' => '8', 'text' => '8 Balon per Anak', 'icon' => '🎉']
            ],
            'correct_answer' => '6',
            'hints' => [
                ['level' => 1, 'text' => 'Pikirkan perkalian 3: 3 dikalikan berapa yang hasilnya 18?'],
                ['level' => 2, 'text' => '3 × 6 = 18.'],
                ['level' => 3, 'text' => 'Setiap anak mendapatkan 6 buah balon!']
            ],
            'reflection' => [
                'question' => 'Mengapa balon yang ditiup bisa melayang jika diisi gas helium?',
                'options' => [
                    'Karena gas helium lebih ringan dibanding udara di sekitar kita.',
                    'Karena balon memiliki sayap ajaib.',
                    'Karena warna balon sangat terang.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'geometri-kastel',
        'title' => 'Bentuk Geometri Dinding Istana',
        'subtitle' => 'Identifikasi bangun datar penyusun jendela menara istana!',
        'learning_objective' => 'Mengenal ciri-ciri bangun datar (persegi, segitiga, lingkaran).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 16,
        'config' => [
            'scenario' => 'Jendela atap menara kastel memiliki 3 sisi lurus dan 3 sudut lancip 📐.',
            'question' => 'Apakah nama bangun datar geometri dari jendela atap menara kastel tersebut?',
            'visual_hint' => 'Memiliki 3 Sisi Lurus & 3 Titik Sudut',
            'options' => [
                ['id' => 'persegi', 'text' => 'Persegi (4 Sisi Sama)', 'icon' => '🟦'],
                ['id' => 'segitiga', 'text' => 'Segitiga (3 Sisi & 3 Sudut)', 'icon' => '🔺'],
                ['id' => 'lingkaran', 'text' => 'Lingkaran (Garis Lengkung)', 'icon' => '🔴'],
                ['id' => 'persegi_panjang', 'text' => 'Persegi Panjang', 'icon' => '🟨']
            ],
            'correct_answer' => 'segitiga',
            'hints' => [
                ['level' => 1, 'text' => 'Bentuk ini memiliki awalan kata "segi-" diikuti jumlah sisinya.'],
                ['level' => 2, 'text' => 'Karena sisinya ada 3, maka dinamakan segitiga.'],
                ['level' => 3, 'text' => 'Pilih Segitiga!']
            ],
            'reflection' => [
                'question' => 'Mengapa atap rumah di daerah beriklim hujan sering berbentuk segitiga miring?',
                'options' => [
                    'Agar air hujan dan daun gugur mudah meluncur turun dan tidak mengendap di atap.',
                    'Agar helikopter bisa mendarat di atap.',
                    'Supaya rumah tampak seperti kue ulang tahun.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'deret-bintang',
        'title' => 'Jalur Rasi Angka Berurutan',
        'subtitle' => 'Lengkapi pola bilangan loncat lima penunjuk gerbang emas!',
        'learning_objective' => 'Mengenal pola deret kelipatan 5 bertingkat.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 17,
        'config' => [
            'scenario' => 'Papan gerbang kota bertuliskan angka kelipatan lima: 5, 10, 15, 20, [ ? ], 30.',
            'question' => 'Angka berapakah yang tepat untuk mengisi tanda tanya di papan gerbang?',
            'visual_hint' => '5 -> 10 -> 15 -> 20 -> [ ? ] -> 30',
            'options' => [
                ['id' => '22', 'text' => 'Angka 22', 'icon' => '⭐'],
                ['id' => '25', 'text' => 'Angka 25 (Lompat 5)', 'icon' => '🌟'],
                ['id' => '28', 'text' => 'Angka 28', 'icon' => '⭐'],
                ['id' => '24', 'text' => 'Angka 24', 'icon' => '✨']
            ],
            'correct_answer' => '25',
            'hints' => [
                ['level' => 1, 'text' => 'Perhatikan pola: setiap langkah bertambah 5.'],
                ['level' => 2, 'text' => 'Setelah 20, tambahkan 5: 20 + 5 = ... ?'],
                ['level' => 3, 'text' => 'Jawabannya adalah 25!']
            ],
            'reflection' => [
                'question' => 'Berapa banyak jari di kedua tangan kita jika dihitung menggunakan kelipatan 5?',
                'options' => [
                    '5 jari tangan kiri + 5 jari tangan kanan = 10 jari seluruhnya.',
                    'Hanya ada 3 jari.',
                    'Ada 100 jari.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'panen-jagung',
        'title' => 'Panen Jagung Petani Rudi',
        'subtitle' => 'Pecahkan soal cerita panen jagung manis desa Number City!',
        'learning_objective' => 'Pemecahan masalah matematika kontekstual cerita kehidupan sehari-hari.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 18,
        'config' => [
            'scenario' => 'Petani Rudi memanen 35 tongkol jagung manis 🌽. Sebanyak 15 tongkol dijual ke pasar kota.',
            'question' => 'Berapa tongkol jagung manis yang masih tersimpan di lumbung petani Rudi? (35 - 15 = ?)',
            'visual_hint' => '🌽 35 Jagung Panen - 15 Dijual = ?',
            'options' => [
                ['id' => '15', 'text' => '15 Tongkol Jagung', 'icon' => '🌽'],
                ['id' => '20', 'text' => '20 Tongkol Jagung', 'icon' => '🌽'],
                ['id' => '25', 'text' => '25 Tongkol Jagung', 'icon' => '🌽'],
                ['id' => '50', 'text' => '50 Tongkol Jagung', 'icon' => '🌾']
            ],
            'correct_answer' => '20',
            'hints' => [
                ['level' => 1, 'text' => 'Kurangkan satuannya: 5 - 5 = 0.'],
                ['level' => 2, 'text' => 'Kurangkan puluhannya: 3 - 1 = 2.'],
                ['level' => 3, 'text' => 'Tersisa 20 tongkol jagung!']
            ],
            'reflection' => [
                'question' => 'Mengapa petani menyimpan sebagian hasil panen di lumbung?',
                'options' => [
                    'Sebagai cadangan makanan dan bibit untuk musim tanam berikutnya.',
                    'Supaya jagungnya berubah menjadi batu bara.',
                    'Agar tikus kebun bisa makan sepuasnya.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'labirin-angka',
        'title' => 'Labirin Rute Angka Kelipatan 10',
        'subtitle' => 'Temukan rute tercepat melintasi labirin hitung puluhan!',
        'learning_objective' => 'Menghitung deret kelipatan puluhan hingga 100.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 19,
        'config' => [
            'scenario' => 'Rute keluar labirin hanya terbuka bila melompati kelipatan 10: 10, 20, 30, 40, [ ? ], 60, 70.',
            'question' => 'Berapa angka kelipatan sepuluh yang harus dilewati robot setelah angka 40?',
            'visual_hint' => '10 -> 20 -> 30 -> 40 -> [ ? ] -> 60',
            'options' => [
                ['id' => '45', 'text' => 'Angka 45', 'icon' => '🌀'],
                ['id' => '50', 'text' => 'Angka 50 (Kelipatan 10)', 'icon' => '🧭'],
                ['id' => '55', 'text' => 'Angka 55', 'icon' => '🌀'],
                ['id' => '41', 'text' => 'Angka 41', 'icon' => '🚪']
            ],
            'correct_answer' => '50',
            'hints' => [
                ['level' => 1, 'text' => 'Pola bilangan ini bertambah 10 di setiap langkahnya.'],
                ['level' => 2, 'text' => '40 ditambah 10 sama dengan berapa ya?'],
                ['level' => 3, 'text' => '40 + 10 = 50!']
            ],
            'reflection' => [
                'question' => 'Uang kertas rupiah manakah yang memiliki nilai lima puluh ribu rupiah?',
                'options' => [
                    'Uang kertas berwarna biru dengan nominal Rp 50.000.',
                    'Uang kertas berwarna merah Rp 100.000.',
                    'Koin logam seratus rupiah.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'number-city',
        'slug' => 'rahasia-brankas',
        'title' => 'Kode Rahasia Brankas Harta Karun',
        'subtitle' => 'Pecahkan teka-teki logika angka pamungkas di puncak kota Number City!',
        'learning_objective' => 'Logika penalaran angka dan deduksi matematika bertingkat.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 20,
        'config' => [
            'scenario' => 'Petunjuk brankas emas: "Aku adalah bilangan dua angka. Angka puluhanku adalah 5. Angka satuanku adalah hasil dari 2 + 2."',
            'question' => 'Berapakah angka kode rahasia pembuka brankas harta karun Number City?',
            'visual_hint' => 'Puluhan = 5 | Satuan = (2 + 2 = 4) -> Kode = ?',
            'options' => [
                ['id' => '45', 'text' => 'Kode: 45', 'icon' => '🔒'],
                ['id' => '52', 'text' => 'Kode: 52', 'icon' => '🗝️'],
                ['id' => '54', 'text' => 'Kode: 54 (Harta Karun Terbuka!)', 'icon' => '👑'],
                ['id' => '56', 'text' => 'Kode: 56', 'icon' => '🔐']
            ],
            'correct_answer' => '54',
            'hints' => [
                ['level' => 1, 'text' => 'Cari angka satuannya dulu: 2 + 2 = 4.'],
                ['level' => 2, 'text' => 'Angka puluhan berada di depan yaitu 5, dan satuannya di belakang yaitu 4.'],
                ['level' => 3, 'text' => 'Gabungkan 5 dan 4 menjadi 54!']
            ],
            'reflection' => [
                'question' => 'Mengapa kata sandi atau kode rahasia brankas tidak boleh diberitahukan sembarangan ke orang asing?',
                'options' => [
                    'Untuk menjaga keamanan data dan barang berharga agar tidak disalahgunakan orang jahat.',
                    'Supaya kita bisa pamer kepada teman sekolah.',
                    'Agar kita lupa kata sandi kita sendiri.'
                ],
                'correct' => 0
            ]
        ]
    ],

    // =========================================================================
    // WORLD 2: DISCOVERY LAB (20 MISI SAINS, ALAM & EKSPERIMEN)
    // =========================================================================
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'tanaman-layu',
        'title' => 'Dokter Tanaman: Bunga Matahari',
        'subtitle' => 'Atur kadar air dan sinar matahari lab agar mekar ceria!',
        'learning_objective' => 'Memahami fotosintesis dan kebutuhan dasar tumbuhan untuk bertahan hidup.',
        'interaction_type' => 'simulation',
        'xp_reward' => 100,
        'sort_order' => 1,
        'config' => [
            'scenario' => 'Bunga matahari lab terkulai layu karena tanahnya kering dan tirai matahari tertutup rapat. Berikan nutrisi yang seimbang!',
            'question' => 'Atur kadar air (40-70%) dan intensitas sinar matahari (45-80%) agar bunga kembali segar dan mekar indah!',
            'target_water' => [40, 70],
            'target_sunlight' => [45, 80],
            'hints' => [
                ['level' => 1, 'text' => 'Tanaman butuh air untuk menyerap mineral tanah, tetapi tidak boleh terendam banjir.'],
                ['level' => 2, 'text' => 'Geser tuas air ke sekitar 50% dan buka tirai sinar matahari ke sekitar 60%.'],
                ['level' => 3, 'text' => 'Atur air di angka 55% dan cahaya di angka 65%, lalu periksa hasil!']
            ],
            'reflection' => [
                'question' => 'Mengapa tumbuhan hijau sangat penting bagi kehidupan manusia dan hewan di Bumi?',
                'options' => [
                    'Tumbuhan menghasilkan oksigen bersih melalui fotosintesis yang kita hirup setiap saat.',
                    'Tumbuhan membuat udara menjadi berwarna hijau.',
                    'Supaya kita tidak perlu makan makanan lain.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'misteri-bayangan',
        'title' => 'Misteri Teater Bayangan Kelinci',
        'subtitle' => 'Atur posisi senter agar bayangan pas di layar pentas teater!',
        'learning_objective' => 'Sifat perambatan cahaya dan hubungan jarak sumber cahaya terhadap ukuran bayangan.',
        'interaction_type' => 'simulation',
        'xp_reward' => 100,
        'sort_order' => 2,
        'config' => [
            'scenario' => 'Wayang kelinci di teater mini membutuhkan bayangan berukuran pas dengan garis bingkai panggung.',
            'question' => 'Geser jarak senter cahaya (35-50 cm) agar ukuran bayangan tepat mengisi garis pentas teater!',
            'target_distance' => [35, 50],
            'hints' => [
                ['level' => 1, 'text' => 'Jika sumber cahaya semakin dekat dengan benda, ukuran bayangan akan semakin membesar.'],
                ['level' => 2, 'text' => 'Jika cahaya dijauhkan, bayangan akan mengecil. Geser tuas senter ke area tengah hijau.'],
                ['level' => 3, 'text' => 'Posisikan senter di jarak sekitar 42 cm!']
            ],
            'reflection' => [
                'question' => 'Kapan bayangan tubuh kita di tanah tampak paling pendek saat berada di luar ruangan?',
                'options' => [
                    'Saat siang hari pukul 12.00 tepat ketika matahari berada tegak lurus di atas kepala.',
                    'Saat fajar matahari terbit di ufuk timur.',
                    'Saat malam hari tanpa lampu sama sekali.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'perjalanan-air',
        'title' => 'Petualangan Tetes Air di Awan',
        'subtitle' => 'Susun 3 tahapan siklus air alamiah di danau Discovery Lab!',
        'learning_objective' => 'Mengenal siklus air (evaporasi, kondensasi, dan presipitasi).',
        'interaction_type' => 'match_sort',
        'xp_reward' => 100,
        'sort_order' => 3,
        'config' => [
            'scenario' => 'Air di danau menguap karena panas matahari, membentuk awan dingin, lalu turun kembali sebagai tetesan hujan.',
            'question' => 'Urutkan tiga tahapan siklus air berikut secara benar!',
            'stages' => [
                ['id' => 'evaporasi', 'name' => '1. Penguapan (Air Danau Naik Menjadi Uap)', 'icon' => '☀️'],
                ['id' => 'kondensasi', 'name' => '2. Kondensasi (Uap Dingin Menggumpal Menjadi Awan)', 'icon' => '☁️'],
                ['id' => 'presipitasi', 'name' => '3. Presipitasi (Titik Air Turun Sebagai Hujan)', 'icon' => '🌧️']
            ],
            'correct_order' => ['evaporasi', 'kondensasi', 'presipitasi'],
            'correct_answer' => 'evaporasi,kondensasi,presipitasi',
            'hints' => [
                ['level' => 1, 'text' => 'Air dipanaskan matahari terlebih dahulu hingga naik ke udara (penguapan).'],
                ['level' => 2, 'text' => 'Di langit tinggi yang dingin, uap air berkumpul membentuk awan tebal.'],
                ['level' => 3, 'text' => 'Urutannya: Penguapan ➔ Pembentukan Awan ➔ Turun Hujan!']
            ],
            'reflection' => [
                'question' => 'Mengapa air di Bumi tidak pernah habis meskipun jutaan orang menggunakannya setiap hari?',
                'options' => [
                    'Karena air terus berputar dan diperbarui secara alami melalui siklus air.',
                    'Karena ada alien yang menuangkan air dari luar angkasa setiap malam.',
                    'Karena air diciptakan dari pasir gurun.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'panca-indera',
        'title' => 'Menara Petualang Panca Indera',
        'subtitle' => 'Pasangkan fungsi panca indera manusia dengan organ tubuh yang tepat!',
        'learning_objective' => 'Mengenal 5 panca indera manusia dan fungsi utamanya.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 4,
        'config' => [
            'scenario' => 'Miko mencium aroma wangi kue vanila dari dapur lab, lalu mendengarkan melodi kicauan burung di jendela.',
            'question' => 'Organ tubuh manakah yang berfungsi sebagai INDERA PENCIUMAN manusia?',
            'visual_hint' => 'Mencium wangi bunga 🌸 & aroma masakan lezat 🍲',
            'options' => [
                ['id' => 'mata', 'text' => 'Mata (Melihat)', 'icon' => '👁️'],
                ['id' => 'hidung', 'text' => 'Hidung (Mencium Aroma)', 'icon' => '👃'],
                ['id' => 'telinga', 'text' => 'Telinga (Mendengar)', 'icon' => '👂'],
                ['id' => 'lidah', 'text' => 'Lidah (Mengecap Rasa)', 'icon' => '👅']
            ],
            'correct_answer' => 'hidung',
            'hints' => [
                ['level' => 1, 'text' => 'Organ ini terletak di tengah wajah dan memiliki dua lubang napas.'],
                ['level' => 2, 'text' => 'Kita bernapas dan mendeteksi bau wangi maupun bau busuk lewat organ ini.'],
                ['level' => 3, 'text' => 'Pilih Hidung!']
            ],
            'reflection' => [
                'question' => 'Bagaimana cara menjaga kesehatan hidung dan pernapasan kita?',
                'options' => [
                    'Menghindari asap rokok, polusi debu, dan membersihkannya secara lembut.',
                    'Memasukkan benda kecil tajam ke dalam lubang hidung.',
                    'Menghirup asap pembakaran sampah dari jarak dekat.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'metamorfosis-kupu',
        'title' => 'Siklus Hidup Kupu-Kupu Sutra',
        'subtitle' => 'Pelajari proses metamorfosis sempurna dari telur hingga kupu-kupu bersayap elok!',
        'learning_objective' => 'Mengenal tahapan metamorfosis sempurna pada serangga.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 5,
        'config' => [
            'scenario' => 'Ulat hijau gemuk 🐛 memakan daun segar, lalu membungkus dirinya dalam kepompong sutra yang tenang.',
            'question' => 'Fase apakah yang terjadi SETELAH ulat membungkus dirinya dalam kepompong (pupa)?',
            'visual_hint' => '🥚 Telur -> 🐛 Ulat -> 🪺 Kepompong -> [ ? ]',
            'options' => [
                ['id' => 'katak', 'text' => 'Berubah Menjadi Katak', 'icon' => '🐸'],
                ['id' => 'kupu', 'text' => 'Kupu-Kupu Dewasa yang Cantik', 'icon' => '🦋'],
                ['id' => 'telur_lagi', 'text' => 'Kembali Langsung Jadi Telur', 'icon' => '🥚'],
                ['id' => 'belalang', 'text' => 'Berubah Menjadi Belalang', 'icon' => '🦗']
            ],
            'correct_answer' => 'kupu',
            'hints' => [
                ['level' => 1, 'text' => 'Di dalam kepompong terjadi perubahan menakjubkan membentuk sayap berwarna-warni.'],
                ['level' => 2, 'text' => 'Hewan ini bisa terbang dan hinggap di bunga menghisap nektar madu.'],
                ['level' => 3, 'text' => 'Pilih Kupu-Kupu Dewasa!']
            ],
            'reflection' => [
                'question' => 'Mengapa ulat harus banyak makan daun sebelum masuk ke fase kepompong?',
                'options' => [
                    'Mengumpulkan energi cadangan yang cukup selama beristirahat di dalam kepompong.',
                    'Supaya pohon daun menjadi gundul.',
                    'Supaya ulat bisa berubah menjadi batu.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'magnet-ajaib',
        'title' => 'Kekuatan Tarik Magnet Lab',
        'subtitle' => 'Eksperimen membedakan benda magnetis dan non-magnetis!',
        'learning_objective' => 'Mengenal sifat kemagnetan dan benda feromagnetik.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 6,
        'config' => [
            'scenario' => 'Miko memegang magnet tapal kuda merah 🧲 dan mendekatkannya ke meja penuh aneka perkakas.',
            'question' => 'Benda manakah yang DAPAT DITARIK kuat oleh magnet tapal kuda?',
            'visual_hint' => '🧲 Magnet menarik benda berbahan logam besi!',
            'options' => [
                ['id' => 'paku', 'text' => 'Paku Besi & Klip Kertas Logam', 'icon' => '🔩'],
                ['id' => 'kayu', 'text' => 'Sendok Kayu Makan', 'icon' => '🥄'],
                ['id' => 'plastik', 'text' => 'Penggaris Plastik Bening', 'icon' => '📏'],
                ['id' => 'kertas', 'text' => 'Buku Tulis Kertas', 'icon' => '📖']
            ],
            'correct_answer' => 'paku',
            'hints' => [
                ['level' => 1, 'text' => 'Magnet hanya menarik benda yang mengandung unsur logam tertentu seperti besi dan baja.'],
                ['level' => 2, 'text' => 'Kayu, plastik, dan kertas bukan bahan magnetis.'],
                ['level' => 3, 'text' => 'Pilih Paku Besi & Klip Kertas Logam!']
            ],
            'reflection' => [
                'question' => 'Apa yang terjadi jika dua kutub magnet yang senama (Utara dengan Utara) didekatkan?',
                'options' => [
                    'Kedua magnet akan saling tolak-menolak dan mendorong menjauh.',
                    'Kedua magnet akan langsung melekat sangat erat.',
                    'Kedua magnet akan meleleh menjadi air.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'wujud-benda',
        'title' => 'Es Mencair & Uap Air',
        'subtitle' => 'Amati perubahan wujud zat padat, cair, dan gas!',
        'learning_objective' => 'Mengenal perubahan wujud zat (mencair, membeku, menguap).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 7,
        'config' => [
            'scenario' => 'Balok es batu 🧊 diletakkan di bawah terik sinar mentari. Lama-kelamaan balok es berubah wujud menjadi air cair 💧.',
            'question' => 'Peristiwa perubahan wujud dari zat padat menjadi zat cair disebut dengan?',
            'visual_hint' => '🧊 Es Padat Dingin ➔ 💧 Air Cair Hangat',
            'options' => [
                ['id' => 'membeku', 'text' => 'Membeku (Air Jadi Es)', 'icon' => '❄️'],
                ['id' => 'mencair', 'text' => 'Mencair / Melebur (Es Jadi Air)', 'icon' => '💧'],
                ['id' => 'menguap', 'text' => 'Mengembun', 'icon' => '☁️'],
                ['id' => 'menyublim', 'text' => 'Mengendap', 'icon' => '🏜️']
            ],
            'correct_answer' => 'mencair',
            'hints' => [
                ['level' => 1, 'text' => 'Es batu menyerap kalor panas matahari sehingga mencair.'],
                ['level' => 2, 'text' => 'Seperti es krim yang meleleh bila tidak segera dimakan di tempat panas.'],
                ['level' => 3, 'text' => 'Pilih Mencair!']
            ],
            'reflection' => [
                'question' => 'Jika air cair dimasukkan ke dalam freezer kulkas, perubahan apa yang akan terjadi?',
                'options' => [
                    'Air akan membeku kembali menjadi balok es padat karena suhu sangat dingin.',
                    'Air akan meledak menjadi api.',
                    'Air akan berubah menjadi minyak goreng.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'rantai-makanan',
        'title' => 'Jaring Makanan Rimba Hutan',
        'subtitle' => 'Jelajahi hubungan makan dan dimakan antar makhluk hidup di alam!',
        'learning_objective' => 'Mengenal peran produsen, konsumen, dan rantai makanan ekosistem.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 8,
        'config' => [
            'scenario' => 'Di padang rumput: Rumput hijau 🌱 dimakan oleh Kelinci 🐇, lalu Kelinci dimakan oleh Rubah Rimba 🦊.',
            'question' => 'Dalam rantai makanan tersebut, siapakah yang berperan sebagai PRODUSEN (penghasil makanan sendiri)?',
            'visual_hint' => '🌱 Rumput Hijau ➔ 🐇 Kelinci ➔ 🦊 Rubah',
            'options' => [
                ['id' => 'rumput', 'text' => 'Rumput Hijau (Produsen)', 'icon' => '🌱'],
                ['id' => 'kelinci', 'text' => 'Kelinci (Konsumen 1)', 'icon' => '🐇'],
                ['id' => 'rubah', 'text' => 'Rubah (Konsumen 2)', 'icon' => '🦊'],
                ['id' => 'batu', 'text' => 'Batu Padang Rumput', 'icon' => '🪨']
            ],
            'correct_answer' => 'rumput',
            'hints' => [
                ['level' => 1, 'text' => 'Produsen adalah tumbuhan yang bisa membuat makanannya sendiri melalui sinar matahari.'],
                ['level' => 2, 'text' => 'Hewan tidak bisa membuat makanan sendiri, mereka adalah konsumen.'],
                ['level' => 3, 'text' => 'Pilih Rumput Hijau!']
            ],
            'reflection' => [
                'question' => 'Apa yang terjadi pada populasi hewan pemakan tumbuhan jika hutan ditebang habis?',
                'options' => [
                    'Hewan akan kekurangan sumber makanan dan ekosistem menjadi rusak.',
                    'Hewan akan semakin gemuk dan gembira.',
                    'Pohon-pohon baru akan tumbuh dalam satu detik.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'suara-getaran',
        'title' => 'Eksperimen Tabung Bunyi & Getaran',
        'subtitle' => 'Buktikan bahwa bunyi berasal dari benda yang bergetar!',
        'learning_objective' => 'Memahami bahwa sumber bunyi dihasilkan oleh getaran gelombang.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 9,
        'config' => [
            'scenario' => 'Saat senar gitar dipetik 🎸, jari kita bisa merasakan senar bergerak bolak-balik dengan cepat dan terdengar nada merdu.',
            'question' => 'Gerakan bolak-balik cepat pada senar yang menghasilkan bunyi tersebut disebut dengan?',
            'visual_hint' => '🎸 Senar Dipetik ➔ Bergerak Cepat ➔ Menghasilkan Nada Suara',
            'options' => [
                ['id' => 'getaran', 'text' => 'Getaran (Vibrasi Gelombang Bunyi)', 'icon' => '〰️'],
                ['id' => 'pantulan', 'text' => 'Cahaya Lampu', 'icon' => '💡'],
                ['id' => 'magnet', 'text' => 'Gaya Gravitasi', 'icon' => '🧲'],
                ['id' => 'beku', 'text' => 'Pembekuan Air', 'icon' => '🧊']
            ],
            'correct_answer' => 'getaran',
            'hints' => [
                ['level' => 1, 'text' => 'Semua benda yang menghasilkan suara berawal dari benda yang bergetar.'],
                ['level' => 2, 'text' => 'Saat kita berbicara dan memegang leher, pita suara kita juga terasa bergetar.'],
                ['level' => 3, 'text' => 'Pilih Getaran!']
            ],
            'reflection' => [
                'question' => 'Mengapa kita tidak boleh mendengarkan musik dengan earphone pada volume maksimal?',
                'options' => [
                    'Getaran suara yang terlalu keras dapat merusak sel saraf pendengaran di dalam telinga.',
                    'Agar baterai HP tidak cepat habis.',
                    'Supaya suara musik terdengar sampai ke rumah tetangga.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'bagian-tanaman',
        'title' => 'Anatomi Pohon Apel Ajaib',
        'subtitle' => 'Pelajari bagian-bagian tumbuhan dan tugas pentingnya bagi pohon!',
        'learning_objective' => 'Mengenal struktur tubuh tumbuhan (akar, batang, daun, bunga, buah).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 10,
        'config' => [
            'scenario' => 'Bagian pohon yang berada di dalam tanah bertugas menyerap air dan garam mineral agar pohon kokoh berdiri.',
            'question' => 'Apakah nama bagian tumbuhan yang berada di dalam tanah tersebut?',
            'visual_hint' => 'Menancap di dalam tanah & menyerap air nutrisi',
            'options' => [
                ['id' => 'akar', 'text' => 'Akar Tumbuhan', 'icon' => '🪵'],
                ['id' => 'daun', 'text' => 'Daun Hijau', 'icon' => '🍃'],
                ['id' => 'bunga', 'text' => 'Kelopak Bunga', 'icon' => '🌸'],
                ['id' => 'buah', 'text' => 'Buah Manis', 'icon' => '🍎']
            ],
            'correct_answer' => 'akar',
            'hints' => [
                ['level' => 1, 'text' => 'Bagian ini seperti kaki pohon yang menancap kuat mencengkeram tanah.'],
                ['level' => 2, 'text' => 'Akar menyerap air dari dalam bumi lalu membawanya naik ke batang.'],
                ['level' => 3, 'text' => 'Pilih Akar Tumbuhan!']
            ],
            'reflection' => [
                'question' => 'Apa manfaat akar pohon-pohon besar di lereng gunung bagi manusia?',
                'options' => [
                    'Akar mengikat butiran tanah sehingga mencegah terjadinya bencana tanah longsor saat hujan.',
                    'Membuat tanah lereng gunung menjadi licin.',
                    'Supaya kita bisa memetik apel tanpa tangga.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'hewan-herbivora',
        'title' => 'Menu Makanan Satwa Rimba',
        'subtitle' => 'Kelompokkan hewan berdasarkan jenis makanannya di suaka alam!',
        'learning_objective' => 'Klasifikasi hewan pemakan tumbuhan (herbivora) dan daging (karnivora).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 11,
        'config' => [
            'scenario' => 'Sapi 🐄, Kambing 🐐, dan Kelinci 🐇 sangat suka memakan rumput hijau, wortel, dan dedaunan segar.',
            'question' => 'Kelompok hewan pemakan tumbuhan disebut dengan istilah ilmiah?',
            'visual_hint' => '🐄 🐐 🐇 Makanan utamanya: Rumput & Tanaman Hijau',
            'options' => [
                ['id' => 'karnivora', 'text' => 'Karnivora (Pemakan Daging)', 'icon' => '🥩'],
                ['id' => 'herbivora', 'text' => 'Herbivora (Pemakan Tumbuhan)', 'icon' => '🌿'],
                ['id' => 'omnivora', 'text' => 'Omnivora (Pemakan Segala)', 'icon' => '🍲'],
                ['id' => 'insektivora', 'text' => 'Insektivora (Pemakan Serangga)', 'icon' => '🐜']
            ],
            'correct_answer' => 'herbivora',
            'hints' => [
                ['level' => 1, 'text' => 'Kata "Herba" berasal dari bahasa Latin yang artinya rumput atau tumbuhan hijau.'],
                ['level' => 2, 'text' => 'Hewan ini tidak memangsa daging hewan lain.'],
                ['level' => 3, 'text' => 'Pilih Herbivora!']
            ],
            'reflection' => [
                'question' => 'Contoh hewan karnivora yang berburu daging di alam liar adalah?',
                'options' => [
                    'Singa dan Harimau yang memiliki gigi taring tajam.',
                    'Kelinci dan Kuda poni.',
                    'Sapi perah dan Domba.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'pelangi-kaca',
        'title' => 'Pembiasan Cahaya Prisma Pelangi',
        'subtitle' => 'Urai cahaya putih matahari menjadi tujuh spektrum warna pelangi!',
        'learning_objective' => 'Mengenal sifat pembiasan dan dispersi cahaya (spektrum MeJiKuHiBiNiU).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 12,
        'config' => [
            'scenario' => 'Saat seberkas sinar matahari putih melewati prisma kaca 💎 atau tetes air hujan, cahaya terurai menjadi warna pelangi.',
            'question' => 'Urutan warna pelangi yang benar (disingkat Me-Ji-Ku-Hi-Bi-Ni-U) dimulai dari warna?',
            'visual_hint' => '🌈 Spektrum Warna: Me-Ji-Ku-Hi-Bi-Ni-U',
            'options' => [
                ['id' => 'merah', 'text' => 'Merah (Paling Atas / Panjang Gelombang Terpanjang)', 'icon' => '🔴'],
                ['id' => 'ungu', 'text' => 'Ungu', 'icon' => '🟣'],
                ['id' => 'kuning', 'text' => 'Kuning', 'icon' => '🟡'],
                ['id' => 'hijau', 'text' => 'Hijau', 'icon' => '🟢']
            ],
            'correct_answer' => 'merah',
            'hints' => [
                ['level' => 1, 'text' => 'Singkatan Me-Ji-Ku-Hi-Bi-Ni-U: suku kata pertama adalah "Me".'],
                ['level' => 2, 'text' => '"Me" adalah singkatan untuk warna Merah.'],
                ['level' => 3, 'text' => 'Pilih warna Merah!']
            ],
            'reflection' => [
                'question' => 'Mengapa pelangi sering muncul sesaat setelah hujan reda di siang hari?',
                'options' => [
                    'Sinar matahari mengenai tetesan butir air hujan di udara yang membiaskannya seperti prisma.',
                    'Karena awan mengecat langit dengan kuas warna.',
                    'Karena matahari berganti warna menjadi tujuh warna.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'udara-tekanan',
        'title' => 'Balon Terbang Udara Hangat',
        'subtitle' => 'Eksperimen membuktikan bahwa udara menempati ruang dan memiliki massa!',
        'learning_objective' => 'Memahami sifat udara dan prinsip pemuaian gas saat dipanaskan.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 13,
        'config' => [
            'scenario' => 'Balon udara raksasa 🎈 diisi udara yang dipanaskan dengan api kompor gas di bawah keranjang.',
            'question' => 'Mengapa balon udara yang dipanaskan dapat terangkat naik melayang tinggi ke angkasa?',
            'visual_hint' => 'Udara Hangat ➔ Lebih Ringan & Renggang ➔ Mengapung Naik',
            'options' => [
                ['id' => 'lebih_ringan', 'text' => 'Udara Panas Lebih Ringan (Massa Jenis Rendah) Dibanding Udara Dingin', 'icon' => '🎈'],
                ['id' => 'lebih_berat', 'text' => 'Udara Panas Menjadi Sangat Berat', 'icon' => '🪨'],
                ['id' => 'karena_angin', 'text' => 'Ditarik oleh Magnet Awan', 'icon' => '🧲'],
                ['id' => 'warna', 'text' => 'Karena Balon Berwarna Merah Cerah', 'icon' => '🎨']
            ],
            'correct_answer' => 'lebih_ringan',
            'hints' => [
                ['level' => 1, 'text' => 'Ketika gas dipanaskan, partikelnya memuai dan menjadi lebih renggang.'],
                ['level' => 2, 'text' => 'Udara yang lebih renggang memiliki massa jenis lebih kecil sehingga mengapung ke atas.'],
                ['level' => 3, 'text' => 'Pilih Udara Panas Lebih Ringan!']
            ],
            'reflection' => [
                'question' => 'Mengapa ventilasi jendela kamar rumah sebaiknya dipasang di bagian atas dinding?',
                'options' => [
                    'Udara hangat dan pengap di dalam ruangan akan naik ke atas dan keluar lewat ventilasi.',
                    'Supaya kucing tidak bisa melompat masuk.',
                    'Agar genteng rumah tidak terbang.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'lapisan-bumi',
        'title' => 'Jelajah Lapisan Tanah & Bumi',
        'subtitle' => 'Gali lapisan tanah kebun dan temukan humus penyubur tanaman!',
        'learning_objective' => 'Mengenal lapisan tanah dan unsur hara organik (humus).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 14,
        'config' => [
            'scenario' => 'Di lapisan tanah paling atas yang berwarna cokelat gelap kehitaman, terdapat sisa dedaunan lapuk yang sangat subur.',
            'question' => 'Apakah nama lapisan tanah subur yang kaya akan sisa tumbuhan lapuk tersebut?',
            'visual_hint' => 'Lapisan atas gelap kaya nutrisi daun lapuk',
            'options' => [
                ['id' => 'humus', 'text' => 'Tanah Humus (Sangat Subur)', 'icon' => '🌱'],
                ['id' => 'pasir', 'text' => 'Pasir Pantai yang Kering', 'icon' => '🏖️'],
                ['id' => 'batu', 'text' => 'Batu Karang Padat', 'icon' => '🪨'],
                ['id' => 'tanah_liat', 'text' => 'Lumpur Aspal', 'icon' => '🛣️']
            ],
            'correct_answer' => 'humus',
            'hints' => [
                ['level' => 1, 'text' => 'Lapisan ini paling disukai oleh cacing tanah dan akar tanaman sayuran.'],
                ['level' => 2, 'text' => 'Berasal dari pembusukan sisa-sisa makhluk hidup (bahan organik).'],
                ['level' => 3, 'text' => 'Pilih Tanah Humus!']
            ],
            'reflection' => [
                'question' => 'Mengapa cacing tanah dijuluki sebagai sahabat terbaik petani?',
                'options' => [
                    'Cacing membuat rongga sirkulasi udara di dalam tanah dan menguraikan sisa daun jadi pupuk alami.',
                    'Cacing memakan semua tanaman petani sampai habis.',
                    'Cacing bisa menyiram tanaman dengan air keran.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'adaptasi-hewan',
        'title' => 'Bunglon & Hewan Kamuflase',
        'subtitle' => 'Pelajari cara satwa liar beradaptasi melindungi diri dari pemangsa!',
        'learning_objective' => 'Mengenal bentuk adaptasi fisiologis dan tingkah laku satwa (kamuflase & mimikri).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 15,
        'config' => [
            'scenario' => 'Bunglon 🦎 dapat mengubah warna kulitnya menyerupai ranting cokelat atau daun hijau di tempat ia hinggap.',
            'question' => 'Kemampuan hewan mengubah warna kulit sesuai lingkungan untuk menyamarkan diri disebut?',
            'visual_hint' => '🦎 Berubah warna menyerupai lingkungan sekitar',
            'options' => [
                ['id' => 'kamuflase', 'text' => 'Kamuflase / Mimikri (Menyamar)', 'icon' => '🦎'],
                ['id' => 'hibernasi', 'text' => 'Hibernasi (Tidur Musim Dingin)', 'icon' => '🐻'],
                ['id' => 'migrasi', 'text' => 'Migrasi (Terbang Jauh)', 'icon' => '🦆'],
                ['id' => 'metamorfosis', 'text' => 'Metamorfosis', 'icon' => '🦋']
            ],
            'correct_answer' => 'kamuflase',
            'hints' => [
                ['level' => 1, 'text' => 'Tujuannya agar hewan tidak terlihat oleh musuh yang ingin memangsanya.'],
                ['level' => 2, 'text' => 'Berdandan atau menyamarkan diri agar menyatu dengan latar belakang.'],
                ['level' => 3, 'text' => 'Pilih Kamuflase / Mimikri!']
            ],
            'reflection' => [
                'question' => 'Mengapa beruang kutub di kutub utara memiliki bulu yang berwarna putih bersih?',
                'options' => [
                    'Agar menyatu dengan warna salju dan es saat berburu serta menahan dingin.',
                    'Supaya bulunya tidak kotor.',
                    'Karena beruang kutub suka makan es krim vanila.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'energi-angin',
        'title' => 'Kincir Angin Energi Bersih',
        'subtitle' => 'Manfaatkan hembusan angin ramah lingkungan untuk memutar generator listrik!',
        'learning_objective' => 'Mengenal energi terbarukan (angin, matahari, air).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 16,
        'config' => [
            'scenario' => 'Baling-baling kincir angin raksasa 🌬️ berputar kencang karena tertiup angin laut yang segar dan bebas polusi.',
            'question' => 'Energi gerak kincir angin diubah oleh generator listrik menjadi energi?',
            'visual_hint' => '🌬️ Energi Gerak Angin ➔ Generator ➔ Energi [ ? ]',
            'options' => [
                ['id' => 'listrik', 'text' => 'Energi Listrik Bersih', 'icon' => '⚡'],
                ['id' => 'nuklir', 'text' => 'Energi Asap Knalpot', 'icon' => '💨'],
                ['id' => 'batu_bara', 'text' => 'Energi Batu Bara', 'icon' => '⛏️'],
                ['id' => 'dingin', 'text' => 'Energi Es Beku', 'icon' => '❄️']
            ],
            'correct_answer' => 'listrik',
            'hints' => [
                ['level' => 1, 'text' => 'Energi ini digunakan untuk menyalakan lampu rumah, TV, dan mengisi daya baterai.'],
                ['level' => 2, 'text' => 'Listrik dari kincir angin sangat ramah lingkungan karena tidak menghasilkan asap kotor.'],
                ['level' => 3, 'text' => 'Pilih Energi Listrik Bersih!']
            ],
            'reflection' => [
                'question' => 'Mengapa energi angin dan sinar matahari disebut sebagai energi terbarukan?',
                'options' => [
                    'Karena ketersediaannya melimpah di alam dan tidak akan pernah habis terpakai.',
                    'Karena harganya harus dibeli dengan emas murni.',
                    'Karena hanya bisa digunakan saat malam hari saja.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'organ-tubuh',
        'title' => 'Denyut Jantung & Paru-Paru Petualang',
        'subtitle' => 'Pahami cara organ tubuh bekerja memompa darah dan oksigen segar!',
        'learning_objective' => 'Mengenal fungsi organ vital manusia (jantung dan paru-paru).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 17,
        'config' => [
            'scenario' => 'Setelah berlari cepat mengelilingi lapangan lab, dada kita terasa berdegup kencang: dug-dug-dug! ❤️',
            'question' => 'Organ tubuh yang bertugas memompa darah kaya oksigen ke seluruh bagian tubuh kita adalah?',
            'visual_hint' => 'Memompa darah berdegup tanpa henti siang dan malam',
            'options' => [
                ['id' => 'jantung', 'text' => 'Jantung (Pemompa Darah)', 'icon' => '❤️'],
                ['id' => 'lambung', 'text' => 'Lambung (Pencerna Makanan)', 'icon' => '🍲'],
                ['id' => 'tulang', 'text' => 'Tulang Kering', 'icon' => '🦴'],
                ['id' => 'rambut', 'text' => 'Rambut Kepala', 'icon' => '💇']
            ],
            'correct_answer' => 'jantung',
            'hints' => [
                ['level' => 1, 'text' => 'Ukurannya kira-kira sebesar kepalan tangan kita sendiri dan berada di rongga dada.'],
                ['level' => 2, 'text' => 'Jantung bekerja seperti pompa otomatis memompa darah ke otak, tangan, dan kaki.'],
                ['level' => 3, 'text' => 'Pilih Jantung!']
            ],
            'reflection' => [
                'question' => 'Aktivitas apa yang paling baik untuk menjaga agar jantung kita tetap sehat dan kuat?',
                'options' => [
                    'Rutin berolahraga (seperti bersepeda atau lari pagi) dan memakan makanan bergizi.',
                    'Tidur larut malam sambil bermain game terus-menerus.',
                    'Makan gorengan yang banyak minyaknya setiap hari.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'daur-ulang',
        'title' => 'Pilah Sampah Penjaga Lingkungan',
        'subtitle' => 'Pilah sampah ke tempat yang tepat untuk menyelamatkan Bumi kita!',
        'learning_objective' => 'Membedakan sampah organik (mudah terurai) dan anorganik (plastik/kaleng).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 18,
        'config' => [
            'scenario' => 'Di taman lab ada dua tong sampah: Hijau untuk Organik (alami) dan Kuning untuk Anorganik (daur ulang). Miko memegang kulit pisang 🍌.',
            'question' => 'Ke tong sampah manakah kulit pisang sisa bekal harus dimasukkan?',
            'visual_hint' => '🍌 Kulit Pisang: Sisa buah alami yang mudah terurai tanah',
            'options' => [
                ['id' => 'organik', 'text' => 'Tong Organik Hijau (Bisa Jadi Kompos Pupuk)', 'icon' => '🟢'],
                ['id' => 'anorganik', 'text' => 'Tong Anorganik Kuning (Plastik & Kaca)', 'icon' => '🟡'],
                ['id' => 'sungai', 'text' => 'Dilempar ke Aliran Sungai', 'icon' => '🌊'],
                ['id' => 'bakar', 'text' => 'Dibakar dengan Asap Pekat', 'icon' => '🔥']
            ],
            'correct_answer' => 'organik',
            'hints' => [
                ['level' => 1, 'text' => 'Kulit pisang berasal dari tumbuhan alami dan bisa membusuk di tanah.'],
                ['level' => 2, 'text' => 'Sampah alami yang bisa jadi pupuk masuk ke tempat sampah Organik.'],
                ['level' => 3, 'text' => 'Pilih Tong Organik Hijau!']
            ],
            'reflection' => [
                'question' => 'Mengapa membuang sampah plastik sembarangan ke sungai sangat berbahaya?',
                'options' => [
                    'Dapat menyumbat saluran air, memicu banjir, dan meracuni hewan ikan di air.',
                    'Karena plastik akan berubah menjadi emas.',
                    'Supaya sungai menjadi lebih berwarna-warni.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'hukum-terapung',
        'title' => 'Benda Mengapung & Tenggelam',
        'subtitle' => 'Uji massa jenis benda di kolam air Discovery Lab!',
        'learning_objective' => 'Konsep gaya apung dan massa jenis zat cair.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 19,
        'config' => [
            'scenario' => 'Saat dilemparkan ke kolam air: Balok gabus styrofoam mengapung di permukaan air, sedangkan batu kerikil padat 🪨 langsung tenggelam ke dasar.',
            'question' => 'Mengapa batu kerikil langsung tenggelam ke dasar kolam air?',
            'visual_hint' => 'Massa jenis batu LEBIH BESAR daripada massa jenis air',
            'options' => [
                ['id' => 'massa_jenis', 'text' => 'Batu Lebih Berat / Padat Massa Jenisnya Dibanding Air', 'icon' => '🪨'],
                ['id' => 'warna_batu', 'text' => 'Karena Batu Berwarna Abu-Abu', 'icon' => '🎨'],
                ['id' => 'takut_air', 'text' => 'Karena Batu Takut Basah', 'icon' => '💦'],
                ['id' => 'ditarik_ikan', 'text' => 'Ditarik oleh Ikan Kecil', 'icon' => '🐟']
            ],
            'correct_answer' => 'massa_jenis',
            'hints' => [
                ['level' => 1, 'text' => 'Benda yang tenggelam memiliki massa jenis lebih rapat dibanding zat cair sekitarnya.'],
                ['level' => 2, 'text' => 'Gabus mengapung karena berongga udara dan massa jenisnya lebih ringan dari air.'],
                ['level' => 3, 'text' => 'Pilih Batu Lebih Berat / Padat Massa Jenisnya!']
            ],
            'reflection' => [
                'question' => 'Mengapa kapal besi raksasa yang sangat berat di laut bisa tetap terapung megah?',
                'options' => [
                    'Bentuk lambung kapal dirancang berongga udara luas sehingga massa jenis rata-ratanya lebih ringan dari air laut.',
                    'Karena kapal besi diisi balon helium ribuan buah.',
                    'Karena air laut terbuat dari magnet.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'discovery-lab',
        'slug' => 'ekosistem-terumbu',
        'title' => 'Terumbu Karang Biru Samudra',
        'subtitle' => 'Puncak ekspedisi sains bawah laut Discovery Lab!',
        'learning_objective' => 'Pentingnya konservasi ekosistem laut dan terumbu karang bagi bumi.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 20,
        'config' => [
            'scenario' => 'Terumbu karang di bawah laut 🪸 adalah rumah perlindungan bagi ribuan jenis ikan badut, penyu, dan satwa laut yang elok.',
            'question' => 'Tindakan manakah yang BENAR dan membantu menjaga kelestarian terumbu karang laut kita?',
            'visual_hint' => '🪸 Rumah bagi jutaan kehidupan laut yang harus dijaga!',
            'options' => [
                ['id' => 'tidak_buang_sampah', 'text' => 'Tidak Membuang Sampah Plastik ke Laut & Menjaga Kebersihan Pantai', 'icon' => '🌊'],
                ['id' => 'injak_karang', 'text' => 'Menginjak dan Mematahkan Terumbu Karang Saat Berenang', 'icon' => '🚫'],
                ['id' => 'bom_ikan', 'text' => 'Menangkap Ikan Menggunakan Bahan Peledak Racun', 'icon' => '💣'],
                ['id' => 'ambil_karang', 'text' => 'Mengambil Karang Cantik untuk Dibawa Pulang Jadi Mainan', 'icon' => '🏖️']
            ],
            'correct_answer' => 'tidak_buang_sampah',
            'hints' => [
                ['level' => 1, 'text' => 'Terumbu karang adalah makhluk hidup yang tumbuh sangat lambat, hanya beberapa milimeter setahun.'],
                ['level' => 2, 'text' => 'Sampah plastik dapat menutupi dan mematikan karang laut.'],
                ['level' => 3, 'text' => 'Pilih Tidak Membuang Sampah Plastik & Menjaga Kebersihan Pantai!']
            ],
            'reflection' => [
                'question' => 'Apa gelar pahlawan cilik yang cocok bagi anak yang selalu menjaga kebersihan alam?',
                'options' => [
                    'Sahabat Alam & Penjaga Kelestarian Bumi Hebat.',
                    'Penebang Hutan Liar.',
                    'Pencemar Sungai.'
                ],
                'correct' => 0
            ]
        ]
    ],

    // =========================================================================
    // WORLD 3: THINKING LAB (20 MISI LOGIKA KOMPUTASIONAL & CODING)
    // =========================================================================
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'robot-pulang',
        'title' => 'Robot Botty Pulang ke Rumah',
        'subtitle' => 'Susun perintah kartu langkah agar Botty tiba di stasiun cas tanpa menabrak batu!',
        'learning_objective' => 'Melatih urutan instruksi dan eksekusi sekuensial (Sequence Algorithm).',
        'interaction_type' => 'sequence_logic',
        'xp_reward' => 100,
        'sort_order' => 1,
        'config' => [
            'scenario' => 'Botty berada di koordinat (0,0) menghadap ke timur. Di depannya ada batu di petak (1,0). Susun rute belok agar Botty selamat sampai stasiun cas!',
            'question' => 'Susun kartu aksi: Belok Kiri ➔ Maju ➔ Belok Kanan ➔ Maju ➔ Maju!',
            'grid_size' => [4, 4],
            'start' => [0, 0],
            'target' => [2, 1],
            'obstacles' => [[1, 0]],
            'correct_sequence' => ['turn_left', 'forward', 'turn_right', 'forward', 'forward'],
            'hints' => [
                ['level' => 1, 'text' => 'Jika Botty langsung maju, ia akan menabrak batu di depannya. Beloklah terlebih dahulu!'],
                ['level' => 2, 'text' => 'Belok kiri untuk naik satu petak, maju, lalu belok kanan menghadap stasiun cas.'],
                ['level' => 3, 'text' => 'Urutan: Belok Kiri ➔ Maju ➔ Belok Kanan ➔ Maju ➔ Maju!']
            ],
            'reflection' => [
                'question' => 'Mengapa komputer atau robot selalu menjalankan perintah persis urutan yang kita tulis?',
                'options' => [
                    'Karena komputer adalah mesin logika yang patuh pada algoritma teratur tanpa menebak.',
                    'Karena komputer punya perasaan suka marah.',
                    'Supaya kita tidak bisa mematikan komputer.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'jalan-rahasia',
        'title' => 'Sensor Pintu Jalan Rahasia',
        'subtitle' => 'Pilih rute aman dengan membaca rambu kondisi sensor cahaya!',
        'learning_objective' => 'Mengenal logika percabangan kondisional (IF / THEN / ELSE).',
        'interaction_type' => 'sequence_logic',
        'xp_reward' => 100,
        'sort_order' => 2,
        'config' => [
            'scenario' => 'Rambu sensor robot berbunyi: "JIKA (Lampu == Hijau) MAKA (Lewati Jalur A), JIKA TIDAK (Lewati Jalur B)". Saat ini lampu sensor menyala HIJAU!',
            'question' => 'Berdasarkan aturan percabangan logika di atas, jalur manakah yang WAJIB dipilih Botty?',
            'condition_lamp' => 'Hijau',
            'choices' => ['Jalur A (Aman)', 'Jalur B (Terkunci)'],
            'correct_path' => 'Jalur A (Aman)',
            'correct_answer' => 'Jalur A (Aman)',
            'hints' => [
                ['level' => 1, 'text' => 'Periksa kondisi lampu saat ini: menyala Hijau.'],
                ['level' => 2, 'text' => 'Aturannya: JIKA Hijau MAKA lewati Jalur A.'],
                ['level' => 3, 'text' => 'Pilih Jalur A (Aman)!']
            ],
            'reflection' => [
                'question' => 'Kapan kita menggunakan aturan JIKA-MAKA (IF-THEN) saat beraktivitas sehari-hari?',
                'options' => [
                    'JIKA di luar hujan, MAKA kita membawa payung agar tidak basah.',
                    'JIKA matahari terbit, MAKA kita menyalakan lampu tidur.',
                    'JIKA lapar, MAKA kita membuang piring.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'robot-mengulang',
        'title' => 'Robot Pintar Kartu Mengulang (Loop)',
        'subtitle' => 'Ringkas langkah menaiki anak tangga dengan kartu perulangan Loop!',
        'learning_objective' => 'Memahami konsep efisiensi algoritma dan perulangan (Looping).',
        'interaction_type' => 'sequence_logic',
        'xp_reward' => 100,
        'sort_order' => 3,
        'config' => [
            'scenario' => 'Botty harus menaiki 3 anak tangga. Setiap anak tangga polanya sama persis: [Lompat ➔ Maju]. Gunakan kartu Loop agar kodenya ringkas!',
            'question' => 'Atur angka kartu perulangan: Ulangi aksi [Lompat ➔ Maju] sebanyak berapa kali?',
            'step_pattern' => ['jump', 'forward'],
            'target_loops' => 3,
            'correct_answer' => '3',
            'hints' => [
                ['level' => 1, 'text' => 'Daripada menulis Lompat-Maju, Lompat-Maju, Lompat-Maju berulang-ulang, kita bisa membungkusnya dalam Loop.'],
                ['level' => 2, 'text' => 'Karena ada 3 anak tangga, maka putaran Loop-nya adalah 3 kali.'],
                ['level' => 3, 'text' => 'Set angka perulangan menjadi 3!']
            ],
            'reflection' => [
                'question' => 'Apa manfaat menggunakan Loop (perulangan) dalam membuat program komputer?',
                'options' => [
                    'Kode program jadi jauh lebih ringkas, mudah dibaca, dan tidak membuang waktu menulis perintah sama.',
                    'Membuat komputer bekerja sangat lambat.',
                    'Menghapus semua file di komputer.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'memilah-warna',
        'title' => 'Mesin Sortir Bola Warna',
        'subtitle' => 'Susun langkah algoritma pengurutan bola dari terkecil ke terbesar!',
        'learning_objective' => 'Mengenal konsep algoritma pengurutan data (Sorting Algorithm).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 4,
        'config' => [
            'scenario' => 'Empat bola bernomor acak: [ 40, 10, 30, 20 ] masuk ke sabuk konveyor mesin sortir.',
            'question' => 'Manakah urutan bola yang BENAR bila diurutkan secara menaik (dari angka terkecil ke terbesar)?',
            'visual_hint' => 'Urutkan dari angka terkecil: [ 40, 10, 30, 20 ]',
            'options' => [
                ['id' => 'opt_a', 'text' => '10 ➔ 20 ➔ 30 ➔ 40 (Urut Rapi)', 'icon' => '🟢'],
                ['id' => 'opt_b', 'text' => '40 ➔ 30 ➔ 20 ➔ 10 (Mundur)', 'icon' => '🔴'],
                ['id' => 'opt_c', 'text' => '10 ➔ 30 ➔ 20 ➔ 40', 'icon' => '🟡'],
                ['id' => 'opt_d', 'text' => '20 ➔ 10 ➔ 40 ➔ 30', 'icon' => '🔵']
            ],
            'correct_answer' => 'opt_a',
            'hints' => [
                ['level' => 1, 'text' => 'Cari angka paling kecil lebih dulu: 10.'],
                ['level' => 2, 'text' => 'Setelah 10 adalah 20, lalu 30, dan paling besar adalah 40.'],
                ['level' => 3, 'text' => 'Pilih 10 ➔ 20 ➔ 30 ➔ 40!']
            ],
            'reflection' => [
                'question' => 'Mengapa daftar nama siswa di buku absen sekolah selalu diurutkan dari huruf A sampai Z?',
                'options' => [
                    'Supaya guru bisa mencari nama siswa dengan cepat dan mudah.',
                    'Supaya siswa yang berawalan Z tidak boleh masuk kelas.',
                    'Agar buku absen cepat habis.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'dekomposisi-roti',
        'title' => 'Resep Robot Membuat Roti',
        'subtitle' => 'Pecah masalah besar menjadi langkah-langkah kecil yang logis!',
        'learning_objective' => 'Konsep berpikir komputasional: Dekomposisi Masalah (Decomposition).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 5,
        'config' => [
            'scenario' => 'Robot Chef ingin membuat roti panggang selai stroberi 🥪. Tugas besar ini harus dipecah menjadi 3 sub-langkah sederhana.',
            'question' => 'Manakah langkah awal PERTAMA yang harus dikerjakan robot chef sebelum memanggang?',
            'visual_hint' => 'Langkah 1: [ ? ] ➔ Langkah 2: Panggang Roti ➔ Langkah 3: Oleskan Selai',
            'options' => [
                ['id' => 'ambil_roti', 'text' => 'Ambil 2 Lembar Roti Tawar dari Bungkus', 'icon' => '🍞'],
                ['id' => 'makan_langsung', 'text' => 'Langsung Memakan Piringnya', 'icon' => '🍽️'],
                ['id' => 'cuci_piring', 'text' => 'Mencuci Wajan Bekas Memasak', 'icon' => '🧽'],
                ['id' => 'tidur', 'text' => 'Pergi Tidur Siang', 'icon' => '😴']
            ],
            'correct_answer' => 'ambil_roti',
            'hints' => [
                ['level' => 1, 'text' => 'Kita tidak bisa memanggang atau mengoles selai bila rotinya belum diambil.'],
                ['level' => 2, 'text' => 'Langkah paling awal adalah menyiapkan bahan utamanya: roti tawar.'],
                ['level' => 3, 'text' => 'Pilih Ambil 2 Lembar Roti Tawar!']
            ],
            'reflection' => [
                'question' => 'Bagaimana cara kita mengerjakan tugas sekolah yang terlihat sangat besar dan sulit?',
                'options' => [
                    'Memecahnya menjadi bagian-bagian kecil, lalu mengerjakannya satu per satu secara bertahap.',
                    'Menangis dan tidak mau mengerjakannya sama sekali.',
                    'Membuang buku tugas ke tempat sampah.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'debugging-kabel',
        'title' => 'Menemukan Bug Kabel Korslet',
        'subtitle' => 'Lacak kesalahan dalam alur kode program yang membuat lampu padam!',
        'learning_objective' => 'Konsep pelacakan kesalahan logika dan perbaikan program (Debugging).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 6,
        'config' => [
            'scenario' => 'Lampu taman padam! Perintah program berbunyi: [ Saklar = ON, Arus = 0 Ampere, Bohlam = Hidup ].',
            'question' => 'Di manakah letak "BUG" (kesalahan logika) yang membuat lampu tidak bisa menyala?',
            'visual_hint' => 'Lampu membutuhkan aliran arus listrik untuk bersinar!',
            'options' => [
                ['id' => 'arus_nol', 'text' => 'Arus = 0 Ampere (Tidak Ada Listrik yang Mengalir)', 'icon' => '⚠️'],
                ['id' => 'saklar_on', 'text' => 'Saklar = ON Sudah Benar', 'icon' => '✅'],
                ['id' => 'bohlam_hidup', 'text' => 'Warna Lampunya Putih', 'icon' => '💡'],
                ['id' => 'kabel', 'text' => 'Kabel Terlalu Bersih', 'icon' => '🔌']
            ],
            'correct_answer' => 'arus_nol',
            'hints' => [
                ['level' => 1, 'text' => 'Periksa variabel arus listrik: bila nilainya 0, artinya listrik terputus.'],
                ['level' => 2, 'text' => 'Lampu tidak mungkin menyala jika arus listrik bernilai 0 Ampere.'],
                ['level' => 3, 'text' => 'Bug-nya ada pada Arus = 0 Ampere! Ubah menjadi Arus Mengalir!']
            ],
            'reflection' => [
                'question' => 'Mengapa seorang programmer (pembuat kode) tidak boleh berkecil hati saat menemukan error/bug?',
                'options' => [
                    'Karena bug adalah kesempatan belajar memahami alur logika dengan lebih mendalam dan teliti.',
                    'Karena komputer akan meledak jika ada bug.',
                    'Supaya kita bisa menyalahkan orang lain.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'pola-karpet',
        'title' => 'Menenun Karpet Digital Berpola',
        'subtitle' => 'Temukan pola keteraturan desain simetris di ruang studio!',
        'learning_objective' => 'Pengenalan pola visual dan abstraksi (Pattern Recognition).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 7,
        'config' => [
            'scenario' => 'Karpet digital robot ditenun dengan pola berulang: [ Kotak, Lingkaran, Segitiga, Kotak, Lingkaran, [ ? ] ].',
            'question' => 'Bentuk apakah yang harus ditenun berikutnya untuk melanjutkan pola karpet digital?',
            'visual_hint' => '🔲 Kotak ➔ ⚪ Lingkaran ➔ 🔺 Segitiga ➔ 🔲 Kotak ➔ ⚪ Lingkaran ➔ [ ? ]',
            'options' => [
                ['id' => 'segitiga', 'text' => 'Segitiga 🔺 (Pola Berulang)', 'icon' => '🔺'],
                ['id' => 'bintang', 'text' => 'Bintang Emas ⭐', 'icon' => '⭐'],
                ['id' => 'kotak', 'text' => 'Kotak Lagi 🔲', 'icon' => '🔲'],
                ['id' => 'lingkaran', 'text' => 'Lingkaran ⚪', 'icon' => '⚪']
            ],
            'correct_answer' => 'segitiga',
            'hints' => [
                ['level' => 1, 'text' => 'Amati satu kelompok pola utuh: Kotak ➔ Lingkaran ➔ Segitiga (ada 3 bentuk).'],
                ['level' => 2, 'text' => 'Kelompok kedua sudah ada Kotak dan Lingkaran. Bentuk ketiga adalah ... ?'],
                ['level' => 3, 'text' => 'Pilih Segitiga 🔺!']
            ],
            'reflection' => [
                'question' => 'Contoh pola alamiah yang berulang setiap hari di sekitar kita adalah?',
                'options' => [
                    'Pergantian waktu siang hari terang dan malam hari gelap secara teratur.',
                    'Gempa bumi setiap menit.',
                    'Hujan uang dari awan.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'sinyal-biner',
        'title' => 'Lampu Morse Sinyal Biner 0 dan 1',
        'subtitle' => 'Pelajari bahasa rahasia komputer menggunakan angka biner!',
        'learning_objective' => 'Mengenal sistem bilangan biner (0 = Mati / False, 1 = Nyala / True).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 8,
        'config' => [
            'scenario' => 'Komputer menyimpan pesan dalam kode biner: Angka 1 artinya Lampu NYALA 💡, dan angka 0 artinya Lampu MATI ⚫.',
            'question' => 'Jika ada kode biner [ 1, 0, 1 ], bagaimanakah keadaan ketiga lampu tersebut?',
            'visual_hint' => 'Kode Biner: [ 1, 0, 1 ] ➔ (1 = Nyala, 0 = Mati)',
            'options' => [
                ['id' => 'nyala_mati_nyala', 'text' => 'Nyala 💡, Mati ⚫, Nyala 💡', 'icon' => '✨'],
                ['id' => 'semua_mati', 'text' => 'Semua Lampu Mati ⚫⚫⚫', 'icon' => '⚫'],
                ['id' => 'semua_nyala', 'text' => 'Semua Lampu Nyala 💡💡💡', 'icon' => '💡'],
                ['id' => 'mati_nyala_mati', 'text' => 'Mati ⚫, Nyala 💡, Mati ⚫', 'icon' => '🔅']
            ],
            'correct_answer' => 'nyala_mati_nyala',
            'hints' => [
                ['level' => 1, 'text' => 'Angka pertama adalah 1: berarti lampu pertama Nyala.'],
                ['level' => 2, 'text' => 'Angka kedua adalah 0: berarti lampu kedua Mati.'],
                ['level' => 3, 'text' => 'Angka ketiga adalah 1: berarti lampu ketiga Nyala!']
            ],
            'reflection' => [
                'question' => 'Mengapa komputer menggunakan angka biner 0 dan 1 di dalam prosesornya?',
                'options' => [
                    'Karena transistor listrik di komputer sangat mudah dan cepat membaca status on (1) atau off (0).',
                    'Karena komputer tidak suka angka 2 sampai 9.',
                    'Supaya keyboard komputer hanya memiliki dua tombol saja.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'antrian-kasir',
        'title' => 'Antrean Pertama Masuk Pertama Keluar',
        'subtitle' => 'Pelajari struktur data Antrean (Queue / FIFO) di loket tiket!',
        'learning_objective' => 'Mengenal konsep struktur data Queue (First In, First Out).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 9,
        'config' => [
            'scenario' => 'Di loket tiket: Kian datang pertama 👦, lalu Nara datang kedua 👧, lalu Bayu datang ketiga 🧒.',
            'question' => 'Siapakah yang akan DILAYANI PERTAMA KALI oleh petugas loket tiket (Prinsip FIFO)?',
            'visual_hint' => 'Urutan Datang: Kian (1) ➔ Nara (2) ➔ Bayu (3)',
            'options' => [
                ['id' => 'kian', 'text' => 'Kian (Datang Pertama Dilayani Pertama)', 'icon' => '👦'],
                ['id' => 'bayu', 'text' => 'Bayu (Datang Terakhir)', 'icon' => '🧒'],
                ['id' => 'nara', 'text' => 'Nara (Di Tengah)', 'icon' => '👧'],
                ['id' => 'semua', 'text' => 'Semua Dilayani Bersamaan', 'icon' => '👥']
            ],
            'correct_answer' => 'kian',
            'hints' => [
                ['level' => 1, 'text' => 'Prinsip antrean di loket adalah "First In, First Out" (yang datang duluan, selesai duluan).'],
                ['level' => 2, 'text' => 'Kian adalah anak yang pertama kali berbaris di loket.'],
                ['level' => 3, 'text' => 'Pilih Kian!']
            ],
            'reflection' => [
                'question' => 'Mengapa menyerobot antrean adalah perbuatan yang tidak terpuji?',
                'options' => [
                    'Karena melanggar keadilan dan mengambil hak orang lain yang sudah menunggu lebih awal.',
                    'Karena loket tiket akan langsung tutup.',
                    'Supaya kita bisa pulang lebih lambat.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'tumpukan-buku',
        'title' => 'Tumpukan Buku Perpustakaan Robot',
        'subtitle' => 'Pelajari struktur data Tumpukan (Stack / LIFO) di rak buku!',
        'learning_objective' => 'Mengenal konsep struktur data Stack (Last In, First Out).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 10,
        'config' => [
            'scenario' => 'Miko menumpuk 3 buku di atas meja: Pertama meletakkan Buku Merah 📕, di atasnya Buku Biru 📘, dan paling atas Buku Hijau 📗.',
            'question' => 'Buku manakah yang harus DIANGKAT PERTAMA KALI agar tumpukan tidak berantakan (Prinsip LIFO)?',
            'visual_hint' => 'Tumpukan: 📗 Hijau (Paling Atas) | 📘 Biru (Tengah) | 📕 Merah (Paling Bawah)',
            'options' => [
                ['id' => 'hijau', 'text' => 'Buku Hijau (Paling Atas Diambil Pertama)', 'icon' => '📗'],
                ['id' => 'merah', 'text' => 'Buku Merah (Paling Bawah Ditarik Paksa)', 'icon' => '📕'],
                ['id' => 'biru', 'text' => 'Buku Biru', 'icon' => '📘'],
                ['id' => 'meja', 'text' => 'Meja Perpustakaan', 'icon' => '🪑']
            ],
            'correct_answer' => 'hijau',
            'hints' => [
                ['level' => 1, 'text' => 'Dalam konsep Stack (tumpukan), barang yang terakhir ditaruh di puncak adalah yang pertama diambil.'],
                ['level' => 2, 'text' => 'Buku Hijau ditaruh paling akhir di posisi paling atas.'],
                ['level' => 3, 'text' => 'Ambil Buku Hijau terlebih dahulu!']
            ],
            'reflection' => [
                'question' => 'Contoh tumpukan benda di rumah yang menggunakan prinsip Stack (LIFO) adalah?',
                'options' => [
                    'Tumpukan piring makan di rak cuci piring (ambil yang paling atas dulu).',
                    'Air keran yang mengalir ke bak mandi.',
                    'Roda sepeda yang berputar.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'logika-lampu',
        'title' => 'Saklar Gerbang Logika DAN & ATAU',
        'subtitle' => 'Hubungkan gerbang logika AND agar lampu laser lab menyala!',
        'learning_objective' => 'Memahami operasi logika Boolean (Operator AND / Logika DAN).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 11,
        'config' => [
            'scenario' => 'Lampu laser menggunakan gerbang logika DAN (AND). Syaratnya: Saklar A DAN Saklar B KEDUANYA harus menyala (ON).',
            'question' => 'Kondisi manakah yang akan membuat lampu laser MENYALA?',
            'visual_hint' => 'Aturan AND: Saklar A (ON) DAN Saklar B (ON) ➔ Laser Nyala!',
            'options' => [
                ['id' => 'on_on', 'text' => 'Saklar A = ON dan Saklar B = ON (Keduanya Menyala)', 'icon' => '💡'],
                ['id' => 'on_off', 'text' => 'Saklar A = ON dan Saklar B = OFF', 'icon' => '⚫'],
                ['id' => 'off_on', 'text' => 'Saklar A = OFF dan Saklar B = ON', 'icon' => '⚫'],
                ['id' => 'off_off', 'text' => 'Keduanya Mati (OFF)', 'icon' => '⚫']
            ],
            'correct_answer' => 'on_on',
            'hints' => [
                ['level' => 1, 'text' => 'Kata "DAN" berarti semua syaratnya harus terpenuhi bersamaan.'],
                ['level' => 2, 'text' => 'Jika salah satu saklar mati, arus listrik tidak akan tersambung.'],
                ['level' => 3, 'text' => 'Pilih Keduanya ON!']
            ],
            'reflection' => [
                'question' => 'Mengapa brankas roket luar angkasa sering membutuhkan dua kunci yang diputar bersamaan?',
                'options' => [
                    'Memastikan dua astronot sepakat demi keselamatan ganda tingkat tinggi.',
                    'Supaya kuncinya tidak hilang di saku.',
                    'Agar roket bisa terbang lebih cepat.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'pencarian-harta',
        'title' => 'Algoritma Cari Barang Cepat',
        'subtitle' => 'Temukan nomor kotak harta karun dengan teknik pencarian bagi dua!',
        'learning_objective' => 'Mengenal konsep Binary Search (Pencarian Bagi Dua).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 12,
        'config' => [
            'scenario' => 'Ada 100 loker berurutan (nomor 1 sampai 100). Petunjuk brankas: "Kunciku berada di nomor lebih besar dari 50".',
            'question' => 'Dengan membagi dua area pencarian, kelompok loker manakah yang BISA DIABAIKAN (tidak perlu dicari)?',
            'visual_hint' => 'Kunci > 50 ➔ Area 1-50 tidak mungkin berisi kunci!',
            'options' => [
                ['id' => 'abaikan_1_50', 'text' => 'Abaikan Loker Nomor 1 sampai 50 (Fokus ke 51-100)', 'icon' => '🎯'],
                ['id' => 'abaikan_51_100', 'text' => 'Abaikan Loker Nomor 51 sampai 100', 'icon' => '❌'],
                ['id' => 'buka_satu_satu', 'text' => 'Buka Semua 100 Loker Satu per Satu dari Nomor 1', 'icon' => '⏳'],
                ['id' => 'tinggalkan', 'text' => 'Tinggalkan Kunci di Tanah', 'icon' => '🗝️']
            ],
            'correct_answer' => 'abaikan_1_50',
            'hints' => [
                ['level' => 1, 'text' => 'Karena kuncinya lebih besar dari 50, maka angka 1 sampai 50 pasti salah.'],
                ['level' => 2, 'text' => 'Dengan mengabaikan separuh area, pencarian kita menjadi 2 kali lebih cepat.'],
                ['level' => 3, 'text' => 'Abaikan loker nomor 1 sampai 50!']
            ],
            'reflection' => [
                'question' => 'Bagaimana cara cepat mencari arti sebuah kata di dalam kamus buku tebal?',
                'options' => [
                    'Membuka kamus di bagian tengah sesuai huruf abjad kata tersebut, bukan membaca dari halaman 1.',
                    'Membaca kata demi kata dari lembar pertama sampai habis.',
                    'Menebak arti kata tanpa membuka kamus.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'jalur-tercepat',
        'title' => 'Navigasi Truk Kurir Jalur Terpendek',
        'subtitle' => 'Temukan rute tercepat pengiriman paket robot cerdas!',
        'learning_objective' => 'Mengenal konsep optimasi rute terpendek (Shortest Path Algorithm).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 13,
        'config' => [
            'scenario' => 'Truk kurir ingin mengantar paket: Jalur Merah jaraknya 5 km, Jalur Biru jaraknya 8 km, dan Jalur Kuning jaraknya 12 km.',
            'question' => 'Jalur manakah yang merupakan JALUR TERPENDEK agar paket tiba paling cepat?',
            'visual_hint' => '🔴 Jalur Merah (5 km) | 🔵 Jalur Biru (8 km) | 🟡 Jalur Kuning (12 km)',
            'options' => [
                ['id' => 'merah', 'text' => 'Jalur Merah (5 km - Tercepat & Terpendek)', 'icon' => '🚚'],
                ['id' => 'biru', 'text' => 'Jalur Biru (8 km)', 'icon' => '🛣️'],
                ['id' => 'kuning', 'text' => 'Jalur Kuning (12 km)', 'icon' => '🚛'],
                ['id' => 'putar', 'text' => 'Memutar Seluruh Kota (25 km)', 'icon' => '🔄']
            ],
            'correct_answer' => 'merah',
            'hints' => [
                ['level' => 1, 'text' => 'Bandingkan angka jaraknya: 5 km adalah angka paling kecil.'],
                ['level' => 2, 'text' => 'Jarak tempuh paling pendek menghemat waktu dan bahan bakar.'],
                ['level' => 3, 'text' => 'Pilih Jalur Merah (5 km)!']
            ],
            'reflection' => [
                'question' => 'Aplikasi peta digital di ponsel pintar (seperti GPS) menggunakan algoritma rute terpendek untuk?',
                'options' => [
                    'Memberi petunjuk jalan paling efisien dan menghindari kemacetan parah di jalan.',
                    'Membuat pengendara tersesat di hutan.',
                    'Menghabiskan bensin kendaraan.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'kondisi-cuaca',
        'title' => 'Robot Petani Sensor Hujan',
        'subtitle' => 'Tulis aturan logika sensor pintar untuk penyiraman kebun lab!',
        'learning_objective' => 'Mengenal logika percabangan bercabang (Nested IF-ELSE).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 14,
        'config' => [
            'scenario' => 'Aturan robot penyiram: "JIKA (Sedang Hujan) MAKA (Matikan Keran), JIKA TIDAK (Nyalakan Keran)". Cuaca sore ini sedang HUJAN LEBAT 🌧️.',
            'question' => 'Apakah tindakan yang harus diambil oleh robot petani cerdas?',
            'visual_hint' => 'Cuaca = Hujan Lebat ➔ Aturan: JIKA Hujan MAKA [ ? ]',
            'options' => [
                ['id' => 'matikan', 'text' => 'Matikan Keran Air (Hemat Air Karena Sudah Hujan)', 'icon' => '🛑'],
                ['id' => 'nyalakan', 'text' => 'Nyalakan Keran Sekuat Tenaga', 'icon' => '🚰'],
                ['id' => 'rusak', 'text' => 'Bongkar Pipa Air', 'icon' => '🔧'],
                ['id' => 'tidur', 'text' => 'Buang Sensor Cuaca', 'icon' => '🗑️']
            ],
            'correct_answer' => 'matikan',
            'hints' => [
                ['level' => 1, 'text' => 'Tanaman sudah mendapat siraman air melimpah dari hujan lebat.'],
                ['level' => 2, 'text' => 'Menyiram tanaman saat hujan lebat adalah pemborosan air dan membuat akar membusuk.'],
                ['level' => 3, 'text' => 'Pilih Matikan Keran Air!']
            ],
            'reflection' => [
                'question' => 'Mengapa sistem otomatis hemat energi sangat bermanfaat bagi bumi kita?',
                'options' => [
                    'Menghemat sumber daya air dan listrik secara pintar tanpa ada yang terbuang sia-sia.',
                    'Supaya kita tidak bisa menggunakan air lagi.',
                    'Agar tanaman tidak mau tumbuh.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'enkripsi-pesan',
        'title' => 'Sandi Rahasia Geser Huruf Caesar',
        'subtitle' => 'Pecahkan kode enkripsi rahasia mata-mata Thinking Lab!',
        'learning_objective' => 'Mengenal konsep dasar enkripsi data dan kriptografi pergeseran.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 15,
        'config' => [
            'scenario' => 'Sandi rahasia bergeser 1 huruf maju: Huruf A ➔ B, Huruf B ➔ C, Huruf C ➔ D.',
            'question' => 'Bila kata sandi aslinya adalah "A - B", menjadi apakah pesan rahasia setelah dienkripsi?',
            'visual_hint' => 'Geser 1 Huruf Maju: A ➔ [ ? ], B ➔ [ ? ]',
            'options' => [
                ['id' => 'bc', 'text' => 'B - C (Pesan Terenkripsi)', 'icon' => '🔐'],
                ['id' => 'za', 'text' => 'Z - A', 'icon' => '📜'],
                ['id' => 'cd', 'text' => 'C - D', 'icon' => '🗝️'],
                ['id' => 'ab', 'text' => 'A - B Tetap Sama', 'icon' => '📄']
            ],
            'correct_answer' => 'bc',
            'hints' => [
                ['level' => 1, 'text' => 'Huruf setelah A adalah B.'],
                ['level' => 2, 'text' => 'Huruf setelah B adalah C.'],
                ['level' => 3, 'text' => 'Maka A - B berubah menjadi B - C!']
            ],
            'reflection' => [
                'question' => 'Mengapa aplikasi pesan instan (seperti WhatsApp) menggunakan enkripsi data?',
                'options' => [
                    'Agar isi pesan pribadi kita aman dan tidak bisa diintip oleh peretas di internet.',
                    'Supaya pesan kita terkirim ke semua orang di dunia.',
                    'Agar huruf pesan berubah menjadi angka acak yang tidak bisa dibaca.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'fungsi-ajaib',
        'title' => 'Kotak Ajaib Masukan & Keluaran',
        'subtitle' => 'Pelajari cara kerja Fungsi (Function) dalam matematika dan pemrograman!',
        'learning_objective' => 'Memahami konsep fungsi: Input ➔ Proses (+5) ➔ Output.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 16,
        'config' => [
            'scenario' => 'Kotak fungsi memiliki aturan: Setiap angka yang dimasukkan akan DITAMBAH 5 (Output = Input + 5).',
            'question' => 'Jika kita memasukkan angka 10 ke dalam kotak fungsi, berapakah angka yang keluar?',
            'visual_hint' => 'Input: 10 ➔ Kotak Proses (+ 5) ➔ Output = ?',
            'options' => [
                ['id' => '12', 'text' => 'Angka 12', 'icon' => '📦'],
                ['id' => '15', 'text' => 'Angka 15 (10 + 5 = 15)', 'icon' => '✨'],
                ['id' => '20', 'text' => 'Angka 20', 'icon' => '🎁'],
                ['id' => '50', 'text' => 'Angka 50', 'icon' => '🧮']
            ],
            'correct_answer' => '15',
            'hints' => [
                ['level' => 1, 'text' => 'Fungsi menambahkan angka 5 ke angka masukan.'],
                ['level' => 2, 'text' => 'Hitung: 10 + 5.'],
                ['level' => 3, 'text' => '10 + 5 = 15!']
            ],
            'reflection' => [
                'question' => 'Apa keuntungan membuat fungsi (function) dalam bahasa pemrograman?',
                'options' => [
                    'Kita bisa menggunakan rumus yang sama berulang kali tanpa harus menulis ulang rumusnya.',
                    'Fungsi membuat komputer bekerja lebih lama.',
                    'Agar komputer bingung menghitung angka.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'variabel-skor',
        'title' => 'Papan Skor Kotak Nilai Berubah',
        'subtitle' => 'Pahami cara Variabel menyimpan dan memperbarui nilai skor permainan!',
        'learning_objective' => 'Mengenal konsep Variabel sebagai wadah penyimpan data yang bisa berubah.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 17,
        'config' => [
            'scenario' => 'Variabel Skor awal = 100 poin. Kian berhasil menyelesaikan tantangan bintang dan mendapatkan bonus +50 poin.',
            'question' => 'Berapakah nilai variabel Skor sekarang? (Skor = 100 + 50)',
            'visual_hint' => 'Variabel Skor: 100 ➔ Ditambah 50 ➔ Skor Sekarang = ?',
            'options' => [
                ['id' => '120', 'text' => '120 Poin', 'icon' => '⭐'],
                ['id' => '150', 'text' => '150 Poin (Nilai Variabel Baru)', 'icon' => '🏆'],
                ['id' => '200', 'text' => '200 Poin', 'icon' => '🥇'],
                ['id' => '100', 'text' => '100 Poin Tetap', 'icon' => '📊']
            ],
            'correct_answer' => '150',
            'hints' => [
                ['level' => 1, 'text' => 'Variabel adalah kotak bernama yang nilainya bisa bertambah atau berkurang.'],
                ['level' => 2, 'text' => '100 ditambah 50 sama dengan 150.'],
                ['level' => 3, 'text' => 'Pilih 150 Poin!']
            ],
            'reflection' => [
                'question' => 'Contoh variabel dalam kehidupan nyata yang nilainya selalu bertambah setiap tahun adalah?',
                'options' => [
                    'Usia umur kita yang bertambah satu tahun setiap ulang tahun.',
                    'Nomor sepatu yang tidak pernah berubah.',
                    'Warna langit di siang hari.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'perulangan-bersyarat',
        'title' => 'Robot Bersih-Bersih Selama Kotor',
        'subtitle' => 'Kuasai perulangan bersyarat (WHILE Loop) pada robot vacuum!',
        'learning_objective' => 'Mengenal konsep perulangan dengan syarat kondisi (WHILE Loop).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 18,
        'config' => [
            'scenario' => 'Aturan robot vacuum: "SELAMA (Lantai Masih Ada Debu == True) MAKA (Terus Menyapu)". Sekarang seluruh lantai sudah bersih berkilau!',
            'question' => 'Kapan robot vacuum pembersih lantai HARUS BERHENTI menyapu?',
            'visual_hint' => 'WHILE (Ada Debu == True) { Sapu() } ➔ Saat Debu Habis: [ ? ]',
            'options' => [
                ['id' => 'berhenti', 'text' => 'Berhenti Menyapu Saat Semua Debu Sudah Bersih', 'icon' => '🛑'],
                ['id' => 'terus_menyapu', 'text' => 'Terus Menyapu Selamanya Sampai Baterai Meledak', 'icon' => '⚠️'],
                ['id' => 'buang_air', 'text' => 'Menyiram Air Panas ke Lantai', 'icon' => '🌊'],
                ['id' => 'rusak', 'text' => 'Menabrak Dinding Berkali-Kali', 'icon' => '💥']
            ],
            'correct_answer' => 'berhenti',
            'hints' => [
                ['level' => 1, 'text' => 'Perulangan WHILE hanya berjalan selama kondisinya masih terpenuhi (masih ada debu).'],
                ['level' => 2, 'text' => 'Begitu debu sudah habis, syarat perulangan selesai dan robot harus berhenti.'],
                ['level' => 3, 'text' => 'Pilih Berhenti Menyapu!']
            ],
            'reflection' => [
                'question' => 'Apa bahayanya jika sebuah program komputer mengalami "Infinite Loop" (perulangan tanpa henti)?',
                'options' => [
                    'Komputer bisa menjadi macet (hang) karena memorinya terus terkuras tanpa henti.',
                    'Layar komputer akan berubah menjadi warna pelangi.',
                    'Komputer akan mengeluarkan kue donat.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'koordinat-labirin',
        'title' => 'Peta Kotak Petak X dan Y',
        'subtitle' => 'Navigasi sistem koordinat kartesius 2D di grid Thinking Lab!',
        'learning_objective' => 'Mengenal sistem koordinat sumbu X (horizontal) dan sumbu Y (vertikal).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 19,
        'config' => [
            'scenario' => 'Titik mula adalah (0,0). Botty melangkah 3 petak ke KANAN (sumbu X) dan 2 petak ke ATAS (sumbu Y).',
            'question' => 'Di koordinat (X, Y) manakah posisi Botty sekarang berada?',
            'visual_hint' => 'Sumbu X (Kanan) = 3 | Sumbu Y (Atas) = 2 ➔ Koordinat (X, Y) = ?',
            'options' => [
                ['id' => '3_2', 'text' => 'Koordinat (3, 2)', 'icon' => '📍'],
                ['id' => '2_3', 'text' => 'Koordinat (2, 3)', 'icon' => '📌'],
                ['id' => '5_5', 'text' => 'Koordinat (5, 5)', 'icon' => '🗺️'],
                ['id' => '0_5', 'text' => 'Koordinat (0, 5)', 'icon' => '🎯']
            ],
            'correct_answer' => '3_2',
            'hints' => [
                ['level' => 1, 'text' => 'Penulisan koordinat selalu mendahulukan sumbu X (horizontal) lalu sumbu Y (vertikal).'],
                ['level' => 2, 'text' => 'X bergerak ke kanan 3, Y bergerak ke atas 2.'],
                ['level' => 3, 'text' => 'Pilih Koordinat (3, 2)!']
            ],
            'reflection' => [
                'question' => 'Game petualangan komputer menggunakan koordinat X dan Y untuk?',
                'options' => [
                    'Menentukan posisi karakter pemain dan musuh secara presisi di layar layar kaca.',
                    'Menghitung jumlah suara musik di game.',
                    'Menghapus game dari komputer.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'thinking-lab',
        'slug' => 'program-juara',
        'title' => 'Merakit Algoritma Robot Master',
        'subtitle' => 'Tantangan puncak integrasi berpikir komputasional di Thinking Lab!',
        'learning_objective' => 'Sintesis pemikiran komputasional: Dekomposisi, Pola, Abstraksi, dan Algoritma.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 20,
        'config' => [
            'scenario' => 'Untuk menjadi Master Programmer, robot harus menyelesaikan misi: [ Ambil Kunci ➔ Lewati Jembatan ➔ Buka Pintu Kastel ].',
            'question' => 'Apakah definisi dari ALGORITMA yang tepat dalam ilmu komputer?',
            'visual_hint' => 'Langkah-langkah berurutan dan logis untuk menyelesaikan suatu masalah',
            'options' => [
                ['id' => 'definisi_tepat', 'text' => 'Urutan Langkah Logis & Terstruktur untuk Menyelesaikan Masalah', 'icon' => '🧠'],
                ['id' => 'game', 'text' => 'Nama Merk Komputer Jinjing', 'icon' => '💻'],
                ['id' => 'kabel', 'text' => 'Kabel Listrik Panjang di Lantai', 'icon' => '🔌'],
                ['id' => 'rusak', 'text' => 'Program Komputer yang Mengalami Kerusakan', 'icon' => '❌']
            ],
            'correct_answer' => 'definisi_tepat',
            'hints' => [
                ['level' => 1, 'text' => 'Algoritma seperti resep memasak: ada urutan langkah demi langkah yang jelas dari awal sampai selesai.'],
                ['level' => 2, 'text' => 'Tanpa algoritma yang rapi, komputer tidak tahu apa yang harus dikerjakan.'],
                ['level' => 3, 'text' => 'Pilih Urutan Langkah Logis & Terstruktur!']
            ],
            'reflection' => [
                'question' => 'Mengapa anak yang belajar berpikir komputasional menjadi lebih percaya diri memecahkan masalah?',
                'options' => [
                    'Karena terbiasa berpikir runut, tenang, kreatif, dan tidak takut menghadapi tantangan baru.',
                    'Karena bisa bermain game 24 jam tanpa tidur.',
                    'Karena tidak perlu sekolah lagi.'
                ],
                'correct' => 0
            ]
        ]
    ],

    // =========================================================================
    // WORLD 4: SPACE ODYSSEY (20 MISI ASTRONOMI, TATA SURYA & ANTARIKSA)
    // =========================================================================
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'roket-angkasa',
        'title' => 'Peluncuran Roket Angkasa',
        'subtitle' => 'Atur bahan bakar dan sudut luncur roket antariksa menuju stasiun luar angkasa!',
        'learning_objective' => 'Mengenal sudut lintasan peluncuran dan momentum gravitasi roket.',
        'interaction_type' => 'simulation',
        'xp_reward' => 100,
        'sort_order' => 1,
        'config' => [
            'scenario' => 'Roket Saturnus siap di landasan luncur! Atur kapasitas bahan bakar roket (70-90%) dan sudut kemiringan (40-60 derajat) agar roket meluncur mulus!',
            'question' => 'Atur bahan bakar (70-90%) dan sudut kemiringan (40-60°) untuk mengorbit!',
            'target_fuel' => [70, 90],
            'target_angle' => [40, 60],
            'hints' => [
                ['level' => 1, 'text' => 'Roket butuh dorongan bahan bakar besar untuk menembus gravitasi bumi.'],
                ['level' => 2, 'text' => 'Sudut kemiringan terbaik untuk masuk orbit adalah sekitar 45-55 derajat.'],
                ['level' => 3, 'text' => 'Atur bahan bakar 80% dan sudut 50°!']
            ],
            'reflection' => [
                'question' => 'Mengapa roket melepaskan tangki bahan bakarnya yang kosong saat meluncur naik?',
                'options' => [
                    'Untuk mengurangi beban berat roket sehingga bisa melesat lebih cepat menembus luar angkasa.',
                    'Karena tangki tersebut ingin kembali ke rumah.',
                    'Supaya roket berubah menjadi pesawat terbang.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'rasi-bintang',
        'title' => 'Rasi Bintang Penunjuk Arah',
        'subtitle' => 'Hubungkan gugusan bintang di langit malam untuk navigasi antariksa!',
        'learning_objective' => 'Mengenal rasi bintang dan sudut orientasi ruang di langit malam.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 2,
        'config' => [
            'scenario' => 'Pelaut dan astronot menggunakan rasi bintang salib selatan (Gubug Penceng / Crux) untuk menentukan arah SELATAN di malam hari.',
            'question' => 'Rasi bintang Salib Selatan (Crux) terdiri dari gugusan berapa bintang utama yang bersinar terang?',
            'visual_hint' => '✨ Rasi Bintang Pari / Salib Selatan (Crux)',
            'options' => [
                ['id' => '4', 'text' => '4 Bintang Utama Berbentuk Salib / Layang-Layang', 'icon' => '✨'],
                ['id' => '2', 'text' => '2 Bintang Saja', 'icon' => '⭐'],
                ['id' => '10', 'text' => '10 Bintang Melingkar', 'icon' => '🌟'],
                ['id' => '1', 'text' => '1 Bintang Tunggal', 'icon' => '💫']
            ],
            'correct_answer' => '4',
            'hints' => [
                ['level' => 1, 'text' => 'Bentuknya menyerupai layang-layang kecil atau palang salib.'],
                ['level' => 2, 'text' => 'Ada 4 bintang utama yang paling terang membentuk kerangka salib.'],
                ['level' => 3, 'text' => 'Pilih 4 Bintang Utama!']
            ],
            'reflection' => [
                'question' => 'Mengapa para pelaut kuno mengandalkan rasi bintang di langit untuk berlayar?',
                'options' => [
                    'Bintang di langit menjadi penunjuk arah utara dan selatan yang setia sebelum ada kompas dan GPS.',
                    'Supaya kapal tidak tenggelam.',
                    'Karena mereka ingin menyapa bintang di laut.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'rover-mars',
        'title' => 'Rover Penjelajah Mars',
        'subtitle' => 'Pandu robot penjelajah menghindari kawah permukaan Planet Merah!',
        'learning_objective' => 'Perencanaan koordinat grid permukaan planet dan rute aman robotik.',
        'interaction_type' => 'sequence_logic',
        'xp_reward' => 100,
        'sort_order' => 3,
        'config' => [
            'scenario' => 'Robot Rover mendarat di Mars. Jalur lurus terhalang kawah meteor. Masukkan perintah arah agar Rover sampai ke batuan kristal!',
            'question' => 'Program perintah: Maju ➔ Belok Kanan ➔ Maju ➔ Belok Kiri ➔ Maju!',
            'target_destination' => 'kristal_mars',
            'correct_sequence' => ['forward', 'turn_right', 'forward', 'turn_left', 'forward'],
            'hints' => [
                ['level' => 1, 'text' => 'Perhatikan kawah meteor merah di depan Rover, jangan sampai roda robot terperosok!'],
                ['level' => 2, 'text' => 'Gunakan belokan kanan untuk memutari bibir kawah meteor.'],
                ['level' => 3, 'text' => 'Urutan: Maju ➔ Belok Kanan ➔ Maju ➔ Belok Kiri ➔ Maju!']
            ],
            'reflection' => [
                'question' => 'Mengapa planet Mars tampak berwarna merah kemerahan saat dilihat dari teleskop?',
                'options' => [
                    'Permukaan tanah dan batuannya kaya akan debu besi oksida (berkarat) yang memantulkan warna merah.',
                    'Karena permukaan planet Mars terbakar api sepanjang hari.',
                    'Karena planet Mars terbuat dari cabai merah.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'urutan-planet',
        'title' => 'Parade Planet Mengitari Mentari',
        'subtitle' => 'Pelajari urutan 8 planet di dalam sistem tata surya kita!',
        'learning_objective' => 'Mengenal urutan planet dari yang terdekat dengan Matahari.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 4,
        'config' => [
            'scenario' => 'Matahari adalah pusat tata surya kita ☀️. Planet-planet beredar mengelilinginya dalam orbit elips.',
            'question' => 'Planet manakah yang posisinya PALING DEKAT dengan Matahari?',
            'visual_hint' => '☀️ Matahari ➔ [ ? ] ➔ Venus ➔ Bumi ➔ Mars ...',
            'options' => [
                ['id' => 'merkurius', 'text' => 'Merkurius (Planet Terdekat & Terkecil)', 'icon' => '🪐'],
                ['id' => 'bumi', 'text' => 'Bumi (Tempat Kita Tinggal)', 'icon' => '🌍'],
                ['id' => 'jupiter', 'text' => 'Jupiter (Planet Raksasa)', 'icon' => '🌕'],
                ['id' => 'neptunus', 'text' => 'Neptunus (Planet Paling Jauh)', 'icon' => '🔵']
            ],
            'correct_answer' => 'merkurius',
            'hints' => [
                ['level' => 1, 'text' => 'Planet ini mengitari matahari tercepat, hanya butuh 88 hari bumi.'],
                ['level' => 2, 'text' => 'Namanya berawalan huruf M dan berada tepat di sebelah matahari.'],
                ['level' => 3, 'text' => 'Pilih Merkurius!']
            ],
            'reflection' => [
                'question' => 'Mengapa suhu di permukaan Merkurius sangat panas di siang hari dan sangat beku di malam hari?',
                'options' => [
                    'Karena Merkurius hampir tidak memiliki lapisan atmosfer untuk menahan dan meratakan panas matahari.',
                    'Karena Merkurius terbuat dari balok es.',
                    'Karena Merkurius berhenti berputar.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'fase-bulan',
        'title' => 'Bentuk Bulan Sabit & Purnama',
        'subtitle' => 'Amati perubahan wajah bulan saat mengitari planet bumi!',
        'learning_objective' => 'Mengenal fase-fase bulan (bulan baru, sabit, separuh, purnama).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 5,
        'config' => [
            'scenario' => 'Di langit malam, bulan tampak bersinar bulat utuh sempurna dan sangat terang menerangi bumi 🌕.',
            'question' => 'Fase bulan saat seluruh piringan bulan memantulkan sinar matahari secara bulat utuh disebut?',
            'visual_hint' => 'Bulan bulat utuh benderang di malam hari',
            'options' => [
                ['id' => 'purnama', 'text' => 'Bulan Purnama (Full Moon)', 'icon' => '🌕'],
                ['id' => 'sabit', 'text' => 'Bulan Sabit (Crescent)', 'icon' => '🌙'],
                ['id' => 'baru', 'text' => 'Bulan Baru / Gelap (New Moon)', 'icon' => '🌑'],
                ['id' => 'separuh', 'text' => 'Bulan Separuh', 'icon' => '🌓']
            ],
            'correct_answer' => 'purnama',
            'hints' => [
                ['level' => 1, 'text' => 'Bulan ini bulat seperti piring emas yang terang benderang.'],
                ['level' => 2, 'text' => 'Terjadi di pertengahan bulan hijriah (sekitar tanggal 14 atau 15).'],
                ['level' => 3, 'text' => 'Pilih Bulan Purnama!']
            ],
            'reflection' => [
                'question' => 'Apakah Bulan memancarkan cahayanya sendiri seperti lampu?',
                'options' => [
                    'Tidak, Bulan hanya memantulkan sinar yang dipancarkan oleh Matahari ke arah Bumi.',
                    'Ya, di dalam Bulan ada pembangkit listrik raksasa.',
                    'Bulan menyala karena terbuat dari kunang-kunang.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'gravitasi-bumi',
        'title' => 'Tarikan Gravitasi Bumi & Bulan',
        'subtitle' => 'Eksperimen melompat di gravitasi bulan yang ringan!',
        'learning_objective' => 'Memahami gravitasi dan perbedaan berat benda di Bumi vs Bulan.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 6,
        'config' => [
            'scenario' => 'Astronot yang melompat di permukaan Bulan 👨‍🚀 bisa melayang tinggi dan lambat karena gravitasi Bulan hanya 1/6 dari gravitasi Bumi.',
            'question' => 'Jika di Bumi seorang anak berbobot 30 kg, berapakah bobotnya saat berdiri di permukaan Bulan?',
            'visual_hint' => 'Bobot di Bulan = 30 kg ÷ 6 = ?',
            'options' => [
                ['id' => '5', 'text' => '5 kg Saja (Terasa Sangat Ringan Melayang)', 'icon' => '🪶'],
                ['id' => '30', 'text' => '30 kg Tetap Sama', 'icon' => '⚖️'],
                ['id' => '60', 'text' => '60 kg Dua Kali Lebih Berat', 'icon' => '🏋️'],
                ['id' => '100', 'text' => '100 kg Sangat Berat', 'icon' => '🪨']
            ],
            'correct_answer' => '5',
            'hints' => [
                ['level' => 1, 'text' => 'Gravitasi bulan adalah 1/6 (seperenam) dari tarikan gravitasi bumi.'],
                ['level' => 2, 'text' => 'Bagi bobot 30 dengan angka 6: 30 ÷ 6 = ... ?'],
                ['level' => 3, 'text' => 'Bobotnya hanya terasa 5 kg!']
            ],
            'reflection' => [
                'question' => 'Mengapa udara atmosfer di Bumi tidak terbang melayang hilang ke luar angkasa?',
                'options' => [
                    'Karena gaya tarik gravitasi Bumi yang kuat memegang udara atmosfer tetap menyelimuti planet kita.',
                    'Karena di atas langit ada jaring kawat raksasa.',
                    'Karena awan mengikat udara dengan lem.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'orbit-satelit',
        'title' => 'Memasang Satelit Cuaca Mengorbit',
        'subtitle' => 'Luncurkan satelit pemantau badai pada orbit bumi yang tepat!',
        'learning_objective' => 'Mengenal satelit buatan dan fungsinya untuk komunikasi dan cuaca.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 7,
        'config' => [
            'scenario' => 'Satelit buatan 🛰️ diluncurkan ke orbit luar angkasa untuk memotret pergerakan awan dan badai di seluruh benua.',
            'question' => 'Manakah manfaat utama satelit cuaca bagi kehidupan manusia di Bumi?',
            'visual_hint' => '🛰️ Mengorbit Bumi & mengirimkan data gambar awan badai',
            'options' => [
                ['id' => 'prediksi_cuaca', 'text' => 'Memberi Peringatan Dini Badai & Memprediksi Cuaca Harian', 'icon' => '🌪️'],
                ['id' => 'matikan_hujan', 'text' => 'Menghentikan Hujan Secara Ajaib', 'icon' => '🌧️'],
                ['id' => 'membuat_malam', 'text' => 'Mengubah Siang Menjadi Malam', 'icon' => '🌙'],
                ['id' => 'tarik_bumi', 'text' => 'Menarik Bumi Mendekati Bulan', 'icon' => '🌍']
            ],
            'correct_answer' => 'prediksi_cuaca',
            'hints' => [
                ['level' => 1, 'text' => 'Satelit cuaca memotret pergerakan angin taifun, badai, dan awan hujan dari atas antariksa.'],
                ['level' => 2, 'text' => 'Petani dan nelayan bisa tahu kapan cuaca aman untuk melaut atau panen.'],
                ['level' => 3, 'text' => 'Pilih Memberi Peringatan Dini Badai!']
            ],
            'reflection' => [
                'question' => 'Satelit buatan manakah yang merupakan satelit alami satu-satunya milik planet Bumi?',
                'options' => [
                    'Bulan yang setia mengitari Bumi sejak miliaran tahun lalu.',
                    'Matahari.',
                    'Stasiun luar angkasa ISS.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'sabuk-asteroid',
        'title' => 'Menjelajahi Cincin Sabuk Asteroid',
        'subtitle' => 'Navigasi pesawat melintasi ribuan bongkahan batu angkasa!',
        'learning_objective' => 'Mengenal lokasi sabuk asteroid utama di antara orbit Mars dan Jupiter.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 8,
        'config' => [
            'scenario' => 'Di antara orbit dua planet di tata surya kita, terdapat sabuk asteroid ☄️ yang berisi jutaan bongkahan batu dan logam angkasa.',
            'question' => 'Di antara orbit planet manakah Sabuk Asteroid Utama (Asteroid Belt) berada?',
            'visual_hint' => 'Terletak di antara planet bebatuan terakhir dan planet gas pertama!',
            'options' => [
                ['id' => 'mars_jupiter', 'text' => 'Di antara Planet Mars dan Planet Jupiter', 'icon' => '🪐'],
                ['id' => 'bumi_bulan', 'text' => 'Di antara Bumi dan Bulan', 'icon' => '🌍'],
                ['id' => 'merkurius_venus', 'text' => 'Di antara Merkurius dan Venus', 'icon' => '☀️'],
                ['id' => 'saturnus_uranus', 'text' => 'Di luar Tata Surya', 'icon' => '🌌']
            ],
            'correct_answer' => 'mars_jupiter',
            'hints' => [
                ['level' => 1, 'text' => 'Mars adalah planet ke-4 dan Jupiter adalah planet ke-5.'],
                ['level' => 2, 'text' => 'Sabuk asteroid membatasi planet batuan dalam dengan planet gas raksasa luar.'],
                ['level' => 3, 'text' => 'Pilih Di antara Planet Mars dan Planet Jupiter!']
            ],
            'reflection' => [
                'question' => 'Apa yang terjadi jika pecahan kecil asteroid tertarik gravitasi Bumi dan jatuh ke atmosfer?',
                'options' => [
                    'Pecahan itu terbakar oleh gesekan udara atmosfer menjadi bintang jatuh (meteor).',
                    'Asteroid akan membelah Bumi menjadi dua.',
                    'Langit akan berubah menjadi warna ungu selamanya.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'cincin-saturnus',
        'title' => 'Misteri Cincin Es Saturnus',
        'subtitle' => 'Kagumi cincin spektakuler yang mengitari planet raksasa gas Saturnus!',
        'learning_objective' => 'Mengenal karakteristik planet Saturnus dan komposisi cincinnya.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 9,
        'config' => [
            'scenario' => 'Saturnus 🪐 memiliki cincin megah bercahaya yang melingkari badannya. Melalui teleskop canggih, terlihat ribuan partikel penyusun cincin tersebut.',
            'question' => 'Sebagian besar cincin planet Saturnus tersusun dari butiran materi apakah?',
            'visual_hint' => 'Miliaran serpihan es air beku, batu angkasa, dan debu kosmis',
            'options' => [
                ['id' => 'es_dan_batu', 'text' => 'Bongkahan Es Air Beku, Batu & Debu Kosmis', 'icon' => '🧊'],
                ['id' => 'emas_murni', 'text' => 'Cincin Emas Perhiasan Padat', 'icon' => '💍'],
                ['id' => 'kaca_prisma', 'text' => 'Kaca Jendela Tebal', 'icon' => '🪟'],
                ['id' => 'kayu_hutan', 'text' => 'Batang Kayu Pohon', 'icon' => '🪵']
            ],
            'correct_answer' => 'es_dan_batu',
            'hints' => [
                ['level' => 1, 'text' => 'Suhu di dekat Saturnus sangat dingin membeku karena jauh dari matahari.'],
                ['level' => 2, 'text' => 'Cincin memantulkan cahaya matahari dengan sangat cemerlang karena tersusun dari es air.'],
                ['level' => 3, 'text' => 'Pilih Bongkahan Es Air Beku, Batu & Debu Kosmis!']
            ],
            'reflection' => [
                'question' => 'Berapa banyak cincin utama yang mengelilingi Saturnus?',
                'options' => [
                    'Memiliki 7 kelompok cincin utama dengan ribuan alur cincin kecil yang memukau.',
                    'Hanya ada 1 cincin plastik.',
                    'Cincin Saturnus sebenarnya tidak ada.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'bintang-kejora',
        'title' => 'Menatap Venus Sang Bintang Fajar',
        'subtitle' => 'Pelajari planet terpanas di tata surya dengan efek rumah kaca ekstrem!',
        'learning_objective' => 'Mengenal planet Venus dan konsep efek rumah kaca atmosfer tebal.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 10,
        'config' => [
            'scenario' => 'Di waktu fajar sebelum matahari terbit, sering terlihat satu titik paling terang di langit timur yang dijuluki "Bintang Kejora".',
            'question' => 'Planet apakah yang dijuluki sebagai Bintang Fajar atau Bintang Kejora tersebut?',
            'visual_hint' => 'Planet terpanas berselimut awan tebal gas karbon dioksida',
            'options' => [
                ['id' => 'venus', 'text' => 'Planet Venus (Bintang Kejora)', 'icon' => '⭐'],
                ['id' => 'mars', 'text' => 'Planet Mars', 'icon' => '🔴'],
                ['id' => 'pluto', 'text' => 'Pluto', 'icon' => '❄️'],
                ['id' => 'bulan', 'text' => 'Komet Halley', 'icon' => '☄️']
            ],
            'correct_answer' => 'venus',
            'hints' => [
                ['level' => 1, 'text' => 'Meskipun dijuluki bintang, benda ini sebenarnya adalah planet kedua dari matahari.'],
                ['level' => 2, 'text' => 'Ukurannya hampir sama persis dengan planet Bumi, sehingga sering disebut saudara kembar Bumi.'],
                ['level' => 3, 'text' => 'Pilih Planet Venus!']
            ],
            'reflection' => [
                'question' => 'Mengapa suhu di Venus lebih panas daripada Merkurius meskipun Merkurius lebih dekat ke matahari?',
                'options' => [
                    'Atmosfer Venus yang sangat tebal memerangkap panas matahari secara ekstrem (efek rumah kaca).',
                    'Karena Venus terbuat dari lava cair aktif saja.',
                    'Karena matahari berada di dalam planet Venus.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'badai-jupiter',
        'title' => 'Bintik Merah Raksasa Badai Jupiter',
        'subtitle' => 'Jelajahi planet terbesar di tata surya yang bisa menampung 1.300 planet bumi!',
        'learning_objective' => 'Karakteristik planet raksasa gas Jupiter dan fenomena Bintik Merah Raksasa.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 11,
        'config' => [
            'scenario' => 'Jupiter adalah planet terbesar di tata surya 🌕. Di badannya terdapat pusaran badai merah raksasa bernama "Great Red Spot".',
            'question' => 'Berapa lama perkiraan badai Bintik Merah Raksasa di Jupiter telah berputar kencang tanpa henti?',
            'visual_hint' => 'Badai raksasa yang lebih besar dari seluruh ukuran planet Bumi!',
            'options' => [
                ['id' => '300_tahun', 'text' => 'Lebih dari 300 Tahun Lamanya!', 'icon' => '🌀'],
                ['id' => '3_hari', 'text' => 'Baru 3 Hari Kemarin', 'icon' => '🌧️'],
                ['id' => '1_jam', 'text' => 'Hanya 1 Jam Lalu', 'icon' => '⏱️'],
                ['id' => 'semenit', 'text' => 'Hanya Beberapa Menit', 'icon' => '🌪️']
            ],
            'correct_answer' => '300_tahun',
            'hints' => [
                ['level' => 1, 'text' => 'Badai ini sudah diamati oleh para astronom sejak ratusan tahun lalu menggunakan teleskop pertama.'],
                ['level' => 2, 'text' => 'Ukurannya sangat besar dan tidak pernah berhenti berputar sejak abad ke-17.'],
                ['level' => 3, 'text' => 'Pilih Lebih dari 300 Tahun Lamanya!']
            ],
            'reflection' => [
                'question' => 'Apakah astronot bisa berjalan kaki menginjakkan kaki di permukaan tanah padat Jupiter?',
                'options' => [
                    'Tidak bisa, karena Jupiter adalah planet raksasa gas yang tidak memiliki permukaan tanah berbatu yang padat.',
                    'Bisa, tanahnya sangat keras seperti semen.',
                    'Bisa, jika memakai sepatu besi.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'teleskop-angkasa',
        'title' => 'Mengarahkan Cermin Teleskop Hubble',
        'subtitle' => 'Amati galaksi spiral nan jauh di kedalaman semesta kosmis!',
        'learning_objective' => 'Mengenal teleskop luar angkasa dan galaksi Bima Sakti (Milky Way).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 12,
        'config' => [
            'scenario' => 'Teleskop luar angkasa Hubble dan James Webb 🔭 mengorbit di luar atmosfer Bumi untuk memotret bintang purba dan galaksi nan jauh.',
            'question' => 'Mengapa teleskop antariksa ditempatkan di luar atmosfer Bumi?',
            'visual_hint' => 'Bebas dari gangguan kabut, debu awan, dan polusi cahaya bumi',
            'options' => [
                ['id' => 'gambar_jernih', 'text' => 'Hasil Gambar Sangat Jernih Tanpa Terhalang Awan & Polusi Atmosfer', 'icon' => '🌌'],
                ['id' => 'lebih_dekat', 'text' => 'Agar Dekat dengan Bulan', 'icon' => '🌙'],
                ['id' => 'takut_hujan', 'text' => 'Karena Teleskop Takut Kehujanan', 'icon' => '🌧️'],
                ['id' => 'hanya_pajangan', 'text' => 'Hanya Sebagai Hiasan Luar Angkasa', 'icon' => '✨']
            ],
            'correct_answer' => 'gambar_jernih',
            'hints' => [
                ['level' => 1, 'text' => 'Atmosfer bumi sering memiliki awan tebal, uap air, dan polusi cahaya lampu kota.'],
                ['level' => 2, 'text' => 'Di luar angkasa yang hampa, cahaya bintang tidak terbiaskan oleh udara.'],
                ['level' => 3, 'text' => 'Pilih Hasil Gambar Sangat Jernih!']
            ],
            'reflection' => [
                'question' => 'Apakah nama galaksi tempat tata surya dan planet Bumi kita berada?',
                'options' => [
                    'Galaksi Bima Sakti (Milky Way Galaxy) yang berbentuk spiral indah.',
                    'Galaksi Cokelat Susu.',
                    'Galaksi Segitiga Bermuda.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'komet-berekor',
        'title' => 'Melacak Ekor Es Komet Halley',
        'subtitle' => 'Saksikan bola salju kotor kosmis yang melintas anggun di langit!',
        'learning_objective' => 'Mengenal komet dan penyebab terbentuknya ekor komet yang selalu menjauhi matahari.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 13,
        'config' => [
            'scenario' => 'Komet ☄️ adalah bongkahan es dan debu angkasa yang mengitari matahari dalam orbit sangat lonjong.',
            'question' => 'Ke arah manakah EKOR KOMET selalu mengarah saat mendekati matahari?',
            'visual_hint' => 'Angin matahari 💨 meniup gas komet menjauh dari mentari!',
            'options' => [
                ['id' => 'menjauhi_matahari', 'text' => 'Selalu Menjauhi Arah Matahari (Ditiup Angin Surya)', 'icon' => '☄️'],
                ['id' => 'menuju_matahari', 'text' => 'Selalu Menabrak Matahari', 'icon' => '☀️'],
                ['id' => 'menuju_bumi', 'text' => 'Selalu Menunjuk ke Arah Planet Bumi', 'icon' => '🌍'],
                ['id' => 'acak', 'text' => 'Berputar-Putar Acak Tanpa Arah', 'icon' => '🔄']
            ],
            'correct_answer' => 'menjauhi_matahari',
            'hints' => [
                ['level' => 1, 'text' => 'Matahari memancarkan radiasi dan partikel angin surya berkecepatan tinggi.'],
                ['level' => 2, 'text' => 'Partikel es komet yang menguap terdorong oleh angin surya menjauhi matahari.'],
                ['level' => 3, 'text' => 'Pilih Selalu Menjauhi Arah Matahari!']
            ],
            'reflection' => [
                'question' => 'Berapa tahun sekali Komet Halley yang terkenal melintas dekat dengan Bumi?',
                'options' => [
                    'Sekitar 75 sampai 76 tahun sekali.',
                    'Setiap hari Minggu sore.',
                    'Hanya satu juta tahun sekali.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'stasiun-iss',
        'title' => 'Sambung Modul Stasiun Luar Angkasa ISS',
        'subtitle' => 'Pelajari laboratorium antariksa manusia yang mengorbit bumi 16 kali sehari!',
        'learning_objective' => 'Mengenal International Space Station (ISS) dan kehidupan astronot di lingkungan mikrogravitasi.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 14,
        'config' => [
            'scenario' => 'Stasiun Luar Angkasa Internasional (ISS) 🛰️ mengorbit Bumi dengan kecepatan luar biasa 28.000 km/jam.',
            'question' => 'Berapa kali astronot di dalam stasiun ISS menyaksikan matahari terbit dan terbenam dalam 24 jam?',
            'visual_hint' => 'ISS mengelilingi Bumi setiap 90 menit sekali!',
            'options' => [
                ['id' => '16_kali', 'text' => 'Sekitar 16 Kali Matahari Terbit & Terbenam!', 'icon' => '🌅'],
                ['id' => '1_kali', 'text' => 'Hanya 1 Kali Seperti di Bumi', 'icon' => '☀️'],
                ['id' => 'tidak_ada', 'text' => 'Matahari Tidak Pernah Terbit', 'icon' => '🌑'],
                ['id' => '100_kali', 'text' => 'Seratus Kali', 'icon' => '💫']
            ],
            'correct_answer' => '16_kali',
            'hints' => [
                ['level' => 1, 'text' => 'Satu putaran penuh mengelilingi bumi hanya memakan waktu 90 menit.'],
                ['level' => 2, 'text' => '24 jam dibagi 1,5 jam = 16 putaran orbit sehari.'],
                ['level' => 3, 'text' => 'Pilih Sekitar 16 Kali!']
            ],
            'reflection' => [
                'question' => 'Bagaimana cara astronot di stasiun ISS tidur tanpa melayang menabrak dinding?',
                'options' => [
                    'Tidur di dalam kantong tidur khusus yang diikatkan kencang ke dinding kabin.',
                    'Tidur di atas kasur kapuk biasa.',
                    'Astronot di luar angkasa tidak pernah tidur sama sekali.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'baju-astronot',
        'title' => 'Perlengkapan Baju Antariksa Ruang Hampa',
        'subtitle' => 'Siapkan pakaian pelindung astronot sebelum berjalan di luar pesawat (Spacewalk)!',
        'learning_objective' => 'Memahami fungsi baju antariksa (EMU) dalam melindungi astronot dari suhu ekstrem dan ruang hampa.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 15,
        'config' => [
            'scenario' => 'Di luar angkasa tidak ada udara untuk bernapas dan suhunya bisa sangat membeku (-150°C) atau membakar (+120°C).',
            'question' => 'Gas penting apakah yang dialirkan oleh ransel baju antariksa ke helm astronot?',
            'visual_hint' => 'Gas vital untuk pernapasan manusia',
            'options' => [
                ['id' => 'oksigen', 'text' => 'Gas Oksigen Bersih (O2)', 'icon' => '🫧'],
                ['id' => 'karbon', 'text' => 'Asap Karbon Monoksida', 'icon' => '💨'],
                ['id' => 'helium', 'text' => 'Gas Helium Balon', 'icon' => '🎈'],
                ['id' => 'air', 'text' => 'Air Kolam Dingin', 'icon' => '🌊']
            ],
            'correct_answer' => 'oksigen',
            'hints' => [
                ['level' => 1, 'text' => 'Manusia memerlukan gas ini setiap detik untuk bernapas hidup.'],
                ['level' => 2, 'text' => 'Ransel baju antariksa berfungsi seperti paru-paru cadangan bagi astronot.'],
                ['level' => 3, 'text' => 'Pilih Gas Oksigen Bersih!']
            ],
            'reflection' => [
                'question' => 'Mengapa helm astronot memiliki lapisan kaca berlapis emas tipis?',
                'options' => [
                    'Melindungi mata astronot dari radiasi sinar ultraviolet dan silau terik matahari luar angkasa.',
                    'Agar astronot terlihat mewah seperti pangeran.',
                    'Supaya astronot bisa bercermin.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'siang-malam',
        'title' => 'Rotasi Bumi Penyebab Siang dan Malam',
        'subtitle' => 'Amati bagaimana putaran poros bumi menciptakan siang cerah dan malam berbintang!',
        'learning_objective' => 'Memahami akibat rotasi bumi (terjadinya siang dan malam serta gerak semu matahari).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 16,
        'config' => [
            'scenario' => 'Planet Bumi terus berputar pada porosnya dari barat ke timur 🌍. Sisi yang menghadap matahari menjadi terang benderang.',
            'question' => 'Berapa waktu yang dibutuhkan Bumi untuk melakukan 1 kali putaran penuh pada porosnya (Rotasi Bumi)?',
            'visual_hint' => 'Waktu satu siklus penuh siang dan malam',
            'options' => [
                ['id' => '24_jam', 'text' => '24 Jam (Satu Hari Penuh)', 'icon' => '🕐'],
                ['id' => '365_hari', 'text' => '365 Hari (Satu Tahun)', 'icon' => '📅'],
                ['id' => '1_jam', 'text' => '1 Jam Saja', 'icon' => '⏱️'],
                ['id' => '12_menit', 'text' => '12 Menit', 'icon' => '⏳']
            ],
            'correct_answer' => '24_jam',
            'hints' => [
                ['level' => 1, 'text' => 'Satu hari terdiri dari siang dan malam.'],
                ['level' => 2, 'text' => 'Sehari semalam memiliki durasi tepat 24 jam.'],
                ['level' => 3, 'text' => 'Pilih 24 Jam!']
            ],
            'reflection' => [
                'question' => 'Mengapa saat di Indonesia siang hari, di negara Amerika Serikat sedang malam hari?',
                'options' => [
                    'Karena letak benua berada di sisi bumi yang berlawanan terhadap arah sinar matahari.',
                    'Karena matahari di Amerika sedang dimatikan.',
                    'Karena jam di Amerika rusak.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'musim-bumi',
        'title' => 'Revolusi Bumi & Empat Musim',
        'subtitle' => 'Perjalanan bumi mengelilingi mentari selama 365 hari penuh!',
        'learning_objective' => 'Memahami akibat revolusi bumi dan kemiringan poros bumi (perubahan musim tahunan).',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 17,
        'config' => [
            'scenario' => 'Bumi berputar mengelilingi matahari dalam orbitnya sambil miring 23,5 derajat 🌏.',
            'question' => 'Berapa lama waktu yang dibutuhkan Bumi untuk mengelilingi Matahari sebanyak 1 putaran penuh (Revolusi)?',
            'visual_hint' => 'Satu putaran penuh revolusi bumi mengitari matahari',
            'options' => [
                ['id' => '1_tahun', 'text' => '1 Tahun (Sekitar 365¼ Hari)', 'icon' => '🗓️'],
                ['id' => '1_bulan', 'text' => '1 Bulan (30 Hari)', 'icon' => '🌙'],
                ['id' => '24_jam', 'text' => '24 Jam (Satu Hari)', 'icon' => '⏱️'],
                ['id' => '10_tahun', 'text' => '10 Tahun', 'icon' => '⏳']
            ],
            'correct_answer' => '1_tahun',
            'hints' => [
                ['level' => 1, 'text' => 'Waktu ini digunakan sebagai dasar penanggalan kalender Masehi dari Januari ke Desember.'],
                ['level' => 2, 'text' => 'Dalam satu siklus ini terjadi 4 musim di negara subtropis.'],
                ['level' => 3, 'text' => 'Pilih 1 Tahun (365¼ Hari)!']
            ],
            'reflection' => [
                'question' => 'Mengapa negara kita Indonesia hanya memiliki dua musim (musim hujan dan kemarau)?',
                'options' => [
                    'Karena Indonesia terletak di garis khatulistiwa (ekuator) yang menerima sinar matahari melimpah sepanjang tahun.',
                    'Karena Indonesia terlalu dekat dengan kutub es.',
                    'Karena di Indonesia salju dilarang turun.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'gerhana-matahari',
        'title' => 'Garis Lurus Gerhana Matahari',
        'subtitle' => 'Saksikan peristiwa langka saat bayangan bulan menutupi piringan matahari!',
        'learning_objective' => 'Memahami fenomena gerhana matahari dan gerhana bulan.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 18,
        'config' => [
            'scenario' => 'Matahari ☀️, Bulan 🌑, dan Bumi 🌍 berada dalam satu garis lurus sempurna. Bayangan bulan jatuh di permukaan bumi sehingga siang berubah jadi temaram.',
            'question' => 'Peristiwa antariksa menakjubkan ini disebut dengan?',
            'visual_hint' => '☀️ Matahari ➔ 🌑 Bulan di Tengah ➔ 🌍 Bumi',
            'options' => [
                ['id' => 'gerhana_matahari', 'text' => 'Gerhana Matahari (Solar Eclipse)', 'icon' => '🌑'],
                ['id' => 'badai_salju', 'text' => 'Badai Salju Es', 'icon' => '❄️'],
                ['id' => 'komet_jatuh', 'text' => 'Hujan Meteor', 'icon' => '☄️'],
                ['id' => 'pelangi', 'text' => 'Pelangi Malam', 'icon' => '🌈']
            ],
            'correct_answer' => 'gerhana_matahari',
            'hints' => [
                ['level' => 1, 'text' => 'Bulan berada di tengah-tengah menghalangi sinar matahari ke bumi.'],
                ['level' => 2, 'text' => 'Cahaya matahari tertutup oleh piringan bulan.'],
                ['level' => 3, 'text' => 'Pilih Gerhana Matahari!']
            ],
            'reflection' => [
                'question' => 'Mengapa kita dilarang menatap gerhana matahari secara langsung tanpa kacamata filter khusus?',
                'options' => [
                    'Sinar radiasi ultraviolet matahari yang sangat kuat dapat merusak retina mata kita secara permanen.',
                    'Supaya kacamata hitam di toko bisa laku.',
                    'Karena bulan akan marah jika dilihat.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'kecepatan-cahaya',
        'title' => 'Waktu Tempuh Cahaya Surya',
        'subtitle' => 'Hitung kecepatan lesatan cahaya melintasi ruang hampa tata surya!',
        'learning_objective' => 'Mengenal kecepatan cahaya (300.000 km/detik) dan jarak kosmis matahari-bumi.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 19,
        'config' => [
            'scenario' => 'Cahaya matahari melesat dengan kecepatan super 300.000 km per detik melintasi jarak 150 juta km menuju Bumi kita ☀️➔🌍.',
            'question' => 'Berapa waktu tempuh yang dibutuhkan seberkas sinar matahari untuk tiba di permukaan Bumi?',
            'visual_hint' => 'Jarak 150 Juta km ÷ 300.000 km/detik = Sekitar 500 Detik',
            'options' => [
                ['id' => '8_menit', 'text' => 'Sekitar 8 Menit 20 Detik', 'icon' => '⚡'],
                ['id' => '1_detik', 'text' => 'Hanya 1 Detik Langsung Tiba', 'icon' => '⏱️'],
                ['id' => '10_tahun', 'text' => '10 Tahun Perjalanan', 'icon' => '⏳'],
                ['id' => 'sehari', 'text' => 'Tepat 24 Jam', 'icon' => '📅']
            ],
            'correct_answer' => '8_menit',
            'hints' => [
                ['level' => 1, 'text' => '500 detik jika diubah ke menit adalah sekitar 8 menit.'],
                ['level' => 2, 'text' => 'Cahaya matahari yang menghangatkan tubuhmu pagi ini sebenarnya berangkat dari matahari 8 menit lalu.'],
                ['level' => 3, 'text' => 'Pilih Sekitar 8 Menit!']
            ],
            'reflection' => [
                'question' => 'Apakah ada benda atau materi di alam semesta yang kecepatannya bisa melebihi kecepatan cahaya?',
                'options' => [
                    'Menurut hukum fisika saat ini, kecepatan cahaya adalah batas kecepatan tertinggi mutlak di alam semesta.',
                    'Mobil balap F1 lebih cepat dari cahaya.',
                    'Roket mainan lebih cepat dari cahaya.'
                ],
                'correct' => 0
            ]
        ]
    ],
    [
        'world_slug' => 'space-odyssey',
        'slug' => 'lubang-hitam',
        'title' => 'Gravitasi Super Misteri Kosmis',
        'subtitle' => 'Puncak penjelajahan galaksi terjauh di Space Odyssey!',
        'learning_objective' => 'Mengenal fenomena astrofisika Lubang Hitam (Black Hole) dan gravitasi singularitas.',
        'interaction_type' => 'interactive_choice',
        'xp_reward' => 100,
        'sort_order' => 20,
        'config' => [
            'scenario' => 'Di pusat galaksi antariksa, terdapat objek kosmis misterius bernama Lubang Hitam (Black Hole) 🕳️ dengan gravitasi raksasa yang sangat dahsyat.',
            'question' => 'Apakah sifat paling unik dan menakjubkan dari Lubang Hitam (Black Hole)?',
            'visual_hint' => '🕳️ Gravitasi begitu kuat sehingga cahaya pun tidak bisa lepas darinya!',
            'options' => [
                ['id' => 'cahaya_tertarik', 'text' => 'Gravitasinya Begitu Kuat Sehingga Cahaya Sekalipun Tak Bisa Lepas Darinya!', 'icon' => '🌌'],
                ['id' => 'berisi_es', 'text' => 'Terbuat dari Es Krim Cokelat Manis', 'icon' => '🍨'],
                ['id' => 'terang', 'text' => 'Memancarkan Cahaya Sangat Terang Melebihi Matahari', 'icon' => '💡'],
                ['id' => 'dekat_bumi', 'text' => 'Berada di Dalam Lautan Pasifik', 'icon' => '🌊']
            ],
            'correct_answer' => 'cahaya_tertarik',
            'hints' => [
                ['level' => 1, 'text' => 'Karena cahayanya tidak bisa keluar, objek ini tampak gelap pekat (hitam).'],
                ['level' => 2, 'text' => 'Massa benda ini sangat padat terpusat di titik singularitas dengan gravitasi super dahsyat.'],
                ['level' => 3, 'text' => 'Pilih Gravitasinya Begitu Kuat Sehingga Cahaya Sekalipun Tak Bisa Lepas!']
            ],
            'reflection' => [
                'question' => 'Mengapa belajar sains antariksa membuat kita semakin bersyukur atas keindahan planet Bumi?',
                'options' => [
                    'Karena Bumi adalah rumah yang sangat istimewa dengan udara sejuk, air melimpah, dan kehidupan yang harus kita jaga bersama.',
                    'Supaya kita bisa pindah ke planet lain besok pagi.',
                    'Agar kita melupakan bumi.'
                ],
                'correct' => 0
            ]
        ]
    ]
];
