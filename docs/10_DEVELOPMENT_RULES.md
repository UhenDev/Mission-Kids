# 10. ATURAN PENGEMBANGAN & STANDAR KUALITAS — MISSION KIDS

## 1. Standar & Konvensi Penulisan Kode

### 1.1 Backend PHP
- **Versi Standar:** Modern PHP 8.2+ dengan pengetikan ketat di setiap file (`declare(strict_types=1);`).
- **Konvensi Penamaan:**
  - Nama Kelas: `PascalCase` (contoh: `MissionProgressService`, `AuthController`, `Database`).
  - Nama Metode & Variabel: `camelCase` (contoh: `getMissionById()`, `$currentLevel`, `$isAuthPage`).
  - Nama Tabel & Kolom Database: `snake_case` (contoh: `user_id`, `created_at`, `avatar_id`).
  - Konstanta: `UPPER_SNAKE_CASE` (contoh: `DEFAULT_AVATAR`, `MAX_HINT_LEVEL`).
- **Arsitektur:** Pemisahan Tanggung Jawab (*Separation of Concerns*). Controller menangani permintaan HTTP dan alur perutean, Service menangani logika bisnis dan komputasi, Helper menangani utilitas keamanan, dan View merender antarmuka HTML semantik.
- **Sanitasi Keluaran:** Dilarang keras mencetak variabel `$_POST` atau hasil basis data mentah secara langsung. Selalu bungkus dengan fungsi pembantu `e()`.

### 1.2 CSS & Sistem Desain
- **Struktur:** File CSS modular terpisah (`design-system.css`, `components.css`, `missions.css`, `worlds.css`).
- **Variabel Desain:** Selalu gunakan token `--color-*`, `--space-*`, dan `--radius-*`. Hindari penulisan kode warna heksadesimal sembarangan di luar token sistem desain.
- **Satuan Responsif:** Gunakan `rem` untuk ukuran huruf dan spasi, `px` untuk ketebalan garis batas (*border*), serta `%` / `fr` / `clamp()` untuk tata letak grid cairan yang fleksibel.
- **Target Sentuh:** Ukuran minimum target sentuh interaktif adalah `48px` x `48px` untuk kenyamanan jari anak-anak.

### 1.3 Frontend JavaScript
- **Standar:** Vanilla ES6+ murni (Classes, Modules, Template Literals, Async/Await, dan DOM API asli).
- **Tanpa Framework Berat:** Tidak menggunakan library frontend yang membengkakkan ukuran bundle (seperti React atau Vue berlebihan). Performa browser bawaan menjamin waktu muat instan pada perangkat berdaya rendah di lingkungan sekolah.
- **Kekekalan Status (State Management):** Perubahan status permainan harus melalui aksi engine yang eksplisit untuk menjaga perilaku riwayat dan pengulangan langkah yang dapat diprediksi.

---

## 2. Daftar Periksa Kontrol Kualitas Visual (Visual Quality Control / VQC)

Sebelum suatu tampilan atau layar dinyatakan selesai:
- [ ] **Nuansa Petualangan Edukasi:** Apakah layar ini terasa hangat, ramah anak, dan memikat seperti game petualangan edukasi, atau terlihat kaku seperti dasbor admin korporat? (Jika terlihat seperti dasbor korporat, segera lakukan desain ulang).
- [ ] **Ruang Bernapas & Keseimbangan (Whitespace):** Apakah terdapat jarak sela yang nyaman antar elemen tanpa terasa berdesakan atau meninggalkan ruang kosong yang canggung?
- [ ] **Umpan Balik Taktil 3D:** Apakah tombol-tombol interaktif memiliki efek tekan `:active` yang responsif dan nyata?
- [ ] **Kontras & Keterbacaan:** Apakah teks kontras dan mudah dibaca pada latar belakang terang maupun berwarna?
- [ ] **Tanpa Gambar Placeholder:** Apakah seluruh karakter, ikon, dan ilustrasi menggunakan aset visual asli yang tajam dan terverifikasi?
- [ ] **Footer Terpisah dari Navbar:** Apakah footer autentikasi bersih dari menu tiruan navbar dan menampilkan kredit pembuat: *"Website ini dibuat oleh Hendrik Wildansyah."*?
- [ ] **Pilihan Karakter Menjolok:** Apakah pemilihan avatar menampilkan kartu potret yang besar dan jelas dengan indikator terpilih yang tegas?

---

## 3. Definisi Selesai (Definition of Done / DoD)

Suatu fitur atau tugas dianggap **Selesai (Done)** hanya jika:
1. **Kebenaran Fungsional:** Seluruh alur utama dan skenario batas berjalan sesuai dokumen spesifikasi (PRD).
2. **Kesesuaian Desain:** Mematuhi 100% token dan panduan Sistem Desain MISSION KIDS.
3. **Ketahanan Sistem:** Mampu menangani kegagalan jaringan, masukan tidak valid, dan situasi saat layanan AI eksternal offline dengan fallback lokal mulus.
4. **Keamanan Teruji:** Menggunakan parameterized PDO queries, seluruh output dibersihkan dengan `e()`, dan token CSRF divalidasi.
5. **Integritas Responsif:** Teruji dan tampil proporsional pada Ponsel (360px–480px), Tablet (768px), dan Desktop (1200px+).
6. **Pengujian Otomatis Lolos:** Seluruh skrip verifikasi otomatis di folder `tests/` berjalan sukses dengan status **100% PASS**.
