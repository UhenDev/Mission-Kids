# 04. SYSTEM ARCHITECTURE — MISSION KIDS

## 1. Architectural Overview
MISSION KIDS is engineered as an ultra-fast, maintainable, and dependency-light educational platform. It couples a modern modular client-side Single-Page Mission Engine with a secure, lightweight PHP 8.2+ Native backend and MySQL relational persistence.

```text
┌────────────────────────────────────────────────────────────────────────┐
│                          CLIENT TIER (BROWSER)                         │
│                                                                        │
│  ┌─────────────────┐   ┌────────────────────┐   ┌───────────────────┐  │
│  │   UI Renderer   │   │   Mission Engine   │   │  MIKO Companion   │  │
│  │  (Vanilla DOM)  │   │  (7-Step Lifecycle)│   │  (Scaffolding UI) │  │
│  └────────┬────────┘   └─────────┬──────────┘   └─────────┬─────────┘  │
│           │                      │                        │            │
│           └──────────────────────┼────────────────────────┘            │
│                                  │ (JSON Fetch / REST)                 │
└──────────────────────────────────┼─────────────────────────────────────┘
                                   │
                                   ▼
┌────────────────────────────────────────────────────────────────────────┐
│                        APPLICATION TIER (PHP 8.2+)                     │
│                                                                        │
│  ┌──────────────────────────────────────────────────────────────────┐  │
│  │                     Front Controller (index.php)                 │  │
│  │                     Router & Session Auth Guard                  │  │
│  └──────────────────┬─────────────────────────────┬─────────────────┘  │
│                     │                             │                    │
│      ┌──────────────┴──────────────┐   ┌──────────┴───────────────┐    │
│      │     Page Controllers        │   │       REST API API       │    │
│      │ (Home, Worlds, Mission, ..) │   │ (Missions, Hint, XP, ..) │    │
│      └──────────────┬──────────────┘   └──────────┬───────────────┘    │
│                     │                             │                    │
│      ┌──────────────┴─────────────────────────────┴───────────────┐    │
│      │                     Service & Domain Layer                 │    │
│      │    (AuthService, MissionService, GamificationService)      │    │
│      └──────────────────────────────┬─────────────────────────────┘    │
│                                     │                                  │
│             ┌───────────────────────┴───────────────────────┐          │
│             ▼                                               ▼          │
│  ┌─────────────────────┐                         ┌──────────────────┐  │
│  │ Database Repository │                         │  AI Gateway API  │  │
│  │    (PDO Prepared)   │                         │(Gemini/Groq/Open)│  │
│  └──────────┬──────────┘                         └─────────┬────────┘  │
└─────────────┼──────────────────────────────────────────────┼───────────┘
              │                                              │
              ▼                                              ▼
┌───────────────────────────┐                  ┌─────────────────────────┐
│     PERSISTENCE TIER      │                  │     EXTERNAL AI API     │
│   MySQL 10.4+ / MariaDB   │                  │  (Server-to-Server SSL) │
│ (Users, Missions, XP, ..) │                  │  (Strict Guardrails)    │
└───────────────────────────┘                  └─────────────────────────┘
```

---

## 2. Directory Layout

```text
mission-kids/
├── config/
│   ├── config.php             # Core app settings, database credentials, AI keys
│   └── database.php           # PDO connection factory (MySQL with SQLite fallback)
├── database/
│   ├── schema.sql             # Relational table definitions (DDL)
│   └── seeds.sql              # Initial worlds, 9 missions, and badges data
├── docs/                      # Architectural and specifications source of truth
├── src/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── HomeController.php
│   │   ├── WorldController.php
│   │   ├── MissionController.php
│   │   └── ApiController.php
│   ├── Services/
│   │   ├── AuthService.php
│   │   ├── MissionProgressService.php
│   │   ├── GamificationService.php
│   │   └── MikoAiService.php
│   └── Helpers/
│       ├── Security.php       # XSS escaping, CSRF generator, input sanitizer
│       └── Session.php        # Secure session manager
├── templates/
│   ├── layouts/
│   │   ├── header.php         # Navigation, XP badge, MIKO status
│   │   └── footer.php
│   ├── pages/
│   │   ├── landing.php
│   │   ├── auth/login.php
│   │   ├── auth/register.php
│   │   ├── student/home.php
│   │   ├── student/worlds.php
│   │   ├── student/mission_play.php
│   │   ├── student/achievements.php
│   │   └── student/progress.php
│   └── components/
│       ├── miko_bubble.php
│       └── xp_modal.php
├── public/
│   ├── index.php              # Central entry point & light router
│   ├── css/
│   │   ├── design-system.css  # Variables, reset, typography
│   │   ├── components.css     # Buttons, cards, bubbles, meters
│   │   ├── missions.css       # Mission canvas, interactive trays
│   │   └── worlds.css         # Adventure world theme skins
│   ├── js/
│   │   ├── app.js             # General page scripts, notifications
│   │   ├── engine/
│   │   │   ├── MissionEngine.js      # Core state machine & flow runner
│   │   │   ├── InteractionHandler.js # Drag-drop, simulator, sequencer
│   │   │   └── MikoCompanion.js      # Hint fetcher, speech animations
│   │   └── missions/
│   │       ├── world1_number_city.js
│   │       ├── world2_discovery_lab.js
│   │       └── world3_thinking_lab.js
│   └── assets/
│       └── svg/               # Scalable, zero-breakage inline SVGs
├── AI_AGENT.md
├── PROMPT_LOG.md
├── DEBUG_LOG.md
└── DECISIONS.md
```

---

## 3. Request Lifecycle & Routing
1. All browser requests hit `/public/index.php`.
2. The front controller initiates session hardening (`cookie_httponly`, `samesite=Lax`).
3. Routing parses the URL query parameter `?page=` or route path.
4. If a page requires student authentication, `AuthGuard` verifies `$_SESSION['user_id']`. Unauthenticated users are redirected to `?page=login`.
5. API requests (`?page=api&action=...`) return strictly formatted JSON with standard response envelopes:
   ```json
   {
     "success": true,
     "data": { ... },
     "error": null
   }
   ```

---

## 4. Frontend Mission Engine Architecture
The mission gameplay runs client-side to guarantee instantaneous 60fps tactile feedback for children:
1. **MissionEngine:** State machine handling phases: `STORY` → `LEARN` → `ACTIVITY` → `CHALLENGE` → `FEEDBACK` → `REFLECTION` → `REWARD`.
2. **InteractionHandler:** Modular sub-controllers for the 3 interaction paradigms:
   - `MatchSortHandler` (Drag & drop / tap & assign)
   - `SimulationHandler` (Sliders, light/water/sun toggles with real-time SVG updates)
   - `SequenceHandler` (Command block queue, step-by-step robot playback)
3. **MikoCompanion:** Listens to attempt events. If attempts fail twice, MIKO gently wakes up and offers Hint Level 1 without blocking the screen.
4. **Completion Syncer:** Dispatches a signed POST request to `/api?action=complete_mission` with attempt counts, hint usage, and reflection answer to compute XP and unlock the next world node atomically.
