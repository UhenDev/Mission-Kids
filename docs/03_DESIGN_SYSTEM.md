# 03. SISTEM DESAIN (DESIGN SYSTEM) — MISSION KIDS

## 1. Filosofi Desain: "Playful Precision & Soft Neo-Brutalism"

MISSION KIDS menerapkan filosofi desain **Playful Precision**:
- **Playful (Ceria & Ramah Anak):** Sudut kartu membulat (*generous rounded corners*), warna tematik cerah harmonis, elemen taktil yang merespon sentuhan dengan fisika pantul (*tactile bounce*), dan karakter yang interaktif.
- **Precision (Presisi & Rapi):** Tipografi yang tertata dan mudah dibaca, kontras warna yang memenuhi standar aksesibilitas WCAG AA, ruang bernapas (*whitespace*) yang lega, dan ketiadaan kekacauan visual.
- **Prinsip Anti-Pola yang Dihindari:**
  - ❌ Tidak ada tabel kaku ala dasbor korporat (*dry SaaS enterprise tables*).
  - ❌ Tidak menggunakan gradasi pelangi berlebihan di setiap sudut halaman.
  - ❌ Tidak mengandalkan emoji liar sebagai tombol navigasi struktural.
  - ❌ Tidak menggunakan gambar placeholder eksternal yang rentan rusak/putus saat offline.

---

## 2. Token Desain (CSS Custom Properties)

Berikut adalah token variabel CSS terpusat yang diterapkan di seluruh aplikasi ([`public/css/design-system.css`](file:///c:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/public/css/design-system.css)):

```css
:root {
  /* Warna Merek Inti */
  --color-brand-primary: #2563EB;        /* Biru Petualangan */
  --color-brand-primary-hover: #1D4ED8;
  --color-brand-primary-light: #EFF6FF;
  --color-brand-secondary: #F59E0B;      /* Kuning Semangat */
  --color-brand-secondary-hover: #D97706;
  --color-brand-accent: #10B981;         /* Hijau Eksplorasi */
  --color-brand-coral: #EF4444;          /* Merah Energi */
  --color-dark-outline: #1E293B;         /* Outline Tegas Neo-Brutalist */

  /* Warna Netral & Kanvas Latar Belakang */
  --color-bg-app: #F8FAFC;               /* Putih Awan Cerah */
  --color-bg-card: #FFFFFF;
  --color-bg-elevated: #F1F5F9;
  --color-border-subtle: #E2E8F0;
  --color-border-interactive: #CBD5E1;
  --color-text-main: #0F172A;            /* Abu Gelap Arang */
  --color-text-muted: #64748B;           /* Slate Ramah */
  --color-text-inverse: #FFFFFF;

  /* Palet Dunia 01: Number City */
  --world-number-primary: #F59E0B;
  --world-number-deep: #B45309;
  --world-number-bg: #FEF3C7;
  --world-number-border: #FCD34D;

  /* Palet Dunia 02: Discovery Lab */
  --world-discovery-primary: #10B981;
  --world-discovery-deep: #047857;
  --world-discovery-bg: #D1FAE5;
  --world-discovery-border: #6EE7B7;

  /* Palet Dunia 03: Thinking Lab */
  --world-thinking-primary: #6366F1;
  --world-thinking-deep: #4338CA;
  --world-thinking-bg: #E0E7FF;
  --world-thinking-border: #A5B4FC;

  /* Palet Dunia 04: Space Odyssey */
  --world-space-primary: #8B5CF6;
  --world-space-deep: #6D28D9;
  --world-space-bg: #EDE9FE;
  --world-space-border: #C4B5FD;

  /* Tema Sahabat AI MIKO */
  --miko-body-color: #38BDF8;
  --miko-accent-color: #FBBF24;
  --miko-screen-bg: #0F172A;
  --miko-eye-glow: #22D3EE;

  /* Skala Tipografi */
  --font-body: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
  --font-heading: 'Fredoka', 'Plus Jakarta Sans', cursive, sans-serif;
  
  --fs-xs: 0.75rem;    /* 12px */
  --fs-sm: 0.875rem;   /* 14px */
  --fs-base: 1rem;     /* 16px */
  --fs-md: 1.125rem;   /* 18px */
  --fs-lg: 1.25rem;    /* 20px */
  --fs-xl: 1.5rem;     /* 24px */
  --fs-2xl: 1.875rem;  /* 30px */
  --fs-3xl: 2.25rem;   /* 36px */
  --fs-4xl: 3rem;      /* 48px */

  /* Skala Spasi (Spacing) */
  --space-1: 0.25rem;  /* 4px */
  --space-2: 0.5rem;   /* 8px */
  --space-3: 0.75rem;  /* 12px */
  --space-4: 1rem;     /* 16px */
  --space-5: 1.25rem;  /* 20px */
  --space-6: 1.5rem;   /* 24px */
  --space-8: 2rem;     /* 32px */
  --space-10: 2.5rem;  /* 40px */
  --space-12: 3rem;    /* 48px */

  /* Sudut Membulat (Border Radius) */
  --radius-sm: 0.5rem;   /* 8px */
  --radius-md: 0.75rem;  /* 12px */
  --radius-lg: 1rem;     /* 16px */
  --radius-xl: 1.5rem;   /* 24px */
  --radius-2xl: 2rem;    /* 32px */
  --radius-pill: 9999px;

  /* Bayangan Taktil 3D (Physical Depth) */
  --shadow-sm: 0 2px 4px rgba(15, 23, 42, 0.05);
  --shadow-md: 0 4px 12px rgba(15, 23, 42, 0.08);
  --shadow-lg: 0 10px 25px -5px rgba(15, 23, 42, 0.1);
  --shadow-neo-button: 0 5px 0 var(--color-dark-outline);
  --shadow-neo-button-active: 0 2px 0 var(--color-dark-outline);

  /* Transisi Halus */
  --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-bounce: 300ms cubic-bezier(0.34, 1.56, 0.64, 1);
}
```

---

## 3. Komponen Antarmuka Taktil Anak

### 3.1 Tombol Taktil Interaktif ("Pushable" Buttons)
Anak-anak sangat menyukai tombol yang terasa memiliki kedalaman fisik nyata saat disentuh. Sistem tombol kami menggunakan bevel shadow 3D yang memendek saat status `:active` ditekan:

```css
.btn-kid {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-2);
  padding: 0.75rem 1.6rem;
  font-family: var(--font-heading);
  font-size: var(--fs-md);
  font-weight: 800;
  border-radius: var(--radius-pill);
  border: 2.5px solid var(--color-dark-outline);
  box-shadow: var(--shadow-neo-button);
  cursor: pointer;
  transition: transform var(--transition-fast), box-shadow var(--transition-fast);
  user-select: none;
  min-height: 48px; /* Menjamin target sentuhan layar sentuh */
}

.btn-kid:hover {
  transform: translateY(-2px);
  box-shadow: 0 7px 0 var(--color-dark-outline);
}

.btn-kid:active {
  transform: translateY(3px);
  box-shadow: var(--shadow-neo-button-active);
}

.btn-kid-primary {
  background: linear-gradient(135deg, #2563EB, #1D4ED8);
  color: #FFFFFF;
}
```

### 3.2 Kartu Karakter Portrait (Avatar Selection Cards)
Kartu pemilihan karakter anak di halaman registrasi menyajikan kartu potret berukuran besar yang kaya informasi:
- **Frame Gambar Potret:** Menampilkan visual kepala & postur karakter jernih berlatar gradasi lembut dengan efek *zoom-on-hover*.
- **Role Badge Chip:** Menampilkan label identitas peran karakter (misalnya `Si Penjelajah`, `Si Ilmuwan`).
- **Indikator Terpilih:** Outline tebal 2.5px biru, background menyala, dan lencana centang `✓` bersudut atas dengan animasi *pop-scale*.

### 3.3 Stage Pratinjau Hero Karakter & Podium 3D
Di panel kiri pratinjau registrasi, karakter aktif berdiri di atas panggung podium 3D bercahaya aura pendar:
- **Podium Base:** Bentuk oval 3D bergradasi biru dengan pantulan bayangan ke bawah.
- **Stage Aura Glow:** Lingkaran radial pendar lembut di belakang karakter.
- **Transisi Berganti Karakter:** Efek transisi halus (*scale & fade cross-dissolve*) saat karakter lain dipilih dari kartu di sebelah kanan.

### 3.4 Balon Ucapan Interaktif MIKO (Speech Bubble)
Ketika MIKO berbicara atau memberikan petunjuk:
- Latar Belakang: Putih cerah ber-outline biru halus dengan panah penunjuk ke arah MIKO.
- Tipografi: Ukuran 15px dengan jarak baris lapang (line-height 1.6).
- Animasi: Efek muncul memantul lembut (*gentle bounce pop-in* dari 0.85 ke 1.0).

---

## 4. Status Animasi & Ekspresi Karakter MIKO

MIKO dirancang menggunakan vektor SVG ringan yang diintegrasikan langsung ke dalam DOM:

```text
    ╭───[ 💡 Antena Sensor Berpendar ]───╮
    │                                    │
    │         ╭──────────────╮           │
    │         │  ◉        ◉  │   ◀── Mata LED Ekspresif (Berkedip / Tersenyum)
    │         ╰──────────────╯           │
    │          \____________/    ◀── Senyum Layar Animasi
    │                                    │
    ╰───────────────┬────────────────────╯
              ╭─────┴─────╮
              │  ✦ MIKO ✦ │
              ╰───────────╯
```

### 5 Kondisi Animasi MIKO
1. **Santai / Standby (`miko-idle`):** Mata berkedip secara periodik setiap 4 detik, tubuh mengapung lembut naik-turun (*floating bob animation* 2 detik).
2. **Berpikir (`miko-thinking`):** Mata berubah menjadi titik roda gigi berputar halus, lampu antena berdenyut cyan.
3. **Senang / Mengapresiasi (`miko-happy`):** Mata melengkung ke atas membentuk bulan sabit tersenyum `^^`, tubuh memantul kecil penuh semangat.
4. **Memberikan Petunjuk (`miko-hint`):** Balon dialog terbuka dengan efek lonceng lembut, lampu antena menyala kuning terang.
5. **Perayaan Sukses (`miko-cheer`):** Efek konfeti berhamburan di sekitar MIKO, tangan terangkat gembira menyemangati siswa.

---

## 5. Hierarki Visual & Irama Tata Letak
- **Header Atas:** Batang mengambang ramping dengan Logo Rocket 🚀, XP meter siswa, lencana level, dan kontrol suara.
- **Kanvas Utama Misi:** Padding lega (24px hingga 40px), kartu ber-border gelap kokoh dan berbayangan 3D.
- **Footer Khusus Autentikasi:** Menghilangkan menu tiruan navbar, menyajikan identitas brand, kredit resmi *"Website ini dibuat oleh Hendrik Wildansyah."*, dan status hak cipta secara bersih dan proporsional.
