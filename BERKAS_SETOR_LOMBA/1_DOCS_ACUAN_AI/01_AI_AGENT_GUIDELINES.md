# PANDUAN PENGEMBANGAN AI AGENT (AI AGENT GUIDELINES)
## Proyek: "MISSION KIDS" — Platform Edukasi Interaktif Berbasis Misi untuk Anak SD

Dokumen ini berfungsi sebagai acuan utama (*System Prompt & Context Compass*) bagi AI Agent (seperti Cursor, GitHub Copilot, Claude, Gemini, atau ChatGPT) selama proses perancangan, pembuatan kode, *debugging*, dan optimasi platform **MISSION KIDS**.

---

### 1. Tujuan Proyek (Goal)
Membangun **"MISSION KIDS"**, sebuah platform web interaktif berbasis misi nyata (*Mission-Based Learning*) untuk mengenalkan fondasi logika pemecahan masalah (*real-world problem solving*), numerasi kontekstual, observasi sains alam, dan *computational thinking* (algoritma, urutan langkah/sequencing, dan perulangan/looping) kepada peserta didik Sekolah Dasar (kelas 4–6). 

Pembelajaran dirancang melalui pendekatan *playful precision*: anak tidak sekadar membaca materi atau mengerjakan kuis pilihan ganda statis, melainkan menghadapi misi konkret, bereksperimen dengan objek interaktif di kanvas, berdialog dengan sahabat AI **MIKO**, melakukan refleksi kognitif, dan merayakan pencapaian.

---

### 2. Standar Stack Teknologi (Technology Stack)
Setiap kode yang dihasilkan oleh AI Agent wajib mematuhi batasan teknologi bersih berikut (*zero-framework bloat*):

- **Backend:** **Native PHP (PHP 8.2+) dengan Pola Clean MVC**
  - Arsitektur terpisah: *Controllers*, *Services*, *Models/Repositories*, dan *View Templates*.
  - Tanpa framework besar (Laravel/Symfony) untuk kecepatan eksekusi instan dan kemudahan portabilitas di berbagai lingkungan server (termasuk shared hosting/cPanel).
  - Manajemen sesi aman: regenerasi ID sesi otomatis, token CSRF unik per form/request, proteksi injeksi SQL via PDO *prepared statements*.
- **Database:** **MariaDB 10.4+ / MySQL dengan Fallback SQLite Otomatis**
  - Transaksi ACID terisolasi penuh (`BEGIN TRANSACTION`, `COMMIT`, `ROLLBACK`) dengan *row-level locking* (`FOR UPDATE`) pada tabel `profiles` dan `mission_progress`.
  - Idempotensi reward terjamin via constraint unik database (`idx_unique_xp_reward_claim` dan `idx_unique_user_mission_progress`).
- **Struktur & Tampilan:** **HTML5 Semantik & CSS3 Murni (Vanilla CSS)**
  - Tata letak modern menggunakan Flexbox dan CSS Grid responsif (desktop, tablet, mobile).
  - Skema token warna dan tipografi terpusat menggunakan **CSS Variables / Custom Properties** (`design-system.css`).
  - Animasi mikro halus, efek *bounce tactile*, dan elevasi visual menggunakan `@keyframes` CSS murni (`animations.css`).
- **Interaktivitas Klien:** **Vanilla JavaScript (ES6+ Modular)**
  - *Client-side Game Engine*: `MissionEngine.js`, `InteractionHandler.js`, `MikoCompanion.js`.
  - Manipulasi DOM aman tanpa library eksternal (anti-DOM XSS, isolasi sanitasi *text nodes*).
- **Audio & Voice Synthesizer:**
  - **Web Audio API Native:** Mesin efek suara dan musik latar prosedural (*procedural synthesizer*) tanpa file MP3 eksternal (zero-asset, 100% offline, volume adaptif, kontrol mute).
  - **Web Speech API Native:** Fitur *Text-to-Speech* bahasa Indonesia (`id-ID`) dengan nada ceria ramah anak untuk menyuarakan petunjuk dan sapaan MIKO.
- **Efek Selebrasi:** **HTML5 Canvas Particle Confetti** (`CelebrationEffects.js`) berbobot ringan tanpa ketergantungan CDN eksternal.

---

### 3. Arsitektur & Fitur Utama (Core Features)

1. **Halaman Utama (Landing Page):**
   - Hero modern dengan headline ramah anak, tombol CTA bermain, dan ilustrasi petualangan bersama MIKO.
   - Section **Fitur Unggulan**: Eksperimen Sains, Logika & Pola, Pemrograman Dasar, dan Reward & Pencapaian.
   - Section **4 Dunia Petualangan**: Thumbnail visual untuk *Number City*, *Discovery Lab*, *Thinking Lab*, dan *Space Odyssey*.
2. **4 Dunia Petualangan & 80 Misi Pembelajaran Terstruktur:**
   - **Dunia 1: Number City (Numerasi & Belanja) — 20 Misi**
     - Skenario belanja toko kue, pecahan uang kembalian, deret aritmetika jembatan angka, lampu kristal pola, dan estimasi hitungan.
   - **Dunia 2: Discovery Lab (Sains & Alam) — 20 Misi**
     - Eksperimen fotosintesis bunga matahari, optika bayangan panggung, siklus air hidrologi, massa benda, dan suhu.
   - **Dunia 3: Thinking Lab (Computational Thinking & Algoritma) — 20 Misi**
     - Navigasi sekuensial robot Botty, percabangan kondisional IF-ELSE, optimasi loop pengulangan, dan algoritma pengurutan.
   - **Dunia 4: Space Odyssey (Sains Antariksa & Navigasi) — 20 Misi**
     - Kalibrasi sudut roket angkasa, koordinat rasi bintang Kartesius, navigasi wahana rover Mars, dan eksplorasi stasiun orbit.
3. **8 Karakter Avatar 3D Anak Manusia & Podium Preview:**
   - Pilihan 8 karakter anak manusia berdaya inspiratif (*Kian, Sera, Raka, Nara, Dika, Bayu, Fajar, Luna*).
   - Tampilan form registrasi dilengkapi kartu potret besar, badge centang aktif, dan panggung podium 3D interaktif yang langsung merespons pilihan avatar.
4. **Siklus Hidup Misi 7 Langkah (7-Step Mission Lifecycle):**
   - *1. Story:* Skenario masalah kontekstual yang dihadapi.
   - *2. Learn:* Rahasia konsep dan tujuan pembelajaran.
   - *3. Challenge:* Arena interaktif dengan kanvas teka-teki dan panel aksi anak.
   - *4. Feedback:* Umpan balik langsung dari server (benar/salah) serta modal perayaan di tengah layar.
   - *5. Reflection:* Pertanyaan refleksi esensial untuk menguji pemahaman mendalam.
   - *6. Reward:* Penghargaan bintang (1–3 ⭐), rincian XP, dan animasi bintang berjenjang.
   - *7. Unlock:* Pembukaan node misi berikutnya di peta dunia secara otomatis.
5. **Sahabat Cerdas AI MIKO Multimodal (AI Companion):**
   - Bantuan berjenjang (*Scaffolding 3-Tier Hints*): Level 1 (Pertanyaan pemantik), Level 2 (Petunjuk fokus), Level 3 (Langkah konkret tanpa membocorkan jawaban).
   - Suara lisan (*Text-to-Speech*) berbahasa Indonesia dengan nada ramah anak laki-laki (pitch 1.25, rate 1.05) + Fallback Audio Studio ArdiNeural.
   - Posisi *dock* samping atas (*dock-side-top*) saat misi berlangsung agar tidak menutupi arena teka-teki.
   - Panduan konkret di setiap panggung tantangan ("Apa yang harus kamu lakukan?").
6. **Dashboard Siswa Terpadu:**
   - Kartu profil dengan bilah level dan progres XP visual.
   - Rekomendasi Misi Hari Ini dengan tombol akses instan.
   - Status penyelesaian 4 dunia petualangan dengan kartu neo-brutalist.
   - Bilah jejak keterampilan (*Numerasi*, *Sains*, dan *Pola & Komputasi*).
7. **Autentikasi Bersih & Gamifikasi Anti-Race Condition:**
   - Halaman Login & Registrasi berdesain Neo-Brutalist dengan footer khusus auth yang rapi tanpa duplikasi navbar, menampilkan kredit *"Website ini dibuat oleh Hendrik Wildansyah."*
   - Transaksi database bergaransi idempotensi (anti-duplikasi reward, proteksi replay abuse maksimal 3x per hari, persistensi multi-perangkat via Docker volume).


---

### 4. Aturan Kerja AI Agent (System Prompt & Operational Rules)

AI Agent wajib mematuhi 5 pilar aturan kerja berikut:

#### A. Kualitas Kode & Integritas Arsitektur (Code Quality)
- Pertahankan struktur arsitektur PHP Native MVC yang sudah ada. Jangan mencampur logika query database di dalam controller atau view template.
- Tulis kode JavaScript secara modular dengan penamaan variabel dan fungsi yang deskriptif.
- Wajib menyertakan komentar berbahasa Indonesia yang jelas pada fungsi logika inti dan kalkulasi.
- Hindari ketergantungan pustaka eksternal pihak ketiga jika fitur dapat dibangun secara native dan ringan.

#### B. Desain Ramah Anak (Child-Friendly & Accessible UI/UX)
- Ukuran tipografi terbaca jelas: teks paragraf minimal **16px–18px**, judul **22px–34px** dengan font ramah anak (`Fredoka` dan `Plus Jakarta Sans`).
- Elemen interaktif berukuran besar dengan target sentuh minimal **44px × 44px** dan sudut melengkung ramah (*rounded pill* / 16px–24px).
- Kontras warna teks dan latar belakang memenuhi standar WCAG (tidak menyilaukan mata anak).
- Tampilan harus *mobile-first*, fleksibel di layar ponsel pintar, tablet, maupun monitor desktop.
- Gunakan umpan balik visual (*micro-animations*, modal selebrasi di tengah layar, konfeti) dan umpan balik audio ceria saat aksi anak berhasil.

#### C. Keamanan Data & Ketahanan Konkurensi (Security & Concurrency Guard)
- Validasi semua input pengguna di server (*backend validation*) dan lakukan sanitasi sebelum disimpan atau dirender.
- Cegah celah DOM XSS: data teks dari API/MIKO wajib dimasukkan sebagai `textContent` atau dibuat melalui elemen DOM aman, bukan disuntikkan mentah ke `innerHTML`.
- Pertahankan proteksi transaksi reward: setiap pemberian XP dan bintang wajib dibungkus transaksi database ACID dengan *row locking* dan *idempotency key*.

#### D. Performa & Audio Ringan (Performance & Procedural Audio)
- Dilarang memuat file audio MP3/WAV besar yang membebani kuota internet anak atau memperlambat loading. Gunakan sintesis nada harmonis via Web Audio API.
- Selalu sediakan tombol mute/unmute suara yang menghormati kenyamanan pengguna.
- Optimalkan aset gambar dengan format modern, penamaan terstruktur, dan dimensi proporsional.

#### E. Analisis Akar Masalah Saat Debugging (Root Cause Analysis First)
- Jika terjadi bug atau kegagalan tes: **AI AGENT DILARANG LANGSUNG MENULIS ULANG KODE TANPA PENJELASAN.**
- Wajib memberikan analisis akar masalah (*root cause analysis*) terlebih dahulu secara runtut (gejala, letak kesalahan pada file/baris, penyebab logika gagal), baru kemudian menyajikan kode perbaikan yang teruji.
- Jalankan seluruh suite pengujian otomatis (`test_all_endpoints.php`, `test_suite.php`, `test_puzzle_validators.php`, `test_dom_xss.js`, `test_concurrency_race.php`) untuk memastikan hasil perbaikan lulus 100%.
