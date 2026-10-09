# JURNAL VIBE CODING — MISSION KIDS
## 5 Prompt Paling Representatif & Refleksi Pengembangan Berkelanjutan

Dokumen ini mendokumentasikan 5 prompt terbaik yang merepresentasikan evolusi pembangunan platform **MISSION KIDS**, mulai dari formulasi ide & arsitektur, implementasi sistem misi, penanganan bug & audit teknis, hingga penghalusan antarmuka responsif ramah anak (*playful precision*).

---

### 1. Kategori 1: Ide / PRD / Arsitektur Awal
*Prompt yang meletakkan fondasi filosofis bahwa anak belajar dengan aksi nyata, bukan sekadar kuis atau chatbot.*

- **Waktu:** 2026-10-05 11:56:04+07:00
- **Teks Prompt:**
```text
# MASTER PROMPT — MISSION KIDS
## Interactive Mission-Based Learning Platform for Kids
Kamu bertindak sebagai Senior Full-Stack Developer, UI/UX Designer, Educational Experience Designer, QA Engineer, dan AI Coding Agent untuk membangun sebuah website edukasi anak bernama MISSION KIDS.
Website ini bukan sekadar website quiz, bukan LMS biasa, bukan chatbot AI, dan bukan game murni.
Konsep utamanya: Anak belajar dengan menghadapi sebuah misi atau masalah, mengeksplorasi informasi, melakukan aktivitas interaktif, memecahkan tantangan, mendapatkan feedback, dan memahami kembali apa yang dipelajari.
AI digunakan sebagai pendamping belajar (MIKO) yang memberikan petunjuk bertahap (scaffolding), bukan mesin pemberi jawaban.
```
- **Alasan Pemilihan:** Prompt ini mendefinisikan *core vision* yang kuat dan anti-mainstream (menolak tren quiz generik atau chatbot terbuka untuk anak usia dini). Menghasilkan PRD lengkap, arsitektur MVC native bebas bloating, serta design system visual ramah anak.
- **Hasil yang Dicapai:**
  - Terciptanya 10 dokumen spesifikasi di `/docs`.
  - Struktur database MariaDB & SQLite fallback dengan skema 3 dunia (*Number City*, *Discovery Lab*, *Thinking Lab*), 9 misi terintegrasi, dan 5 medali pencapaian.

---

### 2. Kategori 2: Implementasi / Development Fitur
*Prompt eksekusi pembangunan tumpukan penuh (full-stack execution) sekali jalan.*

- **Waktu:** 2026-10-05 12:02:32+07:00
- **Teks Prompt:**
```text
lanjuttt
```
- **Alasan Pemilihan:** Meskipun singkat, prompt ini menandai kepercayaan penuh (*approval to proceed*) dari Product Owner setelah fase analisis awal selesai. Agen AI secara mandiri membangun seluruh subsistem secara terpadu tanpa fragmentasi.
- **Hasil yang Dicapai:**
  - Layanan backend lengkap: `AuthService`, `GamificationService`, `MissionProgressService`, dan `MikoAiService` (dengan fallback deterministik 100% offline).
  - Frontend Client-Side Engine (`MissionEngine.js`, `InteractionHandler.js`, `MikoCompanion.js`).
  - Simulator interaktif SVG (*Tanaman Layu*, *Misteri Bayangan*, *Siklus Air*, *Toko Kue*, *Robot Pulang*).
  - 17/17 uji otomatis unit dan integrasi berhasil lulus dalam satu siklus pengujian.

---

### 3. Kategori 3: Debugging / Refactoring / Penyelamatan Sistem
*Penanganan isu koneksi database dan error output sesi saat eksekusi CLI.*

- **Waktu:** 2026-10-05 12:12:10+07:00 (Internal Trajectory Debugging)
- **Teks Prompt / Skenario Debug:**
```text
Investigasi kegagalan koneksi MySQL 'Connection refused' pada port 3306 lokal dan peringatan PHP 'session_regenerate_id(): Cannot regenerate session id - session is not active' saat menjalankan test suite di terminal.
```
- **Alasan Pemilihan:** Debugging ini menunjukkan keandalan tingkat enterprise: alih-alih panik atau menyerah, agen mengidentifikasi bahwa MariaDB lokal belum berjalan di latar belakang, menjalankan daemon `mysqld.exe`, memigrasikan skema data, serta membungkus fungsi sesi dengan `session_status() === PHP_SESSION_ACTIVE` dan `!headers_sent()`.
- **Hasil yang Dicapai:**
  - Koneksi MariaDB port 3306 pulih seketika dan skema 9 misi tersinkronisasi.
  - Test suite berjalan bersih tanpa peringatan runtime sama sekali (*zero-warning clean CLI output*).

---

### 4. Kategori 4: Polish / UI Finishing / Edge Case
*Optimasi ergonomi ponsel, tombol jempol ramah anak, dan pencegahan overflow teks.*

- **Waktu:** 2026-10-05 12:20:08+07:00
- **Teks Prompt:**
```text
buat agar responsive mobile
```
- **Alasan Pemilihan:** Anak-anak zaman sekarang sering mengakses materi pembelajaran dari tablet atau ponsel pintar orang tua mereka. Mengubah platform edukasi desktop menjadi pengalaman ponsel sentuh yang alami (*touch-first*) membutuhkan detail tinggi, seperti ukuran target sentuh minimal 44px, navigasi jempol bawah (*sticky bottom bar*), dan pencegahan text wrapping pada bilah navigasi sempit.
- **Hasil yang Dicapai:**
  - Navigasi bawah ponsel (`.mobile-bottom-nav`) dengan ikon besar untuk Markas, Misi, Medali, dan Jejak Belajar.
  - Dermaga MIKO melayang diposisikan tepat di atas bilah navigasi ponsel tanpa menghalangi tombol interaksi.
  - Ukuran grid simulasi dan SVG dihitung secara adaptif menggunakan `clamp()` dan satuan viewport.

---

### 5. Kategori 5: Prompt Bebas Paling Keren / Identitas Budaya & Edukasi
*Standardisasi bahasa nasional yang konsisten, hangat, dan ramah anak usia sekolah dasar.*

- **Waktu:** 2026-10-05 12:33:30+07:00
- **Teks Prompt:**
```text
gunakan bahasa indonesia semuanya
```
- **Alasan Pemilihan:** Prompt ini menyempurnakan jiwa dari produk. Website edukasi anak SD di Indonesia harus terasa akrab, inklusif, dan tidak mengintimidasi dengan istilah asing yang kaku. Seluruh copywriting diubah menjadi hangat dan mendidik, seperti *"Petualangan Misimu Dimulai di Sini"*, *"Markas"*, *"Jejak Belajar"*, dan dialog MIKO yang menyemangati.
- **Hasil yang Dicapai:**
  - 100% copywriting dalam Bahasa Indonesia yang baku namun bersahabat (*warm, encouraging pedagogical tone*).
  - Tombol aksi navigasi otomatis berganti menjadi label ringkas `"Daftar ✨"` pada layar sempit, mencegah masalah tata letak tombol keluar garis.
  - Implementasi cache-busting `?v=2.0` pada tag stylesheet untuk pembaruan instan di perangkat ponsel.

---

## Refleksi & Prinsip Kunci Vibe Coding
1. **Disiplin Dokumentasi Aktif:** Menjaga sinkronisasi antara kode sumber, dokumen spesifikasi teknis, serta catatan log prompt dan debugging memastikan proyek tetap rapi dan mudah dirawat.
2. **Pedagogi di Atas Kecepatan Instan:** AI pendamping belajar (MIKO) berhasil dibatasi dengan aturan tegas: memberikan petunjuk bertahap (*scaffolding* level 1 hingga 3) dan menolak memberi jawaban instan agar daya nalar anak tetap terasah.
3. **Resiliensi Tingkat Tinggi:** Aplikasi tetap berfungsi 100% baik saat terkoneksi MariaDB maupun saat beralih otomatis ke SQLite cadangan, serta tetap cerdas memberikan bantuan meski dalam kondisi tanpa internet (*offline deterministic fallback*).
