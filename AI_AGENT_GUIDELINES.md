# PANDUAN PENGEMBANGAN AI AGENT (AI AGENT GUIDELINES)
## Proyek: "KodeKids" — Platform Edukasi Logika Pemrograman untuk Anak SD

Dokumen ini berfungsi sebagai acuan utama (*System Prompt & Context Compass*) bagi AI Agent (seperti Cursor, GitHub Copilot, Claude, atau ChatGPT) selama proses perancangan, pembuatan kode, *debugging*, dan optimasi platform **KodeKids**.

---

### 1. Tujuan Proyek (Goal)
Membangun **"KodeKids"**, sebuah platform web interaktif yang ramah anak untuk mengenalkan fondasi berpikir komputasional dan logika dasar pemrograman (**algoritma, *sequencing* (urutan langkah), dan *looping* (perulangan)**) kepada peserta didik Sekolah Dasar kelas 4–6 melalui pendekatan *playful learning* (bermain sambil belajar).

---

### 2. Standar Stack Teknologi (Technology Stack)
Setiap kode yang dihasilkan oleh AI Agent wajib mematuhi batasan teknologi berikut tanpa menggunakan *framework* atau *library* pihak ketiga yang tidak perlu:

- **Struktur & Konten:** **HTML5 Semantik** (`<header>`, `<nav>`, `<main>`, `<section>`, `<article>`, `<footer>`) untuk aksesibilitas dan struktur dokumen yang bersih.
- **Tampilan & UI/UX:** **CSS3 Murni (Vanilla CSS)**
  - Tata letak modern menggunakan Flexbox dan CSS Grid.
  - Skema warna terpusat menggunakan **CSS Variables / Custom Properties** (`:root`) untuk mempermudah konsistensi palet pastel ceria.
  - Animasi mikro dan transisi halus menggunakan `@keyframes` CSS murni.
- **Interaktivitas & Logika:** **Vanilla JavaScript (ES6+)**
  - Manipulasi DOM modular dan efisien.
  - HTML5 Drag and Drop API / Touch Event Handler untuk mekanisme penyusunan blok kode.
  - Browser Storage (`LocalStorage`) untuk persistensi progres belajar, skor, dan bintang secara lokal tanpa ketergantungan server rumit.

---

### 3. Arsitektur & Fitur Utama (Core Features)

1. **Halaman Utama (Landing Page):**
   - Hero section interaktif dengan ilustrasi maskot robot ceria (efek *float/bounce* halus).
   - Tombol navigasi dan aksi (*Call-to-Action*) yang berukuran besar dan mudah ditekan.
   - Skema warna pastel berenergi tinggi yang tidak melelahkan mata anak (*soft, high contrast, child-friendly*).
2. **Materi Interaktif (Story Mode):**
   - Pembelajaran konsep logika berbasis cerita petualangan (studi kasus: *"Bantu Robot Menemukan Jalan ke Baterai"*).
   - Visualisasi grafis grid/peta sederhana yang merepresentasikan instruksi langkah demi langkah (*sequencing*).
3. **Area Kuis & Playground (Drag and Drop):**
   - Area susun blok logika sederhana (Maju, Belok Kiri, Belok Kanan, Ulangi).
   - Mekanisme tarik dan lepas (*drag & drop*) yang responsif dengan umpan balik visual (*snap to zone*).
4. **Sistem Skor & Reward (Gamifikasi):**
   - Penghitungan skor bintang (1–3 bintang) berdasarkan efisiensi solusi.
   - Efek perayaan kemenangan (*confetti visual effect*) saat teka-teki logika berhasil diselesaikan.

---

### 4. Aturan Kerja AI Agent (System Prompt & Operational Rules)

AI Agent wajib mematuhi 4 pilar aturan operasional berikut:

#### A. Kualitas Kode (Code Quality)
- Tulis kode JavaScript secara modular (fungsi terpisah, *Single Responsibility Principle*).
- Wajib menyertakan komentar berbahasa Indonesia yang jelas pada fungsi logika inti dan kalkulasi.
- Hindari penggunaan sintaks usang (*deprecated*) seperti `var`, manipulasi `document.write()`, atau *inline event listener* langsung di HTML.

#### B. Desain Ramah Anak (Child-Friendly UI/UX)
- Ukuran tipografi terbaca: teks paragraf minimal **16px–18px**, judul **24px–36px**.
- Elemen interaktif ramah sentuhan: tombol navigasi memiliki *border-radius* melengkung tebal (*rounded pill / 16px+*), dengan target sentuh minimal **44px × 44px**.
- Kontras warna teks dan latar belakang memenuhi standar WCAG (mudah dibaca, tidak menyilaukan).
- Hindari antarmuka yang terlalu padat (*cluttered*); berikan ruang kosong (*whitespace*) yang lega agar anak tidak kewalahan.

#### C. Performa & Responsivitas (Performance & Mobile-First)
- Terapkan pendekatan desain *mobile-first* agar tampilan proporsional pada ponsel pintar, tablet, maupun layar laptop.
- Optimalkan aset gambar menggunakan pemuatan tunda (*native lazy loading* `loading="lazy"`).
- Struktur pemuatan skrip menggunakan atribut `defer` agar tidak memblokir proses *rendering* halaman.

#### D. Penanganan Bug & Debugging (Root Cause Analysis)
- Jika pengguna melaporkan kesalahan (*error* atau *bug*): **DILARANG LANGSUNG MEMBERIKAN KODE TANPA PENJELASAN.**
- AI Agent wajib memberikan analisis akar masalah (*root cause analysis*) terlebih dahulu secara terstruktur (mengapa masalah terjadi, baris kode pemicunya), baru kemudian menyajikan kode perbaikan yang bersih dan telah diverifikasi.
