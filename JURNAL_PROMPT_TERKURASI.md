# DOKUMEN LAPORAN LOMBA: JURNAL PROMPT TERKURASI
## Metodologi "Vibe Coding" Iteratif & Terstruktur pada Pengembangan Platform "MISSION KIDS"

---

### RINGKASAN METODOLOGI
Jurnal prompt ini merepresentasikan pendekatan **Vibe Coding** yang terarah, profesional, dan berbasis rekayasa instruksi (*Prompt Engineering*) tingkat lanjut pada platform **MISSION KIDS** (Platform Edukasi Interaktif Berbasis Misi untuk Anak SD).

Pengembangan tidak dilakukan dengan membuat kode acak sekaligus, melainkan dipandu melalui lima tahapan siklus hidup perangkat lunak (*software development lifecycle*) yang sistematis:
1. **Tahap Perencanaan & Arsitektur (Ideation / PRD & Game Engine)**
2. **Tahap Analisis Akar Masalah & Keamanan Backend (Advanced Debugging & Concurrency Guard)**
3. **Tahap Audit Antarmuka & Transformasi Visual (UI/UX Redesign & Interactive Mockup)**
4. **Tahap Pemolesan & Audio Prosedural (Finishing, Celebratory Modal & Web Audio BGM)**
5. **Tahap Inovasi & Aksesibilitas Multimodal (AI Voice Assistant & Web Speech API)**

Setiap prompt dirancang dengan konteks yang kaya (*rich context*), batasan arsitektur yang ketat (*architectural constraints*), serta kriteria penerimaan (*acceptance criteria*) yang dapat diverifikasi secara objektif melalui rangkaian tes otomatis.

---

### DAFTAR 5 PROMPT TERKURASI

---

#### PROMPT 1: IDEASI, ARSITEKTUR & SIKLUS HIDUP MISI (PRD & GAME ENGINE)
* **Kategori Lomba:** *Ide / PRD (Product Requirements Document) & Software Architecture*
* **Tujuan:** Merancang arsitektur web aplikasi edukasi anak berbasis misi dengan siklus belajar 7 tahap, pemisahan MVC native, dan engine interaksi kanvas tanpa framework berat.
* **Teks Prompt Lengkap:**
  ```text
  "Bertindaklah sebagai Senior Full-Stack Engineer, Educational Experience Designer, dan Software Architect. 
  Saya ingin membangun platform edukasi interaktif untuk anak SD (kelas 4-6) bernama 'MISSION KIDS' menggunakan PHP Native (MVC), Vanilla CSS, dan Vanilla JavaScript (ES6+), tanpa framework besar seperti Laravel atau React agar performanya instan dan mudah dijalankan di shared hosting.

  Konsep utamanya bukan kuis pilihan ganda biasa atau chatbot generik, melainkan 'Mission-Based Learning':
  1. Rancang 3 Dunia Petualangan: Number City (Numerasi & Belanja), Discovery Lab (Sains & Alam), dan Thinking Lab (Computational Thinking & Algoritma).
  2. Implementasikan Siklus Hidup Misi 7 Langkah (7-Step Lifecycle): Story -> Learn -> Challenge -> Feedback -> Reflection -> Reward -> Unlock.
  3. Buat Game Engine di sisi klien (MissionEngine.js & InteractionHandler.js) yang dapat memuat berbagai jenis kanvas teka-teki interaktif (slider fotosintesis tanaman, susun balok angka, rute grid pergerakan robot Botty).
  4. Rancang skema database MariaDB 10.4 dengan fallback SQLite, mendukung pelacakan progres misi, skor XP, bintang, dan medali pencapaian.

  Tolong sajikan struktur folder proyek yang rapi, rancangan tabel database, dan implementasi dasar siklus hidup misi yang modular."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Kualitas Teknis & Arsitektur:* Arsitektur MVC bersih (*separation of concerns*) dan game engine berbasis Vanilla JS yang modular.
  - *Kreativitas Edukasi:* Mengganti kuis statis dengan 7 siklus pembelajaran aktif yang memicu daya nalar anak.
* **Hasil Nyata yang Dicapai:**
  - Terciptanya struktur proyek PHP MVC bersih dengan 3 dunia, 9 misi interaktif, dan simulator teka-teki kanvas.

---

#### PROMPT 2: AUDIT KONKURENSI & REMEDIASI RACE CONDITION (DEBUGGING & SECURITY)
* **Kategori Lomba:** *Debugging, Database Concurrency & Application Security*
* **Tujuan:** Menutup celah konkurensi reward ganda (*race condition*) pada endpoint penyelesaian misi menggunakan transaksi database ACID dan kunci idempotensi database.
* **Teks Prompt Lengkap:**
  ```text
  "Bertindaklah sebagai Senior Database Engineer dan Application Security Specialist. 
  Audit integritas pada MISSION KIDS menemukan potensi race condition pada endpoint API complete_mission. Jika dua request penyelesaian misi dikirimkan bersamaan (misalnya anak menekan tombol berulang kali dengan cepat atau via skrip paralel), dilaporkan terjadi celah:
  1. Reward XP first-clear dan bonus first-try dapat digandakan.
  2. Bonus refleksi dapat diklaim lebih dari satu kali.
  3. Batas latihan ulang (replay reward maks 3x/hari) dapat dilewati.
  4. Terjadi 'lost update' pada total XP profil pengguna.

  Tolong lakukan audit kode pada MissionProgressService.php, GamificationService.php, dan skema database. Berikan analisis akar masalah (root cause analysis) mengapa race condition ini bisa terjadi.
  Kemudian, terapkan perbaikan tingkat enterprise:
  - Gunakan transaksi ACID ketat (BEGIN TRANSACTION, COMMIT, ROLLBACK).
  - Terapkan row-level locking (SELECT ... FOR UPDATE) pada profil dan progres misi.
  - Tambahkan UNIQUE constraint pada database xp_transactions sebagai perlindungan absolut di level basis data.
  - Buat skrip automated test multi-proses (test_concurrency_race.php) untuk membuktikan secara empiris bahwa request konkuren paralel 100% aman dan tidak pernah melipatgandakan reward."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Pemecahan Masalah Kompleks (Debugging):* Analisis akar masalah mendalam pada tingkat konkurensi transaksi database.
  - *Kehandalan & Keamanan Sistem:* Menerapkan prinsip ACID dan idempotensi tanpa merusak pengalaman bermain anak.
* **Hasil Nyata yang Dicapai:**
  - Seluruh 11 pengujian konkurensi paralel multi-proses pada `test_concurrency_race.php` lulus 100% (*zero double reward, consistent profile XP*).

---

#### PROMPT 3: REDESAIN UI INTERAKTIF BERDASARKAN MOCKUP (AUDIT & UI/UX REDESIGN)
* **Kategori Lomba:** *Audit, UI/UX Design System & Interactive Redesign*
* **Tujuan:** Mentransformasi tampilan antarmuka generik menjadi antarmuka ramah anak berstandar tinggi yang modern, ceria, dan konsisten dengan referensi mockup desain visual 3D.
* **Teks Prompt Lengkap:**
  ```text
  "Bertindaklah sebagai Senior UI/UX Designer dan Lead Frontend Engineer untuk platform edukasi anak SD.
  Saya memiliki referensi desain mockup UI interaktif untuk MISSION KIDS (terdiri dari Landing Page desktop/mobile, Halaman Login split-card, Halaman Register dengan avatar picker, dan Dashboard pengguna). Saya ingin Anda merombak antarmuka saat ini agar persis dan hidup seperti desain tersebut:

  1. Landing Page:
     - Hero split 2 kolom: Sisi kiri headline besar 'Petualangan Seru untuk Anak Hebat!', subteks, dan tombol CTA pil; sisi kanan ilustrasi 3D Pixar karakter anak astronot dan MIKO dengan floating badge 'Belajar Sambil Bermain!'.
     - Section 'Fitur Unggulan' dengan 4 kartu pilar edukasi (Sains, Logika, Pemrograman, Reward) berikon lingkaran pastel.
     - Section '3 Dunia Petualangan' menggunakan thumbnail gambar 3D (Number City, Discovery Lab, Thinking Lab).
  2. Halaman Login & Registrasi:
     - Terapkan tata letak split-card 2 kolom: Sisi kiri banner ilustrasi visual 3D ceria, sisi kanan formulir dengan input berikon prefix (user, lock, eye password toggle).
     - Pada form register, sediakan grid 8 karakter avatar lucu (Kucing, Beruang, Rubah, Burung Hantu, Astronot, Penemu, Botty, Dino).
  3. Dashboard Siswa Terpadu:
     - Baris atas: Kartu profil dengan meteran level/XP dan kartu Rekomendasi Misi Hari Ini berwarna emas dengan tombol 'Mulai Misi ➔'.
     - Baris bawah: Grid 3 dunia petualangan dengan thumbnail dan indikator penyelesaian, serta panel Jejak Keterampilan Belajar (Numerasi, Sains, Komputasi).

  Gunakan Vanilla CSS terstruktur tanpa Tailwind, buat aset gambar 3D yang relevan, dan pastikan seluruh 33 endpoint test tetap lulus."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Kualitas Desain & Estetika Visual:* Antarmuka kelas dunia (*delightful & modern*), jauh dari kesan template AI generik.
  - *Konsistensi UI/UX:* Harmonisasi palet warna, tipografi, dan tata letak responsif desktop-mobile.
* **Hasil Nyata yang Dicapai:**
  - Berhasil membuat aset gambar 3D Pixar (*hero.jpg*, *auth-banner.jpg*, *number-city.jpg*, dll.), merombak 4 halaman utama, dan mempertahankan kelulusan tes 100%.

---

#### PROMPT 4: FINISHING, MODAL SELEBRASI & MUSIK PROSEDURAL (POLISH & AUDIO EXPERIENCE)
* **Kategori Lomba:** *Finishing, User Delight, Micro-Animations & Audio Ambient*
* **Tujuan:** Menghadirkan umpan balik perayaan yang mendalam saat anak berhasil memecahkan teka-teki serta musik latar adaptif tanpa membebani kuota dengan file MP3 besar.
* **Teks Prompt Lengkap:**
  ```text
  "Kita masuk ke tahap finishing untuk menyempurnakan kenyamanan bermain anak di MISSION KIDS:
  1. Alert Berhasil di Tengah Layar:
     Ketika anak berhasil memecahkan teka-teki tebakan atau susunan balok logika, jangan hanya menampilkan kotak teks kecil di pojok. Tampilkan modal selebrasi di tengah layar (Centered Celebratory Modal) dengan backdrop blur, pop-in animation, ucapan selamat ceria, hamburan partikel konfeti (CelebrationEffects.js), dan tombol besar 'Lanjut ke Refleksi & Hadiah ➔'.
  2. Musik Latar Ceria (BGM) saat Misi:
     Agar saat menjalankan misi suasana tidak sepi, tambahkan musik petualangan. Syarat mutlak: JANGAN gunakan file MP3/WAV besar yang membebani loading server! Rancang mesin synthesizer audio prosedural menggunakan native Web Audio API (SoundEffects.js) yang menghasilkan melodi pentatonik marimba lembut dan ketukan bass harmonis.
  3. Kontrol Cepat & Reposisi MIKO:
     - Tambahkan tombol toggle '🎵 Musik: Nyala / Mati' di topbar misi.
     - Posisikan avatar MIKO di dock samping atas (dock-side-top) saat misi berlangsung dengan gelembung pesan mengarah ke bawah agar tidak menutupi area kanvas tantangan.

  Pastikan semua kode bekerja 100% offline dan lolos uji DOM XSS maupun endpoint."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Mikro-Interaksi & Emosionalitas Desain:* Memberikan *delight* maksimal pada momen kemenangan anak (*positive reinforcement*).
  - *Efisiensi Kinerja & Kreativitas Rekayasa:* Menghasilkan musik latar ceria tanpa mengunduh aset audio eksternal (*zero-byte audio storage*).
* **Hasil Nyata yang Dicapai:**
  - Modal perayaan tengah layar aktif dengan konfeti, musik synthesizer Web Audio API berjalan mulus dengan tombol mute/unmute, dan MIKO mengapung elegan di kanan atas.

---

#### PROMPT 5: FITUR ASISTEN SUARA MIKO & AKSESIBILITAS RAMAH ANAK (INNOVATION & A11Y)
* **Kategori Lomba:** *Inovasi, Aksesibilitas Web (a11y) & Multimodal Interaction*
* **Tujuan:** Menghadirkan inovasi asisten suara AI (MIKO Companion) yang dapat berbicara lisan dalam bahasa Indonesia menggunakan Web Speech API native dan aman dari celah keamanan DOM XSS.
* **Teks Prompt Lengkap:**
  ```text
  "Untuk mengejar poin maksimal pada kriteria Inovasi & Aksesibilitas, saya ingin anak-anak yang belum lancar membaca tetap dapat menikmati MISSION KIDS dengan bantuan suara:
  1. Buatkan fungsi pada MikoCompanion.js yang memanfaatkan native Web Speech API (SpeechSynthesisUtterance) agar MIKO dapat berbicara lisan (Text-to-Speech) dalam bahasa Indonesia ('id-ID') dengan nada ceria anak-anak (pitch 1.25).
  2. MIKO harus otomatis berbicara saat memberikan petunjuk bertahap (scaffolding level 1-3) dan saat mengucapkan selamat atas keberhasilan misi.
  3. Tambahkan tombol ikon speaker '🔊' di header bubble MIKO agar anak dapat memutar ulang suara MIKO kapan saja.
  4. Aspek Keamanan DOM XSS & Fallback:
     - Pastikan teks pesan yang diucapkan dan dirender ke DOM disanitasi secara ketat menggunakan pembuatan text node aman (bukan innerHTML rentan).
     - Sediakan fallback senyap yang anggun jika browser perangkat tidak mendukung Web Speech API atau jika suara dimatikan (muted).
     - Buat pengujian otomatis (test_dom_xss.js) untuk membuktikan bahwa payload skrip jahat (<script>alert(1)</script>) tidak akan pernah tereksekusi."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Inovasi & Nilai Tambah Edukasi:* Menghubungkan interaktivitas visual dengan kecerdasan multimodal suara (*dual-coding theory* dalam psikologi belajar anak).
  - *Aksesibilitas & Keamanan:* Membantu anak dengan kesulitan membaca teks panjang sekaligus menjaga standar keamanan web modern.
* **Hasil Nyata yang Dicapai:**
  - MIKO dapat berbicara lisan dengan intonasi ramah anak, tombol replay suara 🔊 tersedia, dan `test_dom_xss.js` membuktikan keamanan sanitasi 100% lulus (*PASS*).

---

### KESIMPULAN HASIL VIBE CODING
Melalui 5 prompt terkurasi di atas, platform **MISSION KIDS** berevolusi dari ide dasar menjadi aplikasi edukasi anak yang kokoh, memiliki sistem keamanan database setara perbankan (*ACID anti-race condition*), estetika visual 3D modern ramah anak, efek audio prosedural mandiri, dan asisten suara pintar yang inklusif. 

Seluruh 109 pengujian otomatis pada sistem (*Endpoint, Unit Logic, Puzzle Validation, Concurrency, dan DOM XSS*) terverifikasi **100% LULUS (PASS)**.
