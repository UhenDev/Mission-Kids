# 09. QUALITY ASSURANCE & TESTING PLAN — MISSION KIDS

## 1. Testing Philosophy
Every component of MISSION KIDS undergoes rigorous verification to guarantee that elementary school children encounter a seamless, joyful, and bug-free educational experience. Testing encompasses functional correctness, responsive layout integrity, touch interaction ergonomics, and error resilience.

---

## 2. Test Execution Matrix

### 2.1 Functional Test Suite

| Test ID | Module | Scenario | Expected Result | Pass Criteria |
| :--- | :--- | :--- | :--- | :--- |
| **TC-AUTH-01** | Auth | Register new student with valid username & password | Account created in DB, auto-logged in, redirected to Onboarding / Student Home | Session established, profile initialized |
| **TC-AUTH-02** | Auth | Register with existing duplicate username | Shows friendly error *"Nama panggilan ini sudah ada, pilih nama lain ya!"* | No DB error, form preserved |
| **TC-AUTH-03** | Auth | Login with incorrect password | Shows friendly error *"Kata sandi belum tepat, coba ingat-ingat lagi!"* | 401 response handled smoothly |
| **TC-HOME-01** | Student Home | View Student Home after registration | Greeting displays student nickname, avatar, Level 1, 0 XP, and active World 1 | Data matches DB profile |
| **TC-ENG-01** | Engine | Launch Mission 2.1 ("Tanaman Layu") | Story modal opens, shows briefing and MIKO in dialogue state | Mission loads initial moisture/sunlight |
| **TC-ENG-02** | Engine | Simulate plant watering & sunlight adjustment | Visual SVG plant reacts live: stem lifts, leaves turn green as values enter target range | Simulation values update at 60fps |
| **TC-ENG-03** | Engine | Request MIKO Hint 1 | MIKO opens bubble with conceptual question, hints_used increments | No answer revealed, encouraging tone |
| **TC-ENG-04** | Engine | Complete mission challenge & answer reflection | Celebration confetti triggers, XP dialog appears (+100 XP + bonuses), next node unlocks | DB records attempt, XP updated |
| **TC-ROBOT-01**| Engine | Run sequence commands in "Robot Pulang" | Robot moves along grid tile-by-tile with animated steps matching card queue | Robot reaches dock, victory sound/cue |
| **TC-FALLBACK**| AI Companion | Disconnect external internet / disable AI key | MIKO instantly delivers predefined pedagogical hint from mission config | Zero 500 error, zero delay |

---

## 3. Responsive & Device Ergonomics

### Test Viewport Profiles
1. **Mobile Small (375px - 412px):** iPhone SE / Android compact.
   - *Verification:* Nav bar compresses to friendly mobile header; button sizes remain >= 48px; mission canvas fits without horizontal scroll overflow.
2. **Tablet (768px - 820px):** iPad / Android tablet (very common in elementary schools).
   - *Verification:* Split-panel mission view (Controls on left/bottom, Simulation SVG centered).
3. **Desktop (1024px - 1440px):** Classroom PC / Chromebook.
   - *Verification:* High-resolution vector assets, comfortable keyboard navigation, generous whitespace.

---

## 4. Input Method Validation (Touch & Mouse)
- **Drag-and-Drop:** Verified with HTML5 Drag API and Touch Drag Events.
- **Tap-to-Assign Alternative:** On touch screens where drag-and-drop can sometimes be finicky for small hands, tapping an item selects it, and tapping the target slot immediately drops it in place.

---

## 5. Automated Health Check & Diagnostic Script
A diagnostic command runner (`test_suite.php`) is provided in the repository to automatically verify:
1. Database connectivity and schema integrity.
2. Seed data presence (3 worlds, 9 missions, 5 badges).
3. Session and CSRF security functions.
4. MikoAiService fallback behavior.
