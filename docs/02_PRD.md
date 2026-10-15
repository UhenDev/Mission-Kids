# 02. DOKUMEN KEBUTUHAN PRODUK (PRD) — MISSION KIDS

## 1. Kontrol Dokumen & Ruang Lingkup
Dokumen Kebutuhan Produk (*Product Requirements Document / PRD*) ini menguraikan spesifikasi fungsional dan non-fungsional dari platform **MISSION KIDS**, mendefinisikan pengalaman belajar siswa, mekanisme interaksi misi, spesifikasi gamifikasi, dan fitur platform secara menyeluruh.

---

## 2. Persona Pengguna

### Persona A: Rian (Usia 8 Tahun, Siswa Kelas 2 SD)
- **Karakter:** Penuh energi, cepat bosan dengan teks instruksi panjang, sangat menyukai stimulasi visual ceria dan interaksi sentuhan langsung.
- **Kebutuhan:** Instruksi ringkas dengan panduan suara ramah, tombol besar yang mudah ditekan pada tablet/ponsel, animasi apresiasi perayaan saat berhasil, dan petunjuk lembut saat keliru tanpa membuat malu.
- **Skenario Sukses:** Menyelesaikan misi *"Toko Kue Donat"* dengan menghitung koin belanja serta misi *"Selamatkan Bunga Matahari"* dengan menyiram air hingga mekar.

### Persona B: Maya (Usia 10 Tahun, Siswa Kelas 4 SD)
- **Karakter:** Kritis, suka bereksperimen, menggemari teka-teki logika, sains, dan eksplorasi ruang angkasa.
- **Kebutuhan:** Tantangan yang memancing daya nalar (*computational thinking*), kebebasan mencoba berbagai variasi solusi, dan melihat grafik perkembangan level penjelajahnya.
- **Skenario Sukses:** Menyelesaikan misi *"Botty Pulang ke Rumah"* dengan merangkai instruksi balok langkah terpendek dan misi *"Roket Angkasa"*.

### Persona C: Ibu Ratna (Orang Tua & Guru Sekolah Dasar)
- **Karakter:** Peduli pendidikan digital, khawatir anak terpapar konten negatif atau kecanduan game tanpa nilai edukasi.
- **Kebutuhan:** Lingkungan digital yang aman (bebas iklan, tanpa chat publik dengan orang asing, patuh privasi anak), materi yang selaras dengan kurikulum dasar (literasi, numerasi, sains dasar, berpikir komputasi), serta tampilan perkembangan anak yang jelas.

---

## 3. Arsitektur Fitur Platform

```text
MISSION KIDS
├── 1. Halaman Publik & Registrasi
│   ├── Landing Page Edukatif (Hero interaktif, pengenalan MIKO, preview dunia)
│   ├── Autentikasi Siswa (Login & Register dengan footer minimalis berdedikasi)
│   └── Pemilihan Karakter 3D (8 Kartu Portrait karakter dengan stage preview dinamis)
├── 2. Pengalaman Belajar Siswa (Student Dashboard)
│   ├── Beranda Siswa ("Apa misimu hari ini?")
│   ├── Misi Rekomendasi & Quests Harian
│   ├── Peta Penjelajahan Dunia (Number City, Discovery Lab, Thinking Lab, Space Odyssey)
│   └── Riwayat Progres Keterampilan (Numerasi, Sains, Logika, Problem Solving)
├── 3. Engine Misi Interaktif (Interactive Learning Canvas)
│   ├── Dunia 01: Number City (20 Misi Numerasi)
│   ├── Dunia 02: Discovery Lab (20 Misi Sains & Sebab-Akibat)
│   ├── Dunia 03: Thinking Lab (20 Misi Logika Komputasi)
│   └── Dunia 04: Space Odyssey (20 Misi Antariksa & Masalah Kompleks)
├── 4. Sahabat AI Pendamping MIKO
│   ├── Maskot Mengambang Responsif (Floating Companion)
│   ├── Bantuan Bertahap 3 Level (Konseptual → Spesifik → Aksi Terbimbing)
│   ├── Sintesis Suara Ceria Indonesia (Web Speech TTS + Klip Audio Sinkron)
│   └── Sistem Fallback Lokal Otomatis (100% Uptime tanpa Single-Point-of-Failure)
└── 5. Gamifikasi Positif & Refleksi
    ├── Perolehan XP & Kenaikan 5 Level Petualang
    ├── Peringkat Bintang Performa (1–3 Bintang)
    ├── Lencana Kehormatan (Achievements)
    └── Jeda Refleksi Metakognitif Pasca Misi
```

---

## 4. Empat Dunia Pembelajaran & Spesifikasi Misi

### DUNIA 01: NUMBER CITY (Petualangan Numerasi & Pola Angka)
*Tema Visual: Kota metropolitan modern ramah anak dengan toko roti cerah, jembatan gantung beroda gigi, dan lampu taman kristal.*

#### Misi 1.1: Toko Kue Donat Bibi Bella (Interactive Shopping & Pecahan Uang)
- **Tujuan Pembelajaran:** Melatih operasi hitung penjumlahan dan pengurangan pecahan nilai uang rupiah dalam kehidupan sehari-hari.
- **Konteks Cerita:** Toko kue Bibi Bella ramai pembeli, namun mesin kasir sedang dalam perbaikan! Siswa membantu Bibi Bella menyiapkan donat dan menghitung uang kembalian yang tepat.
- **Tipe Interaksi:** *Interactive Shopping Tray* (mengetuk koin pecahan Rp 1.000, Rp 2.000, Rp 5.000 ke nampan kasir).
- **Tantangan:** Menyiapkan pesanan kue seharga Rp 3.000 dari pembeli yang membayar dengan uang Rp 5.000. Berapa uang kembalian yang ditaruh di nampan?
- **Pertanyaan Refleksi:** *"Mengapa kita perlu menghitung uang kembalian dengan cermat saat berbelanja?"*

#### Misi 1.2: Jembatan Angka yang Hilang (Deret Aritmatika & Pola Hitung)
- **Tujuan Pembelajaran:** Memahami pola bilangan loncat dan kelipatan angka untuk menyambung struktur jembatan.
- **Konteks Cerita:** Jembatan penyeberangan menuju menara kota kehilangan beberapa papan baloknya. Siswa memilih balok nomor yang tepat untuk mengisi kekosongan.
- **Tantangan:** Deret balok nomor: 2, 5, 8, [ ? ], 14. Berapakah nilai balok yang hilang? (Pola loncat +3).
- **Pertanyaan Refleksi:** *"Bagaimana caramu menemukan selisih angka antar balok pada jembatan?"*

#### Misi 1.3: Kota Pola (Pengenalan Pola Geometris Berulang)
- **Tujuan Pembelajaran:** Melatih logika aljabar awal melalui identifikasi pola ritme visual yang berulang.
- **Tantangan:** Menyusun kristal lampu warna: [Merah, Biru, Biru, Merah, Biru, ?] untuk menghidupkan kembali lampu taman kota.

---

### DUNIA 02: DISCOVERY LAB (Sains Alam & Simulasi Sebab-Akibat)
*Tema Visual: Laboratorium alam terbuka dengan rumah kaca botani, meja optik prisma, dan danau siklus hidrologi.*

#### Misi 2.1: Selamatkan Bunga Matahari Layu (Biologi Tumbuhan & Simulasi Live)
- **Tujuan Pembelajaran:** Memahami bahwa tumbuhan memerlukan keseimbangan air, sinar matahari, dan nutrisi untuk bertumbuh (fotosintesis sederhana).
- **Konteks Cerita:** Bunga matahari mini di laboratorium layu, batangnya menunduk dan daunnya menguning. Siswa berperan sebagai Dokter Tanaman.
- **Tipe Interaksi:** *Live Simulation Controls* (Gembor Air, Penggeser Tirai Sinar Matahari, Pupuk Organik).
- **Umpan Balik Simulasi:**
  - Air terlalu sedikit & gelap: Tanaman tetap layu menunduk.
  - Air seimbang + sinar matahari cukup: Batang bunga perlahan tegak, daun berubah hijau segar, dan kelopak bunga mekar bercahaya!
  - Air berlebih/banjir: Muncul peringatan bahwa akar tanaman bisa membusuk jika tergenang air terlalu banyak.
- **Tantangan:** Kembalikan kesehatan bunga ke skor 100% dengan takaran air dan cahaya yang seimbang.
- **Pertanyaan Refleksi:** *"Sebutkan dua hal penting yang dibutuhkan tanaman setiap hari untuk tetap hidup sehat!"*

#### Misi 2.2: Misteri Bayangan Panggung (Fisika Optika & Cahaya)
- **Tujuan Pembelajaran:** Memahami perambatan cahaya lurus dan pengaruh jarak sumber cahaya terhadap ukuran bayangan benda.
- **Tantangan:** Menyesuaikan jarak senter proyektor agar bayangan boneka kelinci pas dengan garis target panggung teater.

#### Misi 2.3: Perjalanan Siklus Air (Fase Siklus Hidrologi)
- **Tujuan Pembelajaran:** Mengurutkan tahapan siklus air: Evaporasi (Penguapan) → Kondensasi (Pembentukan Awan) → Presipitasi (Turun Hujan).

---

### DUNIA 03: THINKING LAB (Logika Komputasi / Computational Thinking)
*Tema Visual: Grid kota digital retro-futuristik dengan robot ramah Botty, jalur magnetik, dan stasiun pengisian daya.*

#### Misi 3.1: Botty Pulang ke Rumah (Algoritma Langkah Sekuensial)
- **Tujuan Pembelajaran:** Menyusun instruksi langkah berurutan (*sequential algorithm*) tanpa memerlukan sintaks pemrograman yang rumit.
- **Tipe Interaksi:** *Visual Command Block Builder* (Maju, Belok Kiri, Belok Kanan, Lompat).
- **Tantangan:** Grid 4x4 dengan rintangan batu. Susun kartu perintah [Maju → Belok Kanan → Maju 2 Langkah] lalu tekan tombol **"JALANKAN ROBOT!"**.
- **Eksekusi:** Botty berjalan kotak demi kotak dengan animasi langkah terarah menuju stasiun daya.

#### Misi 3.2: Jalan Rahasia Sensor Warna (Logika Percabangan / If-Else)
- **Tujuan Pembelajaran:** Memahami pengambilan keputusan bersyarat: *"JIKA terdeteksi warna merah, MAKA belok; JIKA hijau, MAKA lurus"*.

#### Misi 3.3: Robot Mengulang (Konsep Perulangan / Looping)
- **Tujuan Pembelajaran:** Memahami fungsi blok perulangan (*loop*) untuk mengefisiensikan instruksi yang berulang-ulang.

---

### DUNIA 04: SPACE ODYSSEY (Eksplorasi Antariksa & Masalah Kompleks)
*Tema Visual: Stasiun orbit antariksa, nebula bercahaya, roket peluncuran, dan permukaan planet berbatu.*

#### Misi 4.1: Roket Angkasa (Daya Dorong & Propulsi)
- **Tujuan Pembelajaran:** Menyeimbangkan rasio bahan bakar dan massa muatan agar roket mencapai orbit tanpa kehabisan daya.

#### Misi 4.2: Peta Rasi Bintang (Pola Koordinat Astronomi)
- **Tujuan Pembelajaran:** Menghubungkan titik koordinat bintang untuk membentuk rasi navigasi di langit malam.

#### Misi 4.3: Rover Mars (Navigasi Ekspedisi Planet)
- **Tujuan Pembelajaran:** Merancang jalur lintasan penjelajah permukaan planet yang menghindari kawah dan badai pasir.

---

## 5. Sahabat AI Belajar MIKO

1. **Prinsip Interaksi MIKO:**
   - MIKO selalu hadir di sudut layar sebagai ikon sahabat yang bersahabat (*floating companion*).
   - Menampilkan balon dialog kontekstual sesuai misi yang sedang dibuka.
   - Dilengkapi tombol petunjuk berjenjang: **"Minta Petunjuk MIKO"**.
   - Suara audio disintesis menggunakan Web Speech API ramah anak laki-laki Indonesia (pitch: 1.25, rate: 1.05) yang selaras dengan teks balon ucapan (*anti-hijacking verbatim sync*).

2. **Aturan Pedagogis Ketat:**
   - Dilarang keras membocorkan jawaban secara langsung pada petunjuk level 1 dan level 2.
   - Tutur bahasa wajib ramah, ceria, edukatif, dan bebas dari istilah teknis yang membingungkan anak.
   - Tidak ada pengumpulan data pribadi (larangan meminta nomor telepon, alamat rumah, nama sekolah, dll).

---

## 6. Sistem Gamifikasi Positif

### Perolehan Experience Points (XP)
- Menyelesaikan misi: **+100 XP**
- Menyelesaikan misi pada percobaan pertama tanpa petunjuk: **+50 XP (Bonus Mandiri)**
- Bertanya pada petunjuk MIKO (tetap diapresiasi karena berani belajar): **+20 XP**
- Mengisi pertanyaan refleksi metakognitif: **+30 XP**

### 5 Tingkatan Level Petualang
1. Level 1: **Penjelajah Pemula (0 – 199 XP)**
2. Level 2: **Petualang Cilik (200 – 499 XP)**
3. Level 3: **Penemu Pintar (500 – 899 XP)**
4. Level 4: **Kapten Misi (900 – 1.499 XP)**
5. Level 5: **Master Explorer (1.500+ XP)**

### Lencana Prestasi (Achievements)
- 🏅 **First Mission Cleared:** Menyelesaikan misi pertama di platform.
- 🧮 **Number Explorer:** Menuntaskan seluruh misi di Number City.
- 🔬 **Little Scientist:** Menuntaskan seluruh misi di Discovery Lab.
- 🤖 **Logic Commander:** Menuntaskan seluruh misi di Thinking Lab.
- 🚀 **Space Pioneer:** Menuntaskan seluruh misi di Space Odyssey.
- 🌟 **Mission Master:** Menyelesaikan seluruh misi dan mencapai level tertinggi.

---

## 7. Standar Responsivitas & Layar Sentuh
- Desain *Mobile-First* dengan titik henti responsif: Ponsel (360px – 480px), Tablet (768px – 1024px), Desktop (1200px+).
- Ukuran target sentuh tombol minimal 48px x 48px dengan jarak sela aman minimal 8px antar elemen.
- Mendukung dua mode interaksi: Geser-dan-lepas (*drag & drop*) serta ketuk-pilih (*tap-to-select*) untuk kemudahan penggunaan pada layar tablet sekolah.
