# 09. PENGUJIAN & JAMINAN KUALITAS (QA) — MISSION KIDS

## 1. Filosofi Pengujian

Setiap komponen dari platform **MISSION KIDS** melewati verifikasi ketat untuk menjamin siswa Sekolah Dasar mendapatkan pengalaman belajar yang lancar, menyenangkan, dan bebas dari kendala teknis. Pengujian mencakup kebenaran fungsional, integritas tata letak responsif, ergonomi layar sentuh, dan ketahanan sistem saat terjadi galat jaringan.

---

## 2. Matriks Eksekusi Uji Fungsional

| ID Pengujian | Modul | Skenario | Hasil yang Diharapkan | Kriteria Lolos |
| :--- | :--- | :--- | :--- | :--- |
| **TC-AUTH-01** | Autentikasi | Registrasi siswa baru dengan username & password valid | Akun terdaftar di database, auto-login, dialihkan ke Beranda Siswa | Sesi terbentuk, profil terinisialisasi |
| **TC-AUTH-02** | Autentikasi | Registrasi dengan username yang sudah digunakan | Menampilkan pesan ramah: *"Nama pengguna sudah digunakan, coba nama lain ya!"* | Form terjaga, tidak ada error SQL |
| **TC-AUTH-03** | Autentikasi | Login dengan kata sandi salah | Menampilkan pesan ramah: *"Nama pengguna atau kata sandi belum tepat..."* | Kode HTTP ditangani dengan benar |
| **TC-FOOTER-01**| Footer | Buka halaman Login & Register | Footer autentikasi bersih tampil tanpa menu navbar, teks kredit Hendrik Wildansyah tampak jelas | Struktur terpisah dari navbar |
| **TC-AVATAR-01**| Registrasi | Memilih kartu portrait karakter (misal: Sera, Raka) | Gambar besar hero stage, judul, peran, dan deskripsi langsung berganti seketika | Stage pratinjau & radio sinkron |
| **TC-SIM-01** | Engine | Uji Misi 2.1 ("Selamatkan Bunga Matahari") | Manipulasi air & matahari mengubah kondisi tanaman secara visual dan real-time | Reaksi tanaman berjalan di 60fps |
| **TC-HINT-01** | AI MIKO | Meminta Petunjuk MIKO Level 1 | Balon MIKO terbuka berisi pertanyaan pemantik sokratik tanpa membocorkan jawaban | Nada bicara ramah & mendidik |
| **TC-COMPLETE** | Engine | Menyelesaikan tantangan misi & refleksi | Konfeti muncul, modal hadiah XP terbuka (+100 XP), node misi berikutnya terbuka | Data attempt tercatat di DB |
| **TC-ROBOT-01** | Engine | Menjalankan kartu perintah di "Botty Pulang" | Robot melangkah kotak demi kotak di grid sesuai urutan balok perintah | Animasi sinkron dengan kartu aktif |
| **TC-FALLBACK** | Sahabat AI | Mematikan koneksi internet / nonaktifkan API key | MIKO langsung memberikan petunjuk pedagogis deterministik dari data lokal | Nol error 500, nol penundaan |

---

## 3. Ergonomi Perangkat & Profil Layar

1. **Ponsel Pintar / Mobile Compact (360px – 480px):**
   - *Verifikasi:* Navbar memadat dengan rapi; tombol sentuh berukuran >= 48px; kanvas misi muat proporsional tanpa pergeseran horizontal (*no horizontal overflow*); kartu portrait avatar tersusun seimbang.
2. **Tablet Sekolah (768px – 1024px):**
   - *Verifikasi:* Panel ganda (pratinjau karakter di sebelah kiri, formulir & grid kartu avatar di sebelah kanan).
3. **Komputer Desktop / Laptop / Chromebook (1200px+):**
   - *Verifikasi:* Aset visual beresolusi tinggi, navigasi keyboard yang nyaman, jarak antar elemen lapang dan ergonomis.

---

## 4. Validasi Metode Masukan (Layar Sentuh & Mouse)
- **Geser-dan-Lepas (Drag-and-Drop):** Diverifikasi menggunakan HTML5 Drag API dan Touch Drag Events untuk interaksi memindahkan objek.
- **Alternatif Ketuk-Pilih (Tap-to-Assign):** Pada layar sentuh tertentu di mana gerakan geser mungkin sulit bagi tangan anak-anak, mengetuk objek akan menyorotnya, dan mengetuk wadah tujuan akan langsung menempatkan objek pada posisinya.

---

## 5. Rangkaian Skrip Pengujian Otomatis Repository

Repositori MISSION KIDS menyediakan skrip pengujian otomatis komprehensif di dalam folder [`tests/`](file:///c:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/tests):

1. **`test_redesign_verification.php`:** Memvalidasi pemisahan footer autentikasi dari navbar, kehadiran teks kredit pembuat, keberadaan 8 kartu portrait avatar, dan panel hero preview stage.
2. **`test_login_page.php`:** Memvalidasi rendering form login, token CSRF, validasi kredensial, dan penanganan kesalahan.
3. **`test_dynamic_avatars.php`:** Menguji integritas 8 avatar karakter anak 3D, ketersediaan file aset, dan persistensi registrasi ke database.
4. **`test_all_endpoints.php`:** Menguji seluruh 36 rute dan alur endpoint HTTP (Landing, Auth, Worlds, Missions, Hint API, Complete Mission API).
5. **`test_revisions_all.php`:** Menguji integrasi suara MIKO, pembersihan tombol peta dunia, dan isolasi soal per peta.
6. **`test_mobile_and_db_init.php`:** Menguji responsivitas mobile dan auto-bootstrap skema basis data SQLite.
7. **`test_miko_text_speech_sync.php`:** Menguji sinkronisasi teks balon dialog dan suara ucapan MIKO (*anti-hijacking verbatim matching*).

Untuk menjalankan pengujian:
```bash
php tests/test_redesign_verification.php
php tests/test_login_page.php
php tests/test_dynamic_avatars.php
php tests/test_all_endpoints.php
```
Semua rangkaian pengujian telah terverifikasi **100% PASS**.
