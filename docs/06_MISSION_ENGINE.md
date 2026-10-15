# 06. SPESIFIKASI ENGINE MISI — MISSION KIDS

## 1. Arsitektur Engine & Prinsip Inti

**MISSION KIDS Mission Engine** adalah kerangka kerja modular di sisi klien (*frontend client framework*) yang menstandarisasi bagaimana seluruh misi edukasi dimuat, dirender, dimainkan, divalidasi, dan diapresiasi.

### Prinsip Utama Engine
1. **Nol Duplikasi Logika (Zero Logic Duplication):** Setiap misi berbagi arsitektur kontainer siklus hidup yang identik, sinkronisasi progres yang sama, modal refleksi yang sama, dan antarmuka AI MIKO yang sama. Hanya kanvas manipulasi dan parameter konfigurasi JSON yang berbeda.
2. **Konfigurasi Misi Deklaratif (Declarative JSON Config):** Seluruh konten narasi cerita, aset visual, tipe interaksi, target solusi, petunjuk bertahap, dan pertanyaan refleksi didefinisikan dalam struktur JSON yang bersih.
3. **Sentuhan Layar Utama (Touch-First Tactility):** Target sentuh kontras tinggi, tombol besar ber-outline tegas, dan animasi SVG responsif 60fps menjamin kenyamanan bermain pada layar sentuh tablet, ponsel pintar, Chromebook, maupun laptop sekolah.

---

## 2. Siklus Hidup 7 Langkah Misi (7-Step Mission Lifecycle)

```text
 ┌─────────────┐
 │  1. CERITA  │ ◀── Narasi pembuka: MIKO & karakter menjelaskan masalah mendesak yang dihadapi.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │ 2. BELAJAR  │ ◀── Wawasan ilmiah/matematika ringkas sebelum anak mulai bertindak.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │3. AKTIVITAS │ ◀── Area eksplorasi bebas: mencoba alat, slider, atau tombol interaktif.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │4. TANTANGAN │ ◀── Sasaran konkrit pemecahan masalah: anak menyelaraskan variabel ke target misi.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │5. UMPAN BALIK│ ◀── Validasi instan: perayaan visual langsung atau petunjuk ramah untuk mencoba lagi.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │ 6. REFLEKSI │ ◀── Jeda metakognitif: anak mengaitkan apa yang dipelajari dengan dunia nyata.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │7. APRESIASI │ ◀── Hamburan konfeti, rincian hadiah XP (+100 XP), cek lencana, dan buka node peta.
 └─────────────┘
```

---

## 3. Tiga Handler Interaksi Inti

### Tipe 01: `match_sort` (Nampan Belanja & Pencocokan Pola)
- **Digunakan Pada:** *Toko Kue Donat*, *Jembatan Angka*, *Kota Pola*.
- **Mekanisme:** Kumpulan elemen sumber yang dapat diketuk/digeser (koin pecahan rupiah, kue donat, balok batu bernomor, kristal lampu warna) dan zona wadah target (*tray slots*).
- **Aksesibilitas Ganda:** Selain mendukung geser-lepas (*drag & drop*), sistem menyediakan mode ketuk-ke-nampan (*tap-to-assign*) yang sangat memudahkan anak pada layar sentuh berukuran kecil.
- **Validasi Solusi:** Memeriksa kesesuaian nilai nampan dengan aturan matematika misi (misalnya `sum(koin_nampan) == 2000`).

### Tipe 02: `experiment_simulation` (Laboratorium Fisika & Biologi Live)
- **Digunakan Pada:** *Selamatkan Bunga Matahari Layu* (*Vertical Slice Unggulan*), *Misteri Bayangan*, *Perjalanan Air*.
- **Mekanisme:** Kontrol manipulasi kontinu atau bertahap (Alat Gembor Siram Air, Penggeser Tirai Cahaya Matahari, Sakelar Pupuk Organik).
- **Model Reaktif Visual:** Memanipulasi alat seketika menghitung ulang vektor kondisi tanaman (`moisture`, `sunlight`, `plant_health`) dan memicu perubahan bentuk SVG secara langsung:
  - *Tanaman:* Batang perlahan tegak dari 45° ke 90°, daun mengembang dari kuning kusam menjadi hijau zamrud segar `#10B981`, dan kelopak bunga mekar bercahaya.
  - *Bayangan:* Menggeser senter mendekat atau menjauh secara real-time mengubah skala rasio bayangan dan radius blur siluet panggung.
- **Validasi Solusi:** Mengevaluasi apakah anak berhasil menjaga variabel dalam "Zona Sehat Seimbang" (Health Score 100%).

### Tipe 03: `sequence_logic` (Robot Pemrograman Algoritma Sekuensial)
- **Digunakan Pada:** *Botty Pulang ke Rumah*, *Jalan Rahasia Sensor Warna*, *Robot Mengulang*.
- **Mekanisme:**
  1. Palet kartu balok perintah: `[MAJU]`, `[PUTAR KIRI]`, `[PUTAR KANAN]`, `[LOMPAT]`, `[ULANGI 4X]`.
  2. Nampan antrean eksekusi tempat kartu disusun berurutan.
  3. Grid peta visual (4x4 atau 5x5) menampilkan Botty the Robot, dinding rintangan, dan stasiun pengisian daya.
  4. Mesin Pemutaran Animasi: Saat anak menekan tombol hijau **"JALANKAN ROBOT!"**, engine mengeksekusi kartu langkah demi langkah dengan jeda 500ms, menyoroti kartu yang sedang aktif saat Botty melangkah.
- **Validasi Solusi:** Memeriksa apakah Botty tiba di koordinat stasiun daya dengan selamat tanpa menabrak rintangan.

---

## 4. Skema Konfigurasi JSON Misi (Spesifikasi `config_json`)

Setiap data misi pada database dikonfigurasi melalui payload JSON berstruktur baku:

```json
{
  "mission_id": "tanaman-layu",
  "world_slug": "discovery-lab",
  "title": "Dokter Tanaman: Bunga Matahari",
  "story": {
    "headline": "Bunga Matahari Mini Butuh Bantuanmu!",
    "dialogue": "Halo Sahabat Penjelajah Cilik! Bunga matahari di lab kita tampak layu dan batangnya menunduk. Bisakah kamu mencari tahu apa yang kurang agar ia mekar kembali?",
    "character_state": "worried"
  },
  "learning_concept": {
    "title": "Kebutuhan Dasar Tumbuhan",
    "bullet_points": [
      "Tanaman membutuhkan air untuk mengalirkan nutrisi dari akar ke daun.",
      "Tanaman membutuhkan sinar matahari yang cukup untuk memasak makanannya sendiri (fotosintesis)."
    ]
  },
  "interaction": {
    "type": "experiment_simulation",
    "initial_state": {
      "moisture": 10,
      "sunlight": 20,
      "plant_health": 25
    },
    "target_state": {
      "moisture_range": [50, 80],
      "sunlight_range": [60, 85],
      "required_health": 100
    },
    "tools": [
      { "id": "water_can", "label": "Siram Air", "icon": "💧", "effect": { "moisture": "+25" } },
      { "id": "sun_curtain", "label": "Buka Tirai Matahari", "icon": "☀️", "type": "slider", "min": 0, "max": 100 }
    ]
  },
  "hints": {
    "level_1": "Coba perhatikan tanah bunga matahari itu. Apakah tanahnya kering atau lembap?",
    "level_2": "Tanaman sangat membutuhkan air dan cahaya. Cobalah siram air dengan gembor di sebelah kiri!",
    "level_3": "Siram air sampai tanahnya segar, lalu geser tirai jendela agar sinar matahari mencapai sekitar 75%!"
  },
  "reflection": {
    "question": "Sebutkan dua hal paling penting yang dibutuhkan tanaman setiap hari untuk tetap hidup sehat!",
    "options": [
      "Air yang cukup dan sinar matahari",
      "Es krim dan minuman manis",
      "Kipas angin dan ruangan gelap"
    ],
    "correct_index": 0
  }
}
```
