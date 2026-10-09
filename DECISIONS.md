# ARCHITECTURAL DECISIONS (ADR) — MISSION KIDS

---

### ADR 001: Technology Stack Selection
- **Decision:** Use PHP 8.2+ Native with structured MVC & clean front-controller routing, paired with Vanilla HTML5/CSS3/ES6 and MySQL (via PDO).
- **Context:** The project requires high stability, rapid execution on school computers, zero reliance on brittle node build steps, and easy maintenance.
- **Consequences:** Eliminates bundler bloat, provides instant page loads, and ensures compatibility with standard hosting and XAMPP/Apache/PHP-CLI environments.

---

### ADR 002: Contextual AI Scaffolding vs. Open Chatbot
- **Decision:** MIKO will operate strictly inside the mission canvas delivering 3-level progressive scaffolding hints, rather than an open-ended conversational chatbot page.
- **Context:** Children aged 7–12 easily get distracted or attempt to bypass critical thinking when an open AI chatbot gives answers directly. Furthermore, open chat poses child safety and PII risks.
- **Consequences:** The child learns through problem solving and metacognition. MIKO acts as an encouraging mentor, keeping attention focused on the mission objective.

---

### ADR 003: Reusable Declarative Mission Engine
- **Decision:** Implement a centralized `MissionEngine.js` state machine driving 7 distinct phases, parameterized through structured JSON configs.
- **Context:** Building 9 missions from scratch with duplicate logic would lead to high technical debt, inconsistent UX, and bug proliferation.
- **Consequences:** Adding a new mission only requires writing a JSON config file and choosing one of the 3 interaction handlers (`match_sort`, `experiment_simulation`, `sequence_logic`).

---

### ADR 004: Dual-Layer AI Reliability (Zero Downtime)
- **Decision:** MikoAiService combines an external LLM API gateway with an instant deterministic fallback to curated pedagogical hints in `config_json`.
- **Context:** Schools frequently experience flaky internet or API quota depletion. The educational experience must never halt due to a network error.
- **Consequences:** If the external LLM key is absent or times out, MIKO delivers the fallback hint in milliseconds, maintaining a 100% smooth student journey.

---

### ADR 005: Cross-Database Resilience (MySQL + SQLite Dev Fallback)
- **Decision:** The PDO connection layer defaults to MySQL/MariaDB on `localhost:3306`, but includes an automatic fallback to an internal SQLite database if MySQL is stopped.
- **Context:** Facilitates zero-configuration portability during development, demonstration, and automated test execution across diverse developer environments.
- **Consequences:** Zero blockers during testing while strictly adhering to relational SQL standards.

---

### ADR 006: Mobile Thumb Ergonomics & Bottom Navigation Bar
- **Decision:** Implement a sticky bottom navigation bar (`.mobile-bottom-nav`) on screens `<= 768px` for primary student navigation, with MIKO floating safely above it (`bottom: 78px; right: 12px;`), and fluid clamp-based sizing on interactive game viewports.
- **Context:** Children aged 7–12 frequently operate mobile phones and compact tablets using one or two thumbs. Top navigation links on small screens are cumbersome to reach, and fixed-pixel grids cause horizontal scrolling.
- **Consequences:** Guarantees zero horizontal overflow, seamless one-thumb access to core screens, and fluid scaling of all 9 interactive mission canvases.
