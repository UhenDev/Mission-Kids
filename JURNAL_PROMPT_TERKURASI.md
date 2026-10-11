# DOKUMEN LAPORAN LOMBA: JURNAL PROMPT TERKURASI
## Metodologi "Vibe Coding" Iteratif & Terstruktur pada Pengembangan Platform "KodeKids"

---

### RINGKASAN METODOLOGI
Jurnal prompt ini merepresentasikan pendekatan **Vibe Coding** yang terarah, profesional, dan berbasis rekayasa instruksi (*Prompt Engineering*). Proses pengembangan tidak dilakukan secara acak, melainkan melalui lima tahapan siklus hidup perangkat lunak (*software development lifecycle*):

1. **Tahap Perencanaan & Arsitektur (Ideation / PRD)**
2. **Tahap Pemecahan Masalah & Penanganan Masalah (Debugging)**
3. **Tahap Peningkatan Kualitas & Kinerja (Audit & Optimization)**
4. **Tahap Pemolesan Antarmuka & Interaktivitas (Finishing & Polish)**
5. **Tahap Eksplorasi Nilai Tambah & Aksesibilitas (Innovation & Accessibility)**

---

### DAFTAR 5 PROMPT TERKURASI

---

#### PROMPT 1: IDEASI & SPESIFIKASI PRODUK (PRD & ARCHITECTURE)
* **Kategori:** *Planning, Software Architecture & Design System*
* **Tujuan:** Membangun fondasi proyek yang kokoh, rapi, dan sesuai standar industri sejak baris kode pertama.
* **Teks Prompt:**
  ```text
  "Bertindaklah sebagai Senior Frontend Engineer dan UI/UX Designer. Saya ingin membuat website edukasi coding untuk anak SD kelas 4-6 bernama 'KodeKids' menggunakan HTML5, CSS3, dan Vanilla JavaScript. 

  Tolong buatkan saya struktur folder proyek (file tree) yang rapi, panduan palet warna (hex codes) yang ceria namun tidak menyakitkan mata, dan kerangka HTML dasar (boilerplate) untuk halaman utama (Landing Page). 

  Halaman utama harus mencakup header dengan logo, area hero dengan tombol 'Mulai Main', dan section penjelasan fitur dengan layout responsif."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Kualitas Teknis & Arsitektur:* Memastikan struktur berkas terorganisir (*separation of concerns*).
  - *UI/UX Ramah Anak:* Menetapkan palet warna terstandarisasi sebelum implementasi visual.

---

#### PROMPT 2: ANALISIS AKAR MASALAH & PERBAIKAN LOGIKA (DEBUGGING)
* **Kategori:** *Problem Solving & Root Cause Analysis*
* **Tujuan:** Mengatasi kendala teknis pada interaksi drag-and-drop dan kalkulasi skor kuis secara metodis.
* **Teks Prompt:**
  ```text
  "Saat saya mengimplementasikan fitur kuis 'Drag and Drop' di file kuis.js, saya menemukan masalah. Elemen blok kode berhasil ditarik (dragged), tetapi saat dijatuhkan (dropped) ke dalam zona target, elemen tersebut tidak menempel dengan presisi dan fungsi pengecekan cekJawaban() tidak terpicu (skor tidak bertambah). 

  Berikut adalah potongan kode saya saat ini: 
  [Masukkan potongan kode Anda di sini]. 

  Tolong analisis mengapa error ini terjadi dan berikan kode perbaikannya agar elemen menempel sempurna dan fungsi cek jawaban berjalan."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Pemecahan Masalah & Kehandalan Kode:* Menuntut AI memberikan penjelasan teknis akar masalah (*root cause*), bukan hanya menimpa kode tanpa pemahaman.

---

#### PROMPT 3: AUDIT TEKNIS & OPTIMASI PERFORMA (CODE QUALITY & PERFORMANCE)
* **Kategori:** *Code Refactoring, Maintainability & Performance Optimization*
* **Tujuan:** Memaksimalkan kecepatan muat halaman (*load speed*) dan kemudahan pemeliharaan kode (*maintainability*).
* **Teks Prompt:**
  ```text
  "Website 'KodeKids' sekarang sudah berjalan dengan baik, fungsionalitas kuis dan materi sudah selesai. Namun, saya ingin melakukan audit performa dan struktur kode untuk mengejar nilai maksimal pada kriteria Kualitas Teknis. 

  Tolong analisis dan berikan saya kode optimasi untuk: 
  (1) Menggabungkan dan merapikan file CSS saya menggunakan CSS Variables (Custom Properties) agar lebih mudah dikelola, dan 
  (2) Menerapkan teknik untuk mempercepat waktu muat (misalnya menambahkan atribut defer pada script JS dan lazy loading pada aset gambar)."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Standar Kualitas Teknis:* Menunjukkan penguasaan optimasi performa web modern tanpa library berat (*clean code principle*).

---

#### PROMPT 4: POLISHING & MIKRO-INTERAKSI EDUKATIF (FINISHING & DELIGHT)
* **Kategori:** *Micro-interactions, Visual Polish & Child Engagement*
* **Tujuan:** Meningkatkan pengalaman emosional anak saat bereksplorasi di website agar antarmuka terasa hidup dan menyenangkan.
* **Teks Prompt:**
  ```text
  "Kita sudah masuk ke tahap finishing untuk memoles UI/UX. Website ini untuk anak SD, jadi saya ingin transisi yang lebih interaktif dan hidup. 

  Tolong berikan saya kode CSS murni untuk menambahkan 3 hal ini: 
  (1) Efek animasi hover membesar (scale up) pada semua tombol navigasi, 
  (2) Efek animasi transisi masuk (fade-in dan slide-up) saat halaman pertama kali dimuat, dan 
  (3) Animasi bouncing perlahan pada gambar maskot robot di halaman utama agar terlihat hidup."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Keunggulan Desain UI/UX:* Pemanfaatan keyframes dan CSS transition murni untuk menciptakan umpan balik visual yang responsif.

---

#### PROMPT 5: FITUR INOVATIF & AKSESIBILITAS RAMAH ANAK (INNOVATION & INCLUSIVITY)
* **Kategori:** *Innovation, Web Accessibility (a11y) & Multimodal Interaction*
* **Tujuan:** Memberikan nilai pembeda (*unique value proposition*) yang berpihak pada keberagaman kemampuan membaca anak SD melalui suara.
* **Teks Prompt:**
  ```text
  "Untuk mengejar poin Inovasi & Kreativitas, saya ingin menambahkan fitur 'Asisten Suara Pembaca Soal'. 

  Buatkan saya fungsi JavaScript memanfaatkan Web Speech API yang memungkinkan sistem membacakan teks soal secara lisan (Text-to-Speech) dalam bahasa Indonesia ketika pengguna mengklik ikon 'Speaker'. 

  Pastikan kode ini memiliki fallback yang aman (menampilkan alert ramah) jika browser peserta didik tidak mendukung fitur tersebut."
  ```
* **Kriteria Penilaian Lomba yang Disasar:**
  - *Inovasi & Kreativitas:* Eksplorasi Web Speech API native browser untuk menghadirkan fitur aksesibilitas mutakhir secara mandiri.
  - *Resiliensi Perangkat Lunak:* Menjamin tersedianya penanganan *fallback* yang anggun (*graceful degradation*).
