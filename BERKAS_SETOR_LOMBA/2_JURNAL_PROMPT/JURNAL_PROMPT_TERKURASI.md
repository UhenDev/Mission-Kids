# DOKUMEN LAPORAN LOMBA: JURNAL PROMPT TERKURASI
## Metodologi "Vibe Coding" Iteratif & Terstruktur pada Pengembangan Platform "MISSION KIDS"
### Disusun oleh: Hendrik Wildansyah (Lead Developer & UI/UX Designer)
> *"Website ini dibuat oleh Hendrik Wildansyah."*

---

### RINGKASAN METODOLOGI
Jurnal prompt ini merepresentasikan pendekatan **Vibe Coding** yang terarah, profesional, dan berbasis rekayasa instruksi (*Prompt Engineering*) tingkat lanjut pada platform **MISSION KIDS** (Platform Edukasi Interaktif Berbasis Misi untuk Anak SD).

Pengembangan tidak dilakukan dengan membuat kode acak sekaligus, melainkan dipandu melalui lima tahapan siklus hidup perangkat lunak (*software development lifecycle*) yang sistematis:
1. **Tahap Perencanaan & Arsitektur (Ideation / PRD & Game Engine)**
2. **Tahap Analisis Akar Masalah & Keamanan Backend (Advanced Debugging & Concurrency Guard)**
3. **Tahap Transformasi Antarmuka & Karakter (Neo-Brutalist UI/UX, 8 Avatar 3D & Auth Footer Redesign)**
4. **Tahap Pemolesan & Audio Prosedural (Finishing, Celebratory Modal & Web Audio BGM)**
5. **Tahap Inovasi Multimodal & Aksesibilitas (AI MIKO Indonesian Voice TTS & Audio Scaffolding)**

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
  Saya ingin membangun platform edukasi interaktif untuk anak SD (kelas 4-6) bernama 'MISSION KIDS' menggunakan PHP Native (MVC), Vanilla CSS, dan Vanilla JavaScript (ES6+), tanpa framework besar seperti Laravel atau React agar performanya instan dan mudah dijalankan di shared hosting maupun Docker VPS.

  Konsep utamanya bukan kuis pilihan ganda biasa atau chatbot generik, melainkan 'Mission-Based Learning':
  1. Rancang 4 Dunia Petualangan: Number City (Numerasi & Belanja), Discovery Lab (Sains & Alam), Thinking Lab (Computational Thinking & Algoritma), dan Space Odyssey (Sains Antariksa).
  2. Implementasikan Siklus Hidup Misi 7 Langkah (7-Step Lifecycle): Story -> Learn -> Challenge -> Feedback -> Reflection -> Reward -> Unlock.
  3. Buat Game Engine di sisi klien (MissionEngine.js & InteractionHandler.js) yang dapat memuat berbagai jenis kanvas teka-teki interaktif (slider fotosintesis tanaman, susun balok angka, rute grid pergerakan robot Botty, navigasi rover Mars).
  4. Rancang skema database SQLite berkinerja tinggi dengan kemampuan migrasi ke MariaDB/MySQL, mendukung pelacakan progres misi, skor XP, bintang, dan medali pencapaian.

  Tolong sajikan struktur folder proyek yang rapi, rancangan tabel database, dan implementasi dasar siklus hidup misi yang modular."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Kualitas Teknis & Arsitektur:* Arsitektur MVC bersih (*separation of concerns*) dan game engine berbasis Vanilla JS yang modular.
  - *Kreativitas Edukasi:* Mengganti kuis statis dengan 7 siklus pembelajaran aktif yang memicu daya nalar anak.
* **Hasil Nyata yang Dicapai:**
  - Terciptanya struktur proyek PHP MVC bersih dengan 4 dunia petualangan, 80 misi interaktif berjenjang, dan simulator teka-teki kanvas.

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

#### PROMPT 3: REDESAIN NEO-BRUTALIST UI, 8 AVATAR 3D & AUTH FOOTER (AUDIT & UI/UX REDESIGN)
* **Kategori Lomba:** *Audit, UI/UX Design System & Gamified Redesign*
* **Tujuan:** Mentransformasi tampilan antarmuka menjadi Modern Playful Gamified UI berkarakter Neo-Brutalist Soft UI, 8 karakter avatar 3D anak manusia dengan panggung preview podium 3D, serta footer auth khusus yang rapi tanpa duplikasi navbar.
* **Teks Prompt Lengkap:**
  ```text
  "Bertindaklah sebagai Senior UI/UX Designer dan Lead Frontend Engineer untuk platform edukasi anak SD.
  Saya ingin Anda merombak antarmuka MISSION KIDS menjadi Modern Playful Gamified UI dengan gaya Neo-Brutalist Cards yang ramah anak:
  
  1. Karakter Avatar 3D Anak Manusia:
     - Sediakan 8 karakter avatar anak 3D (Kian Si Penjelajah, Sera Si Ilmuwan, Raka Si Atlet, Nara Si Seniman, Dika Si Petualang, Bayu Si Teknolog, Fajar Si Penemu, Luna Si Pemimpin) dengan ilustrasi SVG berkualitas tinggi.
     - Pada form registrasi, buat tampilan kartu potret besar dengan role pill badge, badge centang aktif saat terpilih, dan panggung 'Podium 3D Preview' yang langsung merespons pilihan anak secara instan.
  2. Halaman Login & Registrasi:
     - Terapkan kartu Neo-Brutalist dengan border tegas 2.5px, sudut melengkung 24px-28px, dan hard shadow taktil 0 6px 0.
     - Buat tombol submit 3D yang empuk dan tertekan ke bawah saat diklik.
  3. Redesain Footer Halaman Auth:
     - Jangan menyalin menu atau tombol navbar ke dalam footer login dan register.
     - Buat auth-footer khusus yang sederhana, bersih, proporsional, dan mencantumkan kredit resmi: 'Website ini dibuat oleh Hendrik Wildansyah.'
  4. Pastikan tata letak 100% responsif mobile tanpa horizontal overflow."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Kualitas Desain & Estetika Visual:* Antarmuka kelas dunia bergaya *Playful Neo-Brutalist* yang memikat anak sejak pandangan pertama.
  - *Konsistensi UI/UX & Ergonomi:* Penataan elemen formulir yang rapi, tombol sentuh jempol bersahabat, dan panggung preview avatar yang hidup.
* **Hasil Nyata yang Dicapai:**
  - Terciptanya 8 avatar karakter 3D dinamis, sistem kartu neo-brutalist di seluruh halaman, footer auth bersih dengan kredit Hendrik Wildansyah, serta lolos verifikasi 42/42 assertions pada `test_redesign_verification.php` dan 24/24 pada `test_login_page.php`.

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

#### PROMPT 5: ASISTEN SUARA MIKO BAHASA INDONESIA & AKSESIBILITAS (INNOVATION & A11Y)
* **Kategori Lomba:** *Inovasi, Aksesibilitas Web (a11y) & Multimodal Interaction*
* **Tujuan:** Menghadirkan inovasi asisten suara AI (MIKO Companion) yang dapat berbicara lisan dalam bahasa Indonesia menggunakan Web Speech API suara anak laki-laki dan aman dari celah keamanan DOM XSS.
* **Teks Prompt Lengkap:**
  ```text
  "Untuk mengejar poin maksimal pada kriteria Inovasi & Aksesibilitas, saya ingin anak-anak yang belum lancar membaca tetap dapat menikmati MISSION KIDS dengan bantuan suara:
  1. Buatkan fungsi pada MikoCompanion.js yang memanfaatkan native Web Speech API (SpeechSynthesisUtterance) agar MIKO dapat berbicara lisan (Text-to-Speech) dalam bahasa Indonesia ('id-ID') dengan karakteristik suara anak laki-laki yang ceria dan ramah (pitch: 1.25, rate: 1.05).
  2. Sediakan fallback klip audio studio ramah anak (id-ID-ArdiNeural) di public/audio/miko/ untuk memastikan dukungan penuh pada browser yang tidak memiliki sintesis suara lokal.
  3. MIKO harus otomatis menyapa saat anak masuk ke tantangan ('Apa yang harus kamu lakukan?') dan saat memberikan petunjuk bertahap (scaffolding level 1-3).
  4. Tambahkan tombol ikon speaker '🔊 Dengar Suara' di header bubble MIKO dan kartu instruksi tantangan.
  5. Aspek Keamanan DOM XSS & Fallback:
     - Teks pesan yang diucapkan dan dirender ke DOM wajib disanitasi secara ketat menggunakan pembuatan text node aman (bukan innerHTML rentan).
     - Buat pengujian otomatis (test_dom_xss.js dan test_revisions_all.php) untuk membuktikan integritas sanitasi dan konsistensi suara."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Inovasi & Nilai Tambah Edukasi:* Menghubungkan interaktivitas visual dengan kecerdasan multimodal suara (*dual-coding theory* dalam psikologi belajar anak).
  - *Aksesibilitas & Keamanan:* Membantu anak dengan kesulitan membaca teks panjang sekaligus menjaga standar keamanan web modern.
* **Hasil Nyata yang Dicapai:**
  - MIKO dapat berbicara lisan dengan suara anak laki-laki Indonesia yang natural, tombol replay suara 🔊 tersedia di semua panggung tantangan, dan seluruh pengujian suara serta DOM XSS lulus 100% (*PASS*).

---

### KESIMPULAN HASIL VIBE CODING
Melalui 5 prompt terkurasi di atas, platform **MISSION KIDS** yang dirancang dan dibangun oleh **Hendrik Wildansyah** berevolusi dari ide dasar menjadi aplikasi edukasi anak kelas dunia. Platform ini memiliki sistem keamanan database setara perbankan (*ACID anti-race condition*), estetika visual modern *Neo-Brutalist Soft UI*, 8 karakter avatar 3D anak manusia, musik prosedural mandiri, dan asisten suara pintar yang inklusif.

Seluruh rangkaian pengujian otomatis pada sistem (*Redesign Verification, Auth Layout, Dynamic Avatars, Endpoint Flow, Unit Logic, Puzzle Validation, Concurrency Race, dan DOM XSS*) terverifikasi **100% LULUS (PASS)**.
