# 🚀 MISSION KIDS
### *Interactive Mission-Based Learning Platform for Kids*
> **Karya:** Hendrik Wildansyah (Lead Fullstack Developer & UI/UX Designer)  
> *"Website ini dibuat oleh Hendrik Wildansyah."*  
> **Kompetisi:** M-ONE Telkomsel Coding Competition 2026 Submission

[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://www.php.net/)
[![Database](https://img.shields.io/badge/Database-SQLite%20%7C%20MySQL-4479A1?style=for-the-badge&logo=sqlite&logoColor=white)](https://www.sqlite.org/)
[![Frontend](https://img.shields.io/badge/Frontend-Vanilla%20JS%20%26%20CSS3-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)](https://developer.mozilla.org/)
[![UI Style](https://img.shields.io/badge/UI-Neo--Brutalist%20Gamified-8B5CF6?style=for-the-badge)](docs/03_DESIGN_SYSTEM.md)
[![AI Companion](https://img.shields.io/badge/AI%20Voice-MIKO%20(Indonesian%20TTS)-0284C7?style=for-the-badge)](docs/07_AI_BEHAVIOR.md)
[![Privacy](https://img.shields.io/badge/Privacy-COPPA%20Compliant%20(Zero%20PII)-10B981?style=for-the-badge)](docs/08_SECURITY.md)

---

## 🌟 1. Tentang MISSION KIDS

**MISSION KIDS** adalah platform edukasi interaktif berbasis misi nyata yang dirancang khusus untuk siswa Sekolah Dasar (SD, usia 7–12 tahun) oleh **Hendrik Wildansyah**.

Berbeda dengan sistem e-learning (LMS) konvensional yang membosankan dengan kuis pilihan ganda teks kering, atau aplikasi game murni yang minim esensi belajar, **MISSION KIDS** menempatkan anak sebagai penjelajah dan pemecah masalah (*active problem solver*).

### 💡 Konsep Utama:
> **"Anak belajar dengan menghadapi sebuah misi atau masalah nyata, mengeksplorasi informasi pendukung, melakukan aktivitas interaktif melalui manipulasi objek visual, memecahkan tantangan sebab-akibat, mendapatkan feedback yang membangun, dan merefleksikan makna pembelajaran."**

---

## 🎨 2. Visual Playful Neo-Brutalist & 8 Karakter Avatar 3D

- **Gaya Desain Neo-Brutalist Soft:** Kartu dengan sudut melengkung ramah (24px–28px), garis tepi gelap tegas (2.5px), bayangan taktil timbul (*hard shadow* `0 6px 0`), serta tombol 3D empuk yang membal saat ditekan.
- **8 Karakter Avatar 3D Anak Manusia:**
  1. **Kian:** Si Penjelajah (Topi safari petualang)
  2. **Sera:** Si Ilmuwan (Kacamata lab & jas eksperimen)
  3. **Raka:** Si Atlet (Headband sporty & penuh energi)
  4. **Nara:** Si Seniman (Baret jingga imajinatif)
  5. **Dika:** Si Petualang (Bandana alam & kompas)
  6. **Bayu:** Si Teknolog (Headset futuristik & visor)
  7. **Fajar:** Si Penemu (Rompi peralatan teknik)
  8. **Luna:** Si Pemimpin (Jubah inspiratif & bintang pemersatu)
- **Panggung Podium 3D Preview:** Pada form pendaftaran, anak dapat melihat preview karakter secara langsung di atas podium 3D saat memilih kartu avatar.
- **Footer Khusus Auth:** Halaman login dan register dilengkapi footer bersih yang proporsional tanpa duplikasi menu navigasi, dengan identitas *"Website ini dibuat oleh Hendrik Wildansyah."*

---

## 🤖 3. Sahabat AI MIKO Multimodal (Suara & Scaffolding)

Didampingi oleh **MIKO** (*Mindful Interactive Knowledge Operator*), kecerdasan buatan sosial-kognitif yang dirancang dengan etika pedagogis ketat:

- ❌ **Bukan Chatbot Terbuka:** Tidak ada obrolan teks bebas tanpa pengawasan yang berisiko bagi anak.
- ❌ **Bukan Pembocor Jawaban:** MIKO menolak memberikan jawaban instan demi menjaga daya nalar dan ketahanan berpikir (*grit*) anak.
- 🔊 **Suara Lisan Bahasa Indonesia (*Text-to-Speech*):** Suara anak laki-laki Indonesia yang ceria & ramah (`id-ID`, pitch: 1.25, rate: 1.05) via Web Speech API native + fallback klip audio studio ArdiNeural.
- 🎯 **Panduan Konkret di Arena Tantangan:** Menjelaskan instruksi tugas *"Apa yang harus kamu lakukan?"* di setiap panggung misi.
- ✅ **Bantuan Bertahap (3-Tier Scaffolding):**
  1. **Level 1 (Konseptual):** Mengajukan pertanyaan pemantik logika.
  2. **Level 2 (Spesifik):** Mengarahkan fokus perhatian anak ke variabel kunci.
  3. **Level 3 (Aksi Terbimbing):** Memberikan instruksi aksi konkret tanpa membocorkan jawaban.
- 🛡️ **Zero Single-Point-of-Failure:** Jika koneksi API AI eksternal offline atau kuota habis, MIKO 100% otomatis beralih ke petunjuk deterministik pedagogis bawaan tanpa gangguan.

---

## 🗺️ 4. Empat Dunia Petualangan & 80 Misi Interaktif

Platform ini menghadirkan **4 dunia tematik** dengan total **80 misi pembelajaran interaktif** (20 misi per dunia):

| Dunia | Fokus Pembelajaran | Jumlah Misi | Contoh Misi Interaktif |
| :--- | :--- | :--- | :--- |
| **🧮 Number City** | Numerasi, Uang & Pola | 20 Misi | Kasir Toko Kue Donat, Jembatan Angka Kelipatan, Lampu Kristal Berpola, Estimasi Diskon |
| **🌿 Discovery Lab** | Sains, Eksperimen & Alam | 20 Misi | Fotosintesis Tanaman Layu, Optika Misteri Bayangan, Tahapan Siklus Air, Massa Benda |
| **🤖 Thinking Lab** | Computational Thinking | 20 Misi | Logika Robot Botty, Percabangan Jalur Rahasia IF-ELSE, Optimasi Perulangan (*Looping*) |
| **🚀 Space Odyssey** | Sains Antariksa & Navigasi | 20 Misi | Kalibrasi Sudut Roket, Koordinat Kartesius Rasi Bintang, Navigasi Rover Mars Hindari Kawah |

---

## 🏆 5. Sistem Gamifikasi Positif (*Anti-Race Condition*)

- **⭐ Rating Bintang (1–3 Bintang):** Dihitung berdasarkan kemandirian anak menyelesaikan misi.
- **📈 Progres Level Petualang:** 5 tingkatan level dari *Penjelajah Pemula (Lvl 1)* hingga *Master Explorer (Lvl 5)*.
- **🏅 Medali Kehormatan (Achievements):** Dibuka secara otomatis berdasarkan pencapaian dunia dan ketekunan belajar.
- **🔊 Musik Prosedural Web Audio API:** Melodi pentatonik marimba dan ketukan bass lembut tanpa aset file MP3 eksternal (ringan, hemat kuota, instan dimuat).
- **🎊 Ledakan Konfeti Kanvas HTML5:** Merayakan kemenangan anak dengan semburan partikel konfeti tengah layar.
- **🔒 Perlindungan Database ACID:** Menggunakan transaksi ACID dengan *row locking* dan *unique constraints* untuk mencegah manipulasi reward ganda atau klik cepat (*race condition*).

---

## 🔒 6. Keamanan & Standar Privasi Anak (COPPA & GDPR-K)

1. **Zero PII (Personally Identifiable Information):** Tidak meminta nama lengkap, email, nomor handphone, lokasi GPS, maupun data sekolah. Pendaftaran hanya memerlukan nama panggilan, pilihan avatar, username, dan password.
2. **Perlindungan Injeksi SQL:** 100% kueri database menggunakan PDO Prepared Statements dengan parameter binding.
3. **Pencegahan DOM XSS:** Seluruh output teks MIKO dirender menggunakan text node aman (`textContent` & DOM builder).
4. **Proteksi CSRF:** Token kriptografis acak `bin2hex(random_bytes(32))` divalidasi pada seluruh permintaan formulir dan request POST.
5. **Keamanan Sesi Ketat:** Cookie dilindungi dengan bendera `HttpOnly`, `SameSite=Lax`, dan regenerasi ID sesi otomatis.

---

## 🛠️ 7. Teknologi & Arsitektur Sistem

- **Backend:** PHP 8.2+ Native (Arsitektur MVC Modular tanpa framework bloated).
- **Database Engine:** SQLite 3 dengan auto-bootstrap schema & seeder otomatis, serta kompatibilitas penuh MySQL / MariaDB.
- **Frontend:** Semantic HTML5, Vanilla CSS3 (Neo-Brutalist Soft UI), Modern Vanilla JavaScript (ES6+).
- **Zero Build Step:** Tidak memerlukan kompilasi Node.js atau Webpack, siap dijalankan langsung di server apa pun.

### Struktur Direktori:
```text
mission-kids/
├── config/              # Konfigurasi aplikasi & factory database
├── database/            # Skema SQL, seeder data 80 misi & medali
├── docs/                # 10 Dokumen spesifikasi teknis lengkap (Bahasa Indonesia)
├── public/              # Web Root (index.php, CSS, JS engine, assets)
│   ├── css/             # Design system neo-brutalist, animasi, dunia & misi
│   └── js/              # Engine misi, MIKO voice client, Web Audio, Canvas
├── src/                 # Backend MVC
│   ├── Controllers/     # Auth, Home, Mission, dan JSON API
│   ├── Helpers/         # Avatar 3D helper, Session & Security (CSRF, XSS)
│   └── Services/        # AuthService, Gamification, MissionProgress, MikoAi
└── templates/           # View layout, auth footer, & halaman antarmuka siswa
```

---

## 🚀 8. Panduan Menjalankan Secara Lokal

### Prasyarat:
- PHP 8.2 atau lebih baru.
- Ekstensi PHP aktif: `pdo`, `pdo_sqlite` (atau `pdo_mysql`), `curl`.

### Langkah Menjalankan:
1. **Masuk ke direktori project:**
   ```bash
   cd mission-kids
   ```

2. **Inisialisasi Database (Opsional — SQLite otomatis terinisialisasi saat web pertama kali dibuka):**
   ```bash
   php database/migrate.php
   ```

3. **Jalankan Server Lokal:**
   ```bash
   php -S 127.0.0.1:8080 -t public
   ```

4. **Buka di Peramban Web:**
   Akses `http://127.0.0.1:8080` melalui browser pilihan Anda.

---

## 🧪 9. Pengujian & Jaminan Mutu (Quality Assurance)

Project ini dilengkapi pengujian otomatis menyeluruh tanpa error (100% PASS Rate):

```bash
# 1. Uji Redesain UI, 4 Dunia, 80 Misi & 8 Avatar
php tests/test_redesign_verification.php

# 2. Uji Halaman Login & Auth Footer Khusus
php tests/test_login_page.php

# 3. Uji 8 Karakter Avatar 3D Dinamis
php tests/test_dynamic_avatars.php

# 4. Uji Seluruh Endpoint & Alur Navigasi
php tests/test_all_endpoints.php

# 5. Uji Suara AI MIKO & Konsistensi TTS
php tests/test_revisions_all.php

# 6. Uji Konkurensi & Anti-Race Condition
php tests/test_concurrency_race.php

# 7. Uji Sanitasi DOM XSS
node tests/test_dom_xss.js
```

---

## 🌐 10. Panduan Deployment Produksi

### Opsi A: VPS Dokploy / Docker (Rekomendasi untuk Kontainer)
1. Proyek menyertakan konfigurasi `Dockerfile` dan `docker-compose.yml`.
2. Gunakan volume persistence pada `/app/database` agar file database SQLite tersimpan permanen di VPS:
   ```yaml
   volumes:
     - mission_kids_data:/app/database
   ```
3. Data akun dan progres belajar tersimpan secara aman lintas perangkat dan redeploy.

### Opsi B: Shared Hosting / cPanel
1. Unggah seluruh isi folder project ke hosting Anda.
2. Atur Document Root domain / subdomain mengarah ke folder `/public`.
3. Buat database MySQL di cPanel, salin `.env.example` menjadi `.env`, lalu isi kredensial database (atau biarkan SQLite default).

---

## 📄 11. Lisensi & Hak Cipta
Dikembangkan dengan penuh dedikasi oleh **Hendrik Wildansyah** untuk **M-ONE Telkomsel Coding Competition 2026**.  
*Website ini dibuat oleh Hendrik Wildansyah.* Hak Cipta © 2026 Hendrik Wildansyah & MISSION KIDS.
