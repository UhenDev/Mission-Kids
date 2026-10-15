# 05. SPESIFIKASI SKEMA DATABASE — MISSION KIDS

## 1. Prinsip Desain Skema

Basis data MISSION KIDS dirancang dengan ketelitian relasional tinggi:
- **Integritas Relasional & Foreign Key:** Mendukung relasi antar akun pengguna, profil karakter, progres misi, dan riwayat XP.
- **Pembaruan Atomik (Database Transactions):** Penyelesaian misi dan pemberian XP dieksekusi dalam transaksi basis data terisolasi untuk mencegah ketidaksinkronan data jika terjadi kegagalan jaringan di tengah proses.
- **Kolom JSON untuk Konfigurasi Misi:** Setiap misi menyimpan muatan interaktif (*payload* cerita, target keberhasilan, variabel alat) di dalam kolom `config_json`, memungkinkan penambahan misi baru tanpa perlu migrasi skema tabel.
- **Kompatibilitas Lintas Mesin (SQLite & MySQL):** Skema SQL mematuhi standar ANSI SQL portabel, sehingga dapat berjalan lancar pada SQLite lokal maupun MySQL / MariaDB produksi via PDO.

---

## 2. Diagram Relasi Entitas (Entity Relationship Diagram / ERD)

```text
┌─────────────────┐       1:1       ┌─────────────────┐
│      users      ├─────────────────┤    profiles     │
└────────┬────────┘                 └────────┬────────┘
         │ 1                                 │ 1
         │                                   │
         ▼ *                                 ▼ *
┌─────────────────┐                 ┌─────────────────┐
│ xp_transactions │                 │user_achievements│
└─────────────────┘                 └────────▲────────┘
                                             │ *
┌─────────────────┐       1:*       ┌────────┴────────┐
│     worlds      ├─────────────────┤  achievements   │
└────────┬────────┘                 └─────────────────┘
         │ 1
         ▼ *
┌─────────────────┐       1:*       ┌─────────────────┐
│    missions     ├─────────────────┤mission_progress │
└────────┬────────┘                 └─────────────────┘
         │ 1
         ▼ *
┌─────────────────┐
│mission_attempts │
└─────────────────┘
```

---

## 3. Kamus Data (Data Dictionary)

### Tabel: `users` (Akun Pengguna)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | Pengidentifikasi unik pengguna |
| `username` | VARCHAR(50) | UNIQUE, NOT NULL | Nama pengguna untuk login (huruf & angka) |
| `password_hash` | VARCHAR(255) | NOT NULL | Hash kata sandi terenkripsi (`PASSWORD_DEFAULT` Bcrypt) |
| `role` | VARCHAR(20) | DEFAULT 'student' | Peran otorisasi pengguna (`student`, `parent`, `admin`) |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu pendaftaran akun |
| `updated_at` | DATETIME | ON UPDATE CURRENT_TIMESTAMP | Waktu pembaruan data terakhir |

### Tabel: `profiles` (Profil Karakter & Status Siswa)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID profil unik |
| `user_id` | INTEGER / INT | UNIQUE, FK -> users(id) | Terhubung ke akun pengguna |
| `nickname` | VARCHAR(60) | NOT NULL | Nama panggilan ramah anak |
| `avatar_id` | VARCHAR(30) | DEFAULT 'kian' | ID karakter 3D terpilih (`kian`, `sera`, `raka`, `nara`, `dika`, `bayu`, `fajar`, `luna`) |
| `current_level` | INTEGER | DEFAULT 1 | Level penjelajah saat ini (Level 1 sampai 5) |
| `total_xp` | INTEGER | DEFAULT 0 | Akumulasi perolehan poin pengalaman (*XP*) |
| `preferred_world_id` | INTEGER | NULL, FK -> worlds(id) | Pilihan dunia awal saat registrasi |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu pembuatan profil |
| `updated_at` | DATETIME | ON UPDATE CURRENT_TIMESTAMP | Waktu pembaruan profil |

### Tabel: `worlds` (Dunia Pembelajaran)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID dunia |
| `slug` | VARCHAR(50) | UNIQUE, NOT NULL | Slug pengenal URL (`number-city`, `discovery-lab`, dll) |
| `title` | VARCHAR(100) | NOT NULL | Judul nama dunia petualangan |
| `subtitle` | VARCHAR(150) | NOT NULL | Deskripsi tematik singkat |
| `theme_color` | VARCHAR(20) | NOT NULL | Kode warna heksadesimal atau token tema |
| `sort_order` | INTEGER | DEFAULT 1 | Urutan tampil dunia pada peta penjelajahan |
| `is_active` | INTEGER | DEFAULT 1 | Status aktif dunia (1 = aktif, 0 = nonaktif) |

### Tabel: `missions` (Daftar Misi Pembelajaran)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID misi |
| `world_id` | INTEGER / INT | NOT NULL, FK -> worlds(id) | Dunia tempat misi bernaung |
| `slug` | VARCHAR(60) | UNIQUE, NOT NULL | Slug pengenal URL misi (`toko-kue`, `tanaman-layu`, dll) |
| `title` | VARCHAR(120) | NOT NULL | Judul nama misi petualangan |
| `subtitle` | VARCHAR(200) | NOT NULL | Deskripsi tantangan misi |
| `learning_objective` | TEXT | NOT NULL | Tujuan capaian pembelajaran misi |
| `interaction_type` | VARCHAR(40) | NOT NULL | Tipe interaksi (`match_sort`, `simulation`, `sequence_logic`) |
| `xp_reward` | INTEGER | DEFAULT 100 | Hadiah dasar XP saat misi berhasil diselesaikan |
| `sort_order` | INTEGER | DEFAULT 1 | Urutan node misi di dalam dunia |
| `config_json` | TEXT | NOT NULL | Konfigurasi JSON (cerita, alat simulasi, target nilai, petunjuk MIKO) |
| `is_active` | INTEGER | DEFAULT 1 | Status ketersediaan misi |

### Tabel: `mission_progress` (Progres Node Misi Siswa)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID progres |
| `user_id` | INTEGER / INT | NOT NULL, FK -> users(id) | Siswa pemilik progres |
| `mission_id` | INTEGER / INT | NOT NULL, FK -> missions(id) | Misi terkait |
| `status` | VARCHAR(20) | DEFAULT 'locked' | Status node (`locked`, `available`, `completed`) |
| `stars` | INTEGER | DEFAULT 0 | Perolehan rating bintang (0 sampai 3 bintang) |
| `completed_at` | DATETIME | NULL | Waktu pertama kali misi berhasil diselesaikan |

### Tabel: `mission_attempts` (Log Percobaan Interaksi Misi)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID percobaan |
| `user_id` | INTEGER / INT | NOT NULL, FK -> users(id) | Siswa yang mencoba |
| `mission_id` | INTEGER / INT | NOT NULL, FK -> missions(id) | Misi yang dimainkan |
| `attempt_number`| INTEGER | DEFAULT 1 | Percobaan ke-N pada sesi ini |
| `is_success` | INTEGER | DEFAULT 0 | Hasil percobaan (1 = berhasil, 0 = belum berhasil) |
| `hints_used` | INTEGER | DEFAULT 0 | Jumlah petunjuk MIKO yang diakses |
| `user_solution` | TEXT | NULL | JSON data solusi yang dimasukkan anak |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu percobaan dilakukan |

### Tabel: `achievements` (Lencana Prestasi Kehormatan)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID lencana |
| `slug` | VARCHAR(50) | UNIQUE, NOT NULL | Pengenal lencana (`first-mission`, `little-scientist`, dll) |
| `title` | VARCHAR(100) | NOT NULL | Nama lencana kehormatan |
| `description` | VARCHAR(255) | NOT NULL | Syarat pencapaian untuk membuka lencana |
| `icon` | VARCHAR(30) | NOT NULL | Ikon lencana medali |
| `xp_bonus` | INTEGER | DEFAULT 50 | Bonus XP tambahan saat lencana diraih |

### Tabel: `user_achievements` (Riwayat Lencana Siswa)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID catatan |
| `user_id` | INTEGER / INT | NOT NULL, FK -> users(id) | Siswa penerima lencana |
| `achievement_id` | INTEGER / INT | NOT NULL, FK -> achievements(id) | Lencana yang berhasil diraih |
| `unlocked_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu lencana resmi dibuka |

### Tabel: `xp_transactions` (Buku Kas XP Siswa)
| Kolom | Tipe Data | Atribut | Keterangan |
| :--- | :--- | :--- | :--- |
| `id` | INTEGER / INT | PK, AUTO_INCREMENT | ID transaksi |
| `user_id` | INTEGER / INT | NOT NULL, FK -> users(id) | Siswa penerima XP |
| `amount` | INTEGER | NOT NULL | Besaran poin XP yang ditambahkan |
| `source` | VARCHAR(50) | NOT NULL | Sumber perolehan (`mission_clear`, `first_try_bonus`, `achievement`) |
| `reference_id` | INTEGER | NULL | ID referensi entitas terkait (misal mission_id) |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Waktu pencatatan transaksi XP |

---

## 4. Mekanisme Inisialisasi Otomatis (Auto-Bootstrap)

Pada lingkungan container Docker maupun server hosting:
1. Kelas [`Database.php`](file:///c:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/config/database.php) mendeteksi keberadaan file database SQLite di path yang ditentukan (`/app/database/mission_kids.sqlite` atau direktori lokal).
2. Jika file belum ada atau kosong (0 tabel), sistem menjalankan metode `autoBootstrap()` yang membaca dan mengeksekusi file [`database/schema.sql`](file:///c:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/database/schema.sql) dan [`database/seeds.sql`](file:///c:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/database/seeds.sql).
3. Struktur 4 dunia, 80 misi lengkap, dan data lencana otomatis terisi secara instan dan idempoten (tidak akan menduplikasi data jika sudah ada).
