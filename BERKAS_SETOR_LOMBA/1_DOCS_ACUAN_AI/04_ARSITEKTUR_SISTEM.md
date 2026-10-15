# 04. ARSITEKTUR SISTEM — MISSION KIDS

## 1. Gambaran Umum Arsitektur
MISSION KIDS dirancang sebagai platform edukasi yang sangat cepat, mudah dipelihara, dan minim dependensi pihak ketiga yang membebani. Sistem menggabungkan *Single-Page Mission Engine* modular di sisi klien dengan backend Native PHP 8.2+ yang aman serta persistensi relasional berbasis SQLite / MySQL.

```text
┌────────────────────────────────────────────────────────────────────────┐
│                        LAPISAN KLIEN (BROWSER)                         │
│                                                                        │
│  ┌─────────────────┐   ┌────────────────────┐   ┌───────────────────┐  │
│  │   UI Renderer   │   │   Mission Engine   │   │  MIKO Companion   │  │
│  │  (Vanilla DOM)  │   │  (7-Step Lifecycle)│   │  (Scaffolding UI) │  │
│  └────────┬────────┘   └─────────┬──────────┘   └─────────┬─────────┘  │
│           │                      │                        │            │
│           └──────────────────────┼────────────────────────┘            │
│                                  │ (JSON Fetch / REST)                 │
└──────────────────────────────────┼─────────────────────────────────────┘
                                   │
                                   ▼
┌────────────────────────────────────────────────────────────────────────┐
│                      LAPISAN APLIKASI (PHP 8.2+)                       │
│                                                                        │
│  ┌──────────────────────────────────────────────────────────────────┐  │
│  │                     Front Controller (index.php)                 │  │
│  │                     Router & Session Auth Guard                  │  │
│  └──────────────────┬─────────────────────────────┬─────────────────┘  │
│                     │                             │                    │
│      ┌──────────────┴──────────────┐   ┌──────────┴───────────────┐    │
│      │     Page Controllers        │   │       REST API API       │    │
│      │ (Home, Worlds, Mission, ..) │   │ (Missions, Hint, XP, ..) │    │
│      └──────────────┬──────────────┘   └──────────┬───────────────┘    │
│                     │                             │                    │
│      ┌──────────────┴─────────────────────────────┴───────────────┐    │
│      │                  Lapisan Service & Domain                  │    │
│      │    (AuthService, MissionService, GamificationService)      │    │
│      └──────────────────────────────┬─────────────────────────────┘    │
│                                     │                                  │
│             ┌───────────────────────┴───────────────────────┐          │
│             ▼                                               ▼          │
│  ┌─────────────────────┐                         ┌──────────────────┐  │
│  │ Database Repository │                         │  AI Gateway API  │  │
│  │    (PDO Prepared)   │                         │(Gemini/Groq/Open)│  │
│  └──────────┬──────────┘                         └─────────┬────────┘  │
└─────────────┼──────────────────────────────────────────────┼───────────┘
              │                                              │
              ▼                                              ▼
┌───────────────────────────┐                  ┌─────────────────────────┐
│     LAPISAN DATABASE      │                  │     API AI EKSTERNAL    │
│   SQLite 3 / MySQL PDO    │                  │  (Server-to-Server SSL) │
│ (Users, Missions, XP, ..) │                  │  (Strict Guardrails)    │
└───────────────────────────┘                  └─────────────────────────┘
```

---

## 2. Struktur Direktori Proyek

```text
mission-kids/
├── config/
│   ├── config.php             # Konfigurasi aplikasi, kredensial DB, & kunci API AI
│   └── database.php           # Factory koneksi PDO (SQLite otomatis dengan fallback MySQL)
├── database/
│   ├── schema.sql             # Definisi skema tabel relasional (DDL)
│   ├── seeds.sql              # Data awal dunia, 80 misi, dan lencana prestasi
│   └── mission_kids.sqlite    # File database SQLite aktif (disimpan dalam volume persistensi)
├── docs/                      # Dokumentasi teknis & spesifikasi sistem lengkap (Bahasa Indonesia)
├── src/
│   ├── Controllers/
│   │   ├── AuthController.php # Penanganan alur login, register, dan logout
│   │   ├── HomeController.php # Penanganan dashboard beranda siswa
│   │   ├── WorldController.php# Navigasi 4 dunia petualangan
│   │   ├── MissionController.php # Penyaji kanvas misi interaktif
│   │   └── ApiController.php  # Endpoint API REST JSON (petunjuk, selesaikan misi, profil)
│   ├── Services/
│   │   ├── AuthService.php    # Autentikasi, enkripsi password, registrasi & profil
│   │   ├── MissionProgressService.php # Manajemen 4 dunia & 80 misi terstruktur
│   │   ├── GamificationService.php # Kalkulator XP, level up, dan lencana
│   │   └── MikoAiService.php  # Integrasi AI scaffolding & fallback offline cerdas
│   └── Helpers/
│       ├── Avatar.php         # Metadata & helper 8 avatar karakter anak 3D
│       ├── Security.php       # Sanitasi XSS e(), generator CSRF, & pelindung sesi
│       └── Session.php        # Pengelola sesi aman
├── templates/
│   ├── layouts/
│   │   ├── header.php         # Navbar siswa/tamu, level meter, avatar badge, audio toggle
│   │   └── footer.php         # Footer publik & footer khusus autentikasi dengan kredit
│   ├── pages/
│   │   ├── landing.php        # Halaman muka publik (hero, fitur, dunia, MIKO intro)
│   │   ├── auth/login.php     # Halaman login modern taktil dengan panel pemandangan
│   │   ├── auth/register.php  # Halaman registrasi dengan 8 kartu portrait avatar & podium preview
│   │   ├── student/home.php   # Beranda siswa & quest harian
│   │   ├── student/worlds.php # Peta 4 dunia & daftar 80 misi interaktif
│   │   ├── student/mission_play.php # Kanvas interaktif simulasi misi
│   │   ├── student/achievements.php # Galeri lencana prestasi kehormatan
│   │   └── student/progress.php # Profil statistik pembelajaran siswa
│   └── components/
│       ├── miko_bubble.php    # Komponen maskot MIKO mengambang di seluruh halaman
│       └── xp_modal.php       # Modal dialog perayaan kenaikan level & hadiah XP
├── public/
│   ├── index.php              # Titik masuk utama & router terpusat
│   ├── css/
│   │   ├── design-system.css  # Variabel token CSS, reset, tipografi
│   │   ├── components.css     # Tombol 3D, card login, kartu portrait avatar, footer
│   │   ├── missions.css       # Kanvas simulasi misi & nampan interaktif
│   │   └── worlds.css         # Tema visual skin peta dunia
│   ├── js/
│   │   ├── app.js             # Skrip global aplikasi, audio engine, speech dialog
│   │   ├── engine/
│   │   │   ├── MissionEngine.js      # State machine siklus 7 langkah misi
│   │   │   ├── InteractionHandler.js # Drag-drop, simulator live, robot sequencer
│   │   │   └── MikoCompanion.js      # Pengambil petunjuk AI & sinkronisasi suara MIKO
│   │   └── missions/
│   │       ├── world1_number_city.js
│   │       ├── world2_discovery_lab.js
│   │       ├── world3_thinking_lab.js
│   │       └── world4_space_odyssey.js
│   └── assets/
│       ├── audio/miko/        # Klip audio ucapan & perayaan MIKO (.mp3)
│       └── images/
│           ├── avatars/       # Ilustrasi potret 8 karakter anak 3D (.png)
│           └── login-adventure-landscape.jpg
├── tests/                     # Suite pengujian otomatis komprehensif
└── Dockerfile                 # Konfigurasi container produksi dengan mount volume database
```

---

## 3. Siklus Hidup Permintaan & Perutean (Request Lifecycle)

1. Semua permintaan browser diarahkan ke [`public/index.php`](file:///c:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/public/index.php).
2. Front controller menjalankan hardening sesi (`cookie_httponly`, `samesite=Lax`, `use_strict_mode`).
3. Database bootstrapper memeriksa dan menginisialisasi skema serta seed data secara otomatis jika file database belum ada.
4. Router membaca parameter query `?page=` atau path rute.
5. Jika halaman memerlukan status masuk siswa (*Auth Guard*), sistem memvalidasi `Session::isLoggedIn()`. Pengguna yang belum terautentikasi otomatis dialihkan ke `?page=login`.
6. Permintaan API (`?page=api&action=...`) merespons secara eksklusif dengan amplop format JSON standar:
   ```json
   {
     "success": true,
     "data": { ... },
     "error": null
   }
   ```

---

## 4. Arsitektur Engine Misi Sisi Klien

Simulasi interaksi misi berjalan di sisi browser (*client-side*) untuk menjamin performa rendering responsif 60fps yang nyaman bagi anak:
1. **MissionEngine:** State machine yang mengelola fase: `STORY` → `LEARN` → `ACTIVITY` → `CHALLENGE` → `FEEDBACK` → `REFLECTION` → `REWARD`.
2. **InteractionHandler:** Sub-kontroler modular untuk 3 paradigma interaksi:
   - `MatchSortHandler` (Mengetuk koin, memasang balok angka, kristal pola)
   - `SimulationHandler` (Slider takaran air, tirai cahaya, jarak senter dengan reaksi SVG dinamis)
   - `SequenceHandler` (Penyusunan blok perintah robot, eksekusi langkah demi langkah dengan highlight kartu aktif)
3. **MikoCompanion:** Memantau upaya siswa. Jika siswa mengalami kendala berulang, MIKO akan menyapa dan menawarkan Petunjuk Level 1 tanpa menutupi area kerja misi.
4. **Completion Syncer:** Mengirimkan permintaan POST aman ke `/api?action=complete_mission` lengkap dengan token CSRF, jumlah percobaan, dan jawaban refleksi untuk menghitung XP serta membuka node misi berikutnya di database.

---

## 5. Strategi Deployment & Persistensi Docker (Dokploy)

Dalam lingkungan container Docker (seperti Dokploy):
- Direktori `/app/database` dideklarasikan sebagai `VOLUME ["/app/database"]` dalam [`Dockerfile`](file:///c:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/Dockerfile).
- File database SQLite tersimpan secara persisten pada volume host, sehingga data akun siswa, level, XP, dan riwayat misi tidak akan hilang saat container di-deploy ulang.
- Mekanisme *Auto-Bootstrap Idempotent* secara otomatis mengeksekusi `schema.sql` dan `seeds.sql` saat pertama kali aplikasi dijalankan pada container baru yang kosong.
