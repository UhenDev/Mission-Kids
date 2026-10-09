# DEBUG LOG — MISSION KIDS
*Systematic record of diagnostic findings, root cause investigations, and resolutions*

---

### Issue #001 — MySQL Daemon Connection (10061) on Initial Boot
- **Date:** 2026-10-05
- **Symptoms:** Initial attempt to query MySQL via CLI returned `ERROR 2002 (HY000): Can't connect to MySQL server on 'localhost' (10061)`.
- **Reproduction:** Running `& "C:\xampp2\mysql\bin\mysql.exe" -u root -e "SELECT 1;"` when service was stopped.
- **Root Cause:** The mysqld daemon was not active as a background service initially. Additionally, inspection of `mysql_error.log` indicated historic orphaned tablespaces from an unrelated database (`rumah_sakit`), but the primary server engine was intact.
- **Solution:** 
  1. Verified binary configuration in `C:\xampp2\mysql\bin\my.ini`.
  2. Spawned MariaDB/MySQL daemon with `& "C:\xampp2\mysql\bin\mysqld.exe" --defaults-file="C:\xampp2\mysql\bin\my.ini" --console`.
  3. Validated port 3306 listening socket and executed `SHOW DATABASES;` successfully.
- **Validation:** MariaDB 10.4.32 reported `ready for connections. port: 3306`, and query returned database lists with code 0.
- **Status:** RESOLVED.

---

### Issue #002 — Relative Path in landing.php Layout Inclusions
- **Date:** 2026-10-05
- **Symptoms:** `Warning: Failed to open stream: No such file or directory in templates/pages/landing.php on line 8`.
- **Reproduction:** Requesting `http://127.0.0.1:8080/?page=landing`.
- **Root Cause:** `landing.php` resides directly in `templates/pages/` (1 level deep from `templates/`), but was referencing `__DIR__ . '/../../layouts/header.php'` which traversed 2 levels up to the project root instead of `templates/layouts/header.php`.
- **Solution:** Corrected the path in `templates/pages/landing.php` to `__DIR__ . '/../layouts/header.php'` and `__DIR__ . '/../layouts/footer.php'`.
- **Validation:** HTTP GET request returned HTTP 200 OK with clean HTML rendering.
- **Status:** RESOLVED.

---

### Issue #003 — CLI Headers Warning in Session::start()
- **Date:** 2026-10-05
- **Symptoms:** `PHP Warning: ini_set(): Session ini settings cannot be changed after headers have already been sent` when running automated tests in CLI.
- **Reproduction:** Running `php test_suite.php` where CLI outputs text before calling `Session::start()`.
- **Root Cause:** In PHP CLI, text printed to STDOUT marks headers as sent, preventing `ini_set` and `session_name` from modifying session parameters.
- **Solution:** Added `if (!headers_sent())` guards around `ini_set` and `session_name` in `src/Helpers/Session.php`, plus checked `session_status() === PHP_SESSION_ACTIVE` before invoking `@session_regenerate_id(true)`.
- **Validation:** `php test_suite.php` runs cleanly with 17/17 tests passing and zero warnings.
- **Status:** RESOLVED.

---

### Issue #004 — Mobile Header Button Overflow on Landing Page
- **Date:** 2026-10-05
- **Symptoms:** As captured in user mobile screenshot (iPhone viewport ~375px), the "Mulai Petualangan 🌟" button in the top navbar wrapped into multiple lines and overflowed awkwardly downward over the hero content.
- **Reproduction:** Loading the landing page on a viewport with width $\le 390\text{px}$.
- **Root Cause:** Fixed padding (`0.5rem 1.4rem`) and long text string ("Mulai Petualangan 🌟") alongside the brand logo and "Masuk" button exceeded the horizontal container width (~421px needed vs 375px available).
- **Solution:**
  1. Refactored guest header actions in [`templates/layouts/header.php`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/templates/layouts/header.php) using `.header-guest-actions` and `.btn-nav-auth`.
  2. Implemented dual-label responsive text: desktop displays full text (`.btn-text-full`: "Mulai Petualangan 🌟"), while screens $\le 640\text{px}$ automatically switch to concise text (`.btn-text-short`: "Daftar ✨").
  3. Added compact mobile padding (`0.35rem 0.75rem`) and font size (`var(--fs-xs)`), ensuring total navbar content fits within ~298px.
  4. Stacked hero CTA buttons gracefully with `.hero-actions-row` and `.hero-cta-btn` (`max-width: 320px; width: 100%;`).
- **Validation:** Inspected DOM output and CSS rules; total navbar width verified well within 375px with zero wrapping or overflow.
- **Status:** RESOLVED.

### Issue #005: Mobile Guest Header Button Wrap & Cache-Busting (Bahasa Indonesia Full Translation)
- **Symptom:** Pada tampilan peramban mobile (seperti iPhone di tangkapan layar pengguna), tombol "Mulai Petualangan 🌟" membungkus teks ke 3 baris dan terlihat keluar dari batas bilah navigasi atas karena cache CSS lama pada peramban klien. Selain itu, judul utama masih berbahasa Inggris ("Your Mission Starts Here.").
- **Root Cause:**
  1. Peramban mobile menyimpan cache stylesheet tanpa query string versi.
  2. Judul hero landing page masih menggunakan bahasa Inggris.
  3. `white-space: nowrap !important` dan `height: 36px !important` perlu diperkuat pada `.btn-nav-auth` saat resolusi $\le 768\text{px}$.
- **Solution:**
  1. Menerjemahkan seluruh antarmuka ke Bahasa Indonesia: "Petualangan Misimu Dimulai di Sini." dan label tombol ringkas "Daftar ✨" untuk mobile.
  2. Menambahkan cache-busting `?v=2.0` pada tag `<link>` CSS di [header.php](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/templates/layouts/header.php).
  3. Mengunci `white-space: nowrap !important;`, `box-sizing: border-box !important;`, dan `min-height: 36px !important;` pada media query mobile di [components.css](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/public/css/components.css).
- **Validation:** 17/17 pengujian otomatis lulus. Output HTML pada server lokal `http://127.0.0.1:8080/` terverifikasi 100% Bahasa Indonesia.
- **Status:** RESOLVED.

### Issue #006: Rich Animation & Micro-Interactions Upgrade (Aesthetic Elevation)
- **Symptom:** Antarmuka web terasa agak statis bagi anak-anak yang membutuhkan umpan balik visual dan audio interaktif yang kaya (*playful precision*).
- **Root Cause:** Awalnya baru memiliki 4 aturan `@keyframes` sederhana tanpa efek partikel atau suara sintesis.
- **Solution:**
  1. Membuat sistem animasi modular [animations.css](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/public/css/animations.css) dengan fisika melayang (floating roket & stiker), efek pantulan lentur (*jelly bounce*), kilau cahaya tombol (*shine sweep*), ombak cairan progres bar, serta animasi bernapas dan berkedip maskot MIKO.
  2. Mengimplementasikan [CelebrationEffects.js](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/public/js/engine/CelebrationEffects.js) untuk ledakan konfeti kanvas dinamis saat menyelesaikan misi serta penghitung angka XP animasi.
  3. Mengimplementasikan [SoundEffects.js](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/public/js/engine/SoundEffects.js) dengan Web Audio API untuk suara pop tombol, nada kemenangan arpeggio, denting bintang, dan tombol kendali bisu (🔊/🔇).
  4. Meningkatkan simulasi interaktif Tanaman Layu dengan tetesan air mengalir, rotasi aura matahari, dan partikel bintang saat mekar.
- **Validation:** 17/17 pengujian otomatis lulus. HTML & CSS linked dengan sukses.
- **Status:** RESOLVED.

---

### Issue #007: SQLite Prepared Statement Syntax Error on Fallback
- **Date:** 2026-10-09
- **Symptom:** `PHP Fatal error: Uncaught PDOException: SQLSTATE[HY000]: General error: 1 near "DUPLICATE": syntax error in MissionProgressService.php:123` saat berjalan dalam mode SQLite fallback.
- **Root Cause:** Pemanggilan `$this->db->prepare(...)` dengan klausa MySQL-specific `ON DUPLICATE KEY UPDATE` dieksekusi terlebih dahulu sebelum pemeriksaan kondisi `if (Database::getDriverUsed() === 'sqlite')`. Pada SQLite PDO, `prepare()` melempar eksepsi sintaks secara langsung.
- **Solution:** Memindahkan pemeriksaan `Database::getDriverUsed() === 'sqlite'` ke blok branching `if...else` sebelum pemanggilan `$this->db->prepare()`, serta menyediakan klausa SQLite `ON CONFLICT(user_id, mission_id) DO UPDATE SET ...` yang valid.
- **Validation:** Seluruh 17/17 pengujian unit `test_suite.php` dan 31/31 pengujian endpoint `test_all_endpoints.php` berhasil lulus 100%.
- **Status:** RESOLVED.

---

### Issue #008: Premature Closing DIV in Plant Simulation SVG Layout
- **Date:** 2026-10-09
- **Symptom:** Tag penutup `</div>` ganda pada baris 61 di `InteractionHandler.js` menutup kontainer flex lebih awal sebelum elemen `<svg>` dan indikator meter dimuat.
- **Root Cause:** Kesalahan ketik struktur HTML string literal template pada modul simulasi tanaman.
- **Solution:** Menghapus tag `</div>` berlebih pada `mountPlantSimulation()` sehingga elemen SVG tanaman, status bunga, dan meter kesehatan terbungkus rapi dalam kontainer flex pusat.
- **Validation:** Hirarki DOM terverifikasi valid tanpa tag penutup yatim.
- **Status:** RESOLVED.

---

### Issue #009: Missing Event Listener on MIKO Bubble Close Button
- **Date:** 2026-10-09
- **Symptom:** Tombol tutup silang (`&times;`) pada balon percakapan Sahabat MIKO (`#miko-bubble-close`) tidak merespons klik dari pengguna.
- **Root Cause:** Elemen `mikoClose` telah dideklarasikan di `public/js/app.js`, namun pendaftaran `addEventListener('click')` terlewat.
- **Solution:** Menambahkan handler klik dengan `e.stopPropagation()` dan `mikoBubble.classList.remove('active')` pada `mikoClose`.
- **Validation:** Balon percakapan dapat dibuka dan ditutup dengan responsif baik melalui avatar MIKO maupun tombol silang.
- **Status:** RESOLVED.



