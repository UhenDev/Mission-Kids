# 10. DEVELOPMENT RULES & QUALITY STANDARDS — MISSION KIDS

## 1. Coding Standards & Conventions

### 1.1 PHP (Backend)
- Standard: Modern PHP 8.2+ with strict typing where appropriate (`declare(strict_types=1);`).
- Naming:
  - Classes: PascalCase (e.g., `MissionProgressService`, `AuthController`).
  - Methods & Variables: camelCase (e.g., `getMissionById()`, `$currentLevel`).
  - Database Columns & Tables: snake_case (e.g., `user_id`, `created_at`).
  - Constants: UPPER_SNAKE_CASE (e.g., `MAX_HINT_LEVEL`).
- Architecture: Strict Separation of Concerns (Controller handles HTTP/Routing, Service handles business logic, Repository/Model handles DB queries, Views handle semantic HTML).
- Output Escaping: Never echo raw `$_POST` or database values directly. Always wrap with the `e()` escape helper.

### 1.2 CSS & Design System
- Structure: Modular CSS files (`design-system.css`, `components.css`, `missions.css`, `worlds.css`).
- Custom Properties: Always consume `--color-*`, `--space-*`, and `--radius-*` tokens. Never introduce arbitrary inline hex colors.
- Responsive Units: Use `rem` for typography and spacing, `px` for borders and subtle hair-lines, `%` / `fr` / `clamp()` for fluid layout grids.
- Mobile Touch: Minimum target size of `48px` x `48px` for primary interactive elements.

### 1.3 JavaScript (Frontend)
- Vanilla Modern ES6+: Classes, modules, template literals, async/await, and native DOM APIs.
- No heavy frameworks (no React, Vue, or bulky bundlers) unless explicitly requested; raw native browser performance ensures instant load times on school devices.
- State Immutability: Mutate game state through explicit engine actions to maintain predictable replay and undo behavior.

---

## 2. Visual Quality Control (VQC) Checklist

Before any view or screen is marked as complete, verify:
- [ ] **Adventure Feel:** Does this screen feel like a warm, joyful mission hub, or does it feel like a corporate admin dashboard? (If it looks like a SaaS dashboard, redesign immediately).
- [ ] **Whitespace & Balance:** Is there comfortable breathing room around elements without cramping or giant empty voids?
- [ ] **Visual Feedback:** Do interactive buttons compress with a satisfying `:active` depth?
- [ ] **Contrast:** Is text crisp and legible on light and colored surfaces?
- [ ] **No Placeholder Images:** Are all characters, icons, and illustrations rendered via crisp inline SVGs or verified vector assets?
- [ ] **No Emoji Overload:** Emojis are used only as playful accent markers, never as structural navigation buttons.

---

## 3. Definition of Done (DoD)

A user story or feature is considered **Done** only when:
1. **Functional Correctness:** All happy paths and edge cases work according to the PRD.
2. **Visual Fidelity:** Complies 100% with the Mission Kids Design System.
3. **Resilience:** Graceful handling of network timeouts, invalid inputs, and AI service unavailability.
4. **Security Verified:** Parameters passed via PDO prepared statements, user input escaped with `e()`, CSRF tokens validated.
5. **Responsive Integrity:** Tested and validated on Mobile (375px/412px), Tablet (768px), and Desktop (1024px+).
6. **Self-Documenting Code:** Clean naming, no dead code or commented-out blocks, clear documentation.
