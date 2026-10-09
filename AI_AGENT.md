# AI AGENT GUIDE — MISSION KIDS
*The Single Source of Truth for Autonomous AI Coding Agents*

## 1. Project Mission & Identity
MISSION KIDS is an interactive, mission-based educational web platform for elementary school students (SD, ages 7–12).
- **Core Mantra:** *Learn. Explore. Solve.*
- **Learning Companion:** **MIKO** — Contextual socio-cognitive AI tutor delivering 3-tier scaffolding hints.
- **Tech Stack:** Semantic HTML5, Vanilla CSS3 (Custom Design System), Modern Vanilla JavaScript (ES6+), PHP 8.2+ Native (MVC architecture), MySQL / MariaDB (PDO Prepared Statements) with automatic SQLite dev fallback.

---

## 2. Core Directives for AI Agents

### 1. Read Documentation First
Before making substantial changes, you MUST read the corresponding document in `/docs`:
- Overview: [`docs/01_PROJECT_OVERVIEW.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/01_PROJECT_OVERVIEW.md)
- Product Requirements: [`docs/02_PRD.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/02_PRD.md)
- Design System: [`docs/03_DESIGN_SYSTEM.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/03_DESIGN_SYSTEM.md)
- System Architecture: [`docs/04_ARCHITECTURE.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/04_ARCHITECTURE.md)
- Database Plan: [`docs/05_DATABASE.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/05_DATABASE.md)
- Mission Engine: [`docs/06_MISSION_ENGINE.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/06_MISSION_ENGINE.md)
- AI & MIKO Behavior: [`docs/07_AI_BEHAVIOR.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/07_AI_BEHAVIOR.md)
- Security: [`docs/08_SECURITY.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/08_SECURITY.md)
- Testing: [`docs/09_TESTING.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/09_TESTING.md)
- Development Rules: [`docs/10_DEVELOPMENT_RULES.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/docs/10_DEVELOPMENT_RULES.md)

### 2. Guard the Aesthetic & Audience Experience
- **NO SaaS Dashboards:** Never generate standard corporate analytics cards, data tables, or grey admin panels. The student hub is an adventure headquarters.
- **NO Generic AI Look:** Avoid generic neon gradients on white cards, placeholder images that break offline, or emoji floods.
- **Visuals:** Use tactile 3D pushable buttons, friendly typography, and inline SVG illustrations for MIKO and game items.

### 3. Maintain Integrity of the Mission Engine
Do NOT create separate, isolated JavaScript engines for each mission. All missions run through `MissionEngine.js` leveraging configuration JSON files and modular handlers (`MatchSortHandler`, `SimulationHandler`, `SequenceHandler`).

### 4. Zero Point-of-Failure AI
The AI endpoint must always be resilient. If the LLM key is absent or network fails, MikoAiService MUST return the predefined pedagogical hint from `config_json`.

### 5. Always Update the Tracking Logs
- Record all major user prompts and milestones in [`PROMPT_LOG.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/PROMPT_LOG.md).
- Record all resolved technical bugs in [`DEBUG_LOG.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/DEBUG_LOG.md).
- Record architectural and design decisions in [`DECISIONS.md`](file:///C:/Users/HENDRIK%20WILDANSYAH/.gemini/antigravity-ide/scratch/mission-kids/DECISIONS.md).
