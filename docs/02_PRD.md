# 02. PRODUCT REQUIREMENTS DOCUMENT (PRD) — MISSION KIDS

## 1. Document Control & Scope
This PRD outlines functional and non-functional specifications for **MISSION KIDS**, defining student experience, learning mechanics, mission specifications, and platform features for release v1.0 MVP.

---

## 2. User Personas

### Persona A: Rian (Usia 8 Tahun, Kelas 2 SD)
- **Karakter:** Energik, mudah terdistraksi oleh teks panjang, sangat responsif terhadap respon visual dan stimulasi langsung.
- **Kebutuhan:** Instruksi singkat berbasis visual/suara ikonik, tombol besar yang mudah disentuh di tablet, apresiasi positif saat berhasil, dan petunjuk lembut saat salah tanpa rasa malu.
- **Skenario Sukses:** Menyelesaikan misi "Toko Kue" dengan menghitung koin kue dan "Tanaman Layu" dengan menyiram bunga hingga segar.

### Persona B: Maya (Usia 10 Tahun, Kelas 4 SD)
- **Karakter:** Penasaran, suka bereksperimen, menyukai teka-teki logika dan sains.
- **Kebutuhan:** Tantangan yang memancing daya nalar (computational thinking), kemampuan mengulang eksperimen dengan variabel berbeda, dan melihat progres kemampuannya berkembang.
- **Skenario Sukses:** Menyelesaikan misi "Robot Pulang" dengan merangkai urutan langkah efisien dan misi "Misteri Bayangan".

### Persona C: Ibu Ratna (Orang Tua & Guru SD)
- **Karakter:** Sadar teknologi, khawatir anak hanya terpapar konten hiburan pasif (video pendek / game destruktif).
- **Kebutuhan:** Platform aman tanpa iklan, tanpa chat bebas dengan orang asing, materi selaras dengan kurikulum dasar (literasi, numerasi, sains dasar, computational thinking), serta laporan progress belajar anak yang jelas dan edukatif.

---

## 3. High-Level Feature Architecture

```text
MISSION KIDS
├── 1. Public & Onboarding
│   ├── Landing Page (Clean, punchy, high-conversion)
│   ├── Kid-Friendly Registration / Login
│   └── 3-Step Express Onboarding (Name, Avatar, First World Choice)
├── 2. Student Experience (Home & Navigation)
│   ├── Student Home ("Apa misi saya hari ini?")
│   ├── Mission of the Day & Recommended Quests
│   ├── World Exploration Hub & Adventure Map
│   └── Skill Progress Journey (Numeracy, Science, Logic, Problem Solving)
├── 3. Mission Engine (Interactive Learning Workflows)
│   ├── World 01: Number City (3 Missions)
│   ├── World 02: Discovery Lab (3 Missions)
│   └── World 03: Thinking Lab (3 Missions)
├── 4. AI Companion MIKO
│   ├── Contextual Floating Buddy (Non-intrusive)
│   ├── 3-Tier Progressive Scaffolding Hints
│   └── Smart Fallback System (Guaranteed Uptime)
└── 5. Gamification & Progression
    ├── XP Ledger & Level Ups
    ├── Achievement Badges
    └── Metacognitive Reflection Checkpoints
```

---

## 4. Learning Worlds & 9 MVP Missions Detail

### WORLD 01: NUMBER CITY (Numerasi & Pola Angka)
*Tema Visual: Kota ramah masa depan dengan toko roti, jembatan gantung beroda gigi, dan jalur trem berpola.*

#### Mission 1.1: Toko Kue Donat (Interactive Shopping & Decision Making)
- **Learning Objective:** Mengasah kemampuan penjumlahan dan pengurangan pecahan uang sederhana serta pengambilan keputusan belanja.
- **Story Context:** Toko kue Bibi Bella kedatangan banyak pelanggan, namun mesin kasir rusak! Siswa membantu Bibi Bella menyiapkan pesanan kue dan menghitung uang kembalian.
- **Interaction Type:** Interactive Shopping Tray (drag & tap koin dan kue ke nampan pesanan).
- **Challenge:** Menyiapkan 2 donat seharga Rp 3.000 dengan uang pembeli Rp 5.000. Berapa uang kembalian yang harus ditaruh di nampan?
- **Reflection:** *"Mengapa kita harus memeriksa harga barang sebelum membayar di kasir?"*

#### Mission 1.2: Jembatan Angka (Number Logic & Arithmetic)
- **Learning Objective:** Mengenal relasi penjumlahan lompat dan kelipatan angka untuk menghubungkan platform jembatan.
- **Story Context:** Jembatan penyeberangan menuju menara jam runtuh beberapa papannya. MIKO mengajak siswa memasang balok batu dengan nilai hitung yang tepat agar jembatan tersambung kembali.
- **Interaction Type:** Number Puzzle Block Placement.
- **Challenge:** Balok bernomor 2, 5, 8, [ ? ], 14. Berapakah balok yang hilang?
- **Reflection:** *"Pola apa yang kamu temukan pada jarak antar angka pada balok?"*

#### Mission 1.3: Kota Pola (Visual Pattern Recognition)
- **Learning Objective:** Mengidentifikasi pola berulang geometris dan aljabar awal secara visual.
- **Story Context:** Lampu hias di taman kota mati karena urutan kristal warnanya tertukar oleh angin kencang.
- **Interaction Type:** Drag-and-drop pattern slotting.
- **Challenge:** Mengisi kristal [Merah, Biru, Biru, Merah, Biru, ?].
- **Reflection:** *"Bagaimana caramu mengetahui kristal berikutnya yang harus dipasang?"*

---

### WORLD 02: DISCOVERY LAB (Sains & Eksperimen Sebab-Akibat)
*Tema Visual: Laboratorium terbuka hijau dengan rumah kaca botani, meja optik kaca prisma, dan menara siklus cuaca.*

#### Mission 2.1: Tanaman Layu (Plant Biology & Simulation) — *Flagship Vertical Slice*
- **Learning Objective:** Memahami bahwa tumbuhan membutuhkan keseimbangan air, cahaya matahari, dan nutrisi tanah untuk hidup dan bertumbuh (fotosintesis sederhana).
- **Story Context:** Tanaman bunga matahari mini milik Lab Discovery terlihat layu, batangnya menunduk dan daunnya menguning. Siswa bertindak sebagai Dokter Tanaman.
- **Interaction Type:** Live Simulation Slider & Action Tools (Siram Air, Geser Tirai Matahari, Beri Pupuk Organik).
- **Simulation Feedback:** 
  - Terlalu sedikit air & gelap = Tanaman tetap layu.
  - Air pas + cahaya cukup = Bunga perlahan tegak, daun hijau segar, bunga mekar bercahaya!
  - Air banjir berlebih = Muncul peringatan gelembung air bahwa akar bisa membusuk.
- **Challenge:** Kembalikan kesegaran bunga matahari ke skor kesehatan 100% dalam 3 langkah terencana.
- **Reflection:** *"Apa saja 2 hal paling penting yang dibutuhkan tanaman setiap hari?"*

#### Mission 2.2: Misteri Bayangan (Light & Optics Sandbox)
- **Learning Objective:** Memahami hukum dasar perambatan cahaya lurus dan bagaimana jarak sumber cahaya menentukan ukuran bayangan.
- **Story Context:** Ruang teater boneka bayangan kehilangan proyektor senter. Maya dan MIKO ingin membuat bayangan kelinci sebesar layar pentas.
- **Interaction Type:** Interactive Torch Placement & Obstacle Distance Drag.
- **Challenge:** Mengatur posisi senter dekat atau jauh dari objek untuk mencocokkan bayangan dengan siluet target di layar.
- **Reflection:** *"Apa yang terjadi pada bayangan jika senter digerakkan semakin dekat ke benda?"*

#### Mission 2.3: Perjalanan Air (The Water Cycle Sequence)
- **Learning Objective:** Memahami siklus air: Penguapan (Evaporasi) → Pembentukan Awan (Kondensasi) → Hujan (Presipitasi).
- **Story Context:** Kolam danau lab mengering saat musim panas. Siswa menggerakkan mesin waktu alam untuk melihat kemana air pergi dan bagaimana hujan tercipta kembali.
- **Interaction Type:** Flow Sequencing & State Activation.
- **Challenge:** Mengurutkan 3 fase utama siklus air agar awan mendung turun menjadi hujan penyubur danau.
- **Reflection:** *"Dari mana asal air hujan yang turun membasahi bumi?"*

---

### WORLD 03: THINKING LAB (Computational Thinking & Algoritma Awal)
*Tema Visual: Grid kota digital retro-futuristik yang ramah dengan robot lucu bernama Botty, jalur lantai magnetik, dan baterai energi.*

#### Mission 3.1: Robot Pulang (Step-by-Step Sequencing)
- **Learning Objective:** Mengasah kemampuan merancang instruksi algoritmik berurutan (sequence execution) tanpa syntax rumit.
- **Story Context:** Botty tersesat di persimpangan taman bermain setelah baterainya melemah. Bantulah Botty menyusun kartu langkah menuju stasiun pengisian daya (*charging dock*).
- **Interaction Type:** Command Block Builder (Maju, Putar Kiri, Putar Kanan, Lompat).
- **Challenge:** Grid 4x4 dengan 1 rintangan batu. Susun kartu [Maju → Putar Kanan → Maju 2 Langkah] lalu tekan tombol hijau **"JALANKAN ROBOT!"**.
- **Execution:** Botty bergerak kotak demi kotak dengan animasi langkah yang memuaskan.
- **Reflection:** *"Mengapa urutan instruksi harus tepat sebelum robot dijalankan?"*

#### Mission 3.2: Jalan Rahasia (Conditional Decision & Obstacle Avoidance)
- **Learning Objective:** Memahami logika sederhana "JIKA ada rintangan, MAKA pilih jalur aman".
- **Story Context:** Jalan utama terhalang genangan oli pelumas. Botty harus memeriksa tanda rambu warna untuk memilih jembatan yang terbuka.
- **Interaction Type:** Path selector dengan pengkondisian visual.
- **Challenge:** Menyusun rute yang lolos deteksi sensor pintu warna.
- **Reflection:** *"Bagaimana caramu memilih jalan saat melihat rintangan di depan?"*

#### Mission 3.3: Robot Mengulang (Loop & Repetition Intuition)
- **Learning Objective:** Menanamkan intuisi perulangan (looping) untuk mempersingkat pekerjaan berulang.
- **Story Context:** Botty harus menaiki 4 anak tangga yang sama satu per satu. Daripada menekan "Lompat-Maju" 4 kali panjang, MIKO mengenalkan Kartu Pengulang (Loop 4x).
- **Interaction Type:** Visual Loop Wrapper Block.
- **Challenge:** Meringkas instruksi 8 blok menjadi 1 blok pengulang [Ulangi 4x: (Naik, Maju)].
- **Reflection:** *"Apa keuntungan menggunakan kartu pengulang daripada menyusun kartu yang sama berulang-ulang?"*

---

## 5. MIKO — Contextual AI Learning Companion
1. **Behavioral Protocol:**
   - MIKO tidak berada di halaman terpisah; MIKO bertengger sebagai ikon karakter di pojok kanan bawah canvas misi.
   - Mengeluarkan gelembung sapaan kontekstual sesuai progres misi saat ini.
   - Menyediakan tombol bantuan bertingkat: **"Minta Petunjuk MIKO"**.
2. **Pedagogical Guardrails:**
   - Larangan mutlak memberikan jawaban langsung pada petunjuk pertama dan kedua.
   - Bahasa wajib santun, ceria, edukatif, dan menggunakan bahasa Indonesia yang ramah anak.
   - Nol pengumpulan data pribadi (larangan menanyakan nomor telepon, alamat, sekolah, dsb).

---

## 6. Gamification System & Visual Progress

### XP Engine
- Menyelesaikan misi: **+100 XP**
- Menyelesaikan tantangan percobaan pertama tanpa petunjuk: **+50 XP (Bonus Eksplorasi)**
- Meminta petunjuk MIKO (tetap diapresiasi karena mau belajar): **+20 XP**
- Refleksi pasca misi: **+30 XP**

### Levels
- Level 1: **Penjelajah Pemula (0 - 199 XP)**
- Level 2: **Petualang Cilik (200 - 499 XP)**
- Level 3: **Penemu Pintar (500 - 899 XP)**
- Level 4: **Kapten Misi (900 - 1499 XP)**
- Level 5: **Master Explorer (1500+ XP)**

### 5 MVP Achievement Badges
1. 🏅 **First Mission Cleared:** Menyelesaikan misi pertama apapun di platform.
2. 🔬 **Little Scientist:** Menyelesaikan seluruh misi di Discovery Lab.
3. 🧮 **Number Explorer:** Menyelesaikan seluruh misi di Number City.
4. 🤖 **Logic Commander:** Menyelesaikan seluruh misi di Thinking Lab.
5. 🌟 **Mission Master:** Menyelesaikan seluruh 9 MVP missions.

---

## 7. Responsive & Touch Standards
- Desain Mobile-First dengan breakpoint: Mobile (360px - 480px), Tablet (768px - 1024px), Desktop (1200px+).
- Target sentuh minimum 44px x 44px dengan ruang sela aman minimal 8px antar elemen interaktif.
- Mendukung mode multi-input: Touch drag-and-drop serta Tap-to-select alternatif bagi perangkat tablet/ponsel yang sensitif.
