# 01. PROJECT OVERVIEW — MISSION KIDS

## 1. Executive Summary

**MISSION KIDS** is an interactive, mission-based educational web platform designed specifically for elementary school children (*Siswa Sekolah Dasar / SD*, ages 7–12). Unlike conventional school learning management systems (LMS) that rely on dry multiple-choice quizzes, or pure gamified apps that sacrifice pedagogical depth for mindless reward loops, MISSION KIDS places children in the role of an active problem solver and explorer.

The fundamental premise of MISSION KIDS is:

> **Anak belajar dengan menghadapi sebuah misi atau masalah nyata, mengeksplorasi informasi pendukung, melakukan aktivitas interaktif, memecahkan tantangan melalui simulasi, mendapatkan feedback yang membangun, dan merefleksikan apa yang telah dipelajari.**

---

## 2. Brand Identity & Product Positioning

| Element | Description |
| :--- | :--- |
| **Product Name** | **MISSION KIDS** |
| **Tagline** | *Your Mission Starts Here.* |
| **Core Mantra** | *Learn. Explore. Solve.* |
| **Target Audience (Primary)** | Elementary school students (SD Kelas 1–6, usia 7–12 tahun) |
| **Target Audience (Secondary)** | Orang tua, guru SD, dan dewan juri/evaluator kompetisi edukasi teknologi |
| **Learning Companion** | **MIKO** — A friendly, robotic-organic AI learning buddy providing scaffolded hints rather than direct answers |
| **Tone of Voice** | Friendly, encouraging, adventurous, clear, intellectually empowering, respectful |

### Official Pitch to Stakeholders & Evaluators
> *"MISSION KIDS adalah platform pembelajaran interaktif berbasis misi untuk anak SD. Anak tidak hanya menjawab soal kuis, melainkan diterjunkan ke dalam skenario misi kontekstual, bereksplorasi dengan objek interaktif, melakukan eksperimen sebab-akibat, memecahkan tantangan logika, dan merefleksikan makna pembelajaran. Karakter AI pendamping bernama MIKO hadir memberikan scaffolding (bantuan bertahap) tanpa pernah membocorkan jawaban secara cuma-cuma."*

---

## 3. Core Philosophy & Guiding Principles

### Principle 01: Learning First
Every interaction, screen, and button must serve a clear educational objective. We do not incorporate flashy animations or mechanics merely because they look impressive; every activity must foster genuine conceptual understanding (e.g. understanding *why* a plant withers without sunlight rather than memorizing a definition).

### Principle 02: Playful but Not Childish
The interface is designed for 21st-century digital natives. It avoids childish clutter, chaotic rainbow gradients, emoji floods, and generic SaaS dashboard widgets. Instead, it offers a clean, modern, adventure-game feel with intentional typography, spacious layouts, thematic color systems, and rich micro-interactions.

### Principle 03: Scaffolding, Not Cheating (AI MIKO)
MIKO is neither a generic freeform chatbot nor an answer dispenser. MIKO acts as a socio-cognitive tutor that implements pedagogical scaffolding across 3 progressive levels:
1. **Level 1 (Konseptual):** Sparking curiosity and reminding the student of natural rules.
2. **Level 2 (Spesifik):** Pointing the student's attention to key interactive variables.
3. **Level 3 (Aksi Terbimbing):** Giving direct directional hints towards the solution.

### Principle 04: Robustness & Zero Single-Point-of-Failure
AI enhancement is an intelligent layer on top of a rock-solid core. If the AI API is unreachable or rate-limited, MIKO falls back gracefully to deterministic rule-based pedagogic hints. The student's learning progress is never halted by an external network error.

---

## 4. The Core Learning Loop

Every mission in MISSION KIDS strictly adheres to this closed-loop learning architecture:

```text
       ┌───────────────┐
       │    MISSION    │  (Briefing problem scenario)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │     STORY     │  (Contextual narrative hook)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │    EXPLORE    │  (Interactive sandbox / observation)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │     LEARN     │  (Bite-sized core concepts)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │   INTERACT    │  (Simulation / hands-on task)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │   CHALLENGE   │  (Problem-solving trial)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │   FEEDBACK    │  (Immediate visual & verbal response)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │  REFLECTION   │  (Active recall & metacognition)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │    REWARD     │  (XP, badges, completion badge)
       └───────┬───────┘
               ▼
       ┌───────────────┐
       │   PROGRESS    │  (Unlocking next node on Mission Map)
       └───────────────┘
```

---

## 5. The Three Learning Worlds

| World | Name | Thematic Domain | Primary Skills Cultivated |
| :--- | :--- | :--- | :--- |
| **World 01** | **Number City** | Numeracy & Arithmetic Adventures | Mental math, counting currency, pattern recognition, spatial numbers |
| **World 02** | **Discovery Lab** | Natural Sciences & Cause-and-Effect | Scientific observation, plant biology, optics & light/shadow, water cycle |
| **World 03** | **Thinking Lab** | Computational & Logical Thinking | Sequential instructions, condition branching, loop patterns, spatial navigation |

---

## 6. Target Technology Stack

- **Client Layer:** Semantic HTML5, Vanilla CSS3 (Custom Design System with CSS variables, zero Tailwind dependency for maximum visual fidelity and maintenance), Modern Modular ES6 JavaScript (Touch & mouse friendly).
- **Application Server:** PHP 8.2+ Native (Object-Oriented Architecture, MVC patterns, clean router, modular API endpoints, secure sessions).
- **Data Persistence:** Relational MySQL / MariaDB (Prepared Statements via PDO, transactional integrity, foreign key constraints) with optional automatic SQLite fallback for lightweight development portability.
- **AI Gateway:** Server-side proxy integrating LLM APIs (Gemini/Groq/OpenAI compatible) with structured kid-safe system prompts and deterministic offline fallback.
