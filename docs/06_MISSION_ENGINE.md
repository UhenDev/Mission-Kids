# 06. MISSION ENGINE SPECIFICATION — MISSION KIDS

## 1. Engine Architecture & Core Principles
The **MISSION KIDS Mission Engine** is a reusable, modular client-side framework that standardizes how educational missions are authored, rendered, played, validated, and rewarded.

### Key Tenets
1. **Zero Logic Duplication:** Every mission shares the exact same lifecycle container, progress syncer, reflection modal, and MIKO interface. Only the interaction canvas and config parameters differ.
2. **Declarative Mission Config:** Missions are defined in clean JSON structures specifying narrative text, assets, interaction type, target states, hints, and reflections.
3. **Touch-First Tactility:** High-contrast drag targets, oversized tap buttons, and lively SVG micro-animations ensure seamless operation on touchscreens, iPads, Chromebooks, and desktop mice.

---

## 2. The 7-Step Mission Lifecycle

```text
 ┌─────────────┐
 │ 1. STORY    │ ◀── Narrative hook: MIKO & characters explain the urgent dilemma.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │ 2. LEARN    │ ◀── Bite-sized scientific/mathematical insight before action.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │ 3. ACTIVITY │ ◀── Interactive playground: explore tools, sliders, or blocks freely.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │4. CHALLENGE │ ◀── Concrete problem-solving goal: student aligns variables to target.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │ 5. FEEDBACK │ ◀── Instant validation: celebratory visual cues or warm retry hints.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │6. REFLECTION│ ◀── Metacognitive checkpoint: student consolidates key takeaway.
 └──────┬──────┘
        ▼
 ┌─────────────┐
 │ 7. REWARD   │ ◀── Confetti burst, XP breakdown (+100 XP), badge check, map unlock.
 └─────────────┘
```

---

## 3. The Three Core Interaction Handlers

### Type 01: `match_sort` (Shopping & Pattern Trays)
- **Used In:** *Toko Kue Donat*, *Jembatan Angka*, *Kota Pola*.
- **Mechanics:** A collection of draggable source items (coins, pastry, numbered bridge stones, colored crystals) and designated target drop zones/slots.
- **Accessibility Fallback:** If drag-and-drop is difficult on certain touch screens, tapping an item highlights it, and tapping the target slot immediately moves it into place.
- **Validation:** Compares slot contents with the mission's mathematical/pattern rule (e.g. `sum(tray_items) == 5000`).

### Type 02: `experiment_simulation` (Physical & Biological Labs)
- **Used In:** *Tanaman Layu* (Vertical Slice Hero), *Misteri Bayangan*, *Perjalanan Air*.
- **Mechanics:** Continuous or stepped interactive controls (Watering Can tool, Sunlight Curtain slider, Fertilizer toggle).
- **Reactive Model:** Manipulating a tool instantly recalculates simulation state vectors (e.g., `moisture`, `sunlight`, `health`) and triggers SVG morphs:
  - *Plant:* Stems unbend from 45° to 90°, leaves swell from dull yellow `#CBD5E1` to vibrant emerald `#10B981`, flower petals bloom.
  - *Shadow:* Adjusting torch distance changes shadow scale and blur radius in real time.
- **Validation:** Evaluates whether student stabilized simulation parameters within the "Healthy Living Zone" for at least 3 seconds.

### Type 03: `sequence_logic` (Algorithmic Robot Runner)
- **Used In:** *Robot Pulang*, *Jalan Rahasia*, *Robot Mengulang*.
- **Mechanics:** 
  1. Palette of command blocks: `[MAJU]`, `[PUTAR KIRI]`, `[PUTAR KANAN]`, `[LOMPAT]`, `[ULANGI 4X]`.
  2. Execution tray where cards are sequenced.
  3. Visual grid (4x4 or 5x5) featuring Botty the Robot, walls, items, and the charging dock.
  4. Animated Playback Engine: When the student hits *"JALANKAN ROBOT!"*, the engine executes cards step-by-step with a 500ms step interval, highlighting the active card as Botty moves.
- **Validation:** Checks if Botty reached the destination coordinate without collision with obstacles.

---

## 4. Mission Configuration Schema (JSON Spec)

```json
{
  "mission_id": "tanaman-layu",
  "world_slug": "discovery-lab",
  "title": "Dokter Tanaman: Bunga Matahari",
  "story": {
    "headline": "Bunga Matahari Mini Butuh Bantuanmu!",
    "dialogue": "Halo Penjelajah Cilik! Bunga matahari di lab kita tampak layu dan menunduk. Bisakah kamu mencari tahu apa yang kurang?",
    "character_state": "worried"
  },
  "learning_concept": {
    "title": "Kebutuhan Dasar Tumbuhan",
    "bullet_points": [
      "Tanaman membutuhkan air untuk mengalirkan nutrisi dari tanah.",
      "Tanaman membutuhkan sinar matahari untuk memasak makanan (fotosintesis)."
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
      "moisture_min": 60,
      "moisture_max": 90,
      "sunlight_min": 65,
      "sunlight_max": 95,
      "plant_health_target": 100
    }
  },
  "hints": [
    {
      "level": 1,
      "text": "Lihatlah tanahnya yang kering dan ruangan yang agak gelap. Tanaman butuh apa ya untuk segar kembali?"
    },
    {
      "level": 2,
      "text": "Cobalah menyiram tanaman dengan gembor air dan buka tirai jendela agar sinar matahari masuk!"
    },
    {
      "level": 3,
      "text": "Siram air hingga indikator kelembapan berwarna hijau (70%), lalu geser tirai sampai sinar matahari cukup terang!"
    }
  ],
  "reflection": {
    "question": "Apa dua hal terpenting yang membuat bunga matahari segar kembali?",
    "options": [
      "Es krim dan kipas angin",
      "Air yang cukup dan sinar matahari",
      "Kegelapan dan batu bata"
    ],
    "correct_index": 1,
    "explanation": "Hebat! Air dan sinar matahari adalah sumber energi utama agar tanaman bisa tumbuh subur."
  }
}
```
