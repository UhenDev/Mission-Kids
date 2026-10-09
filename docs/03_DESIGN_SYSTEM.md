# 03. DESIGN SYSTEM — MISSION KIDS

## 1. Design Philosophy: "Playful Precision"
MISSION KIDS adheres to the **Playful Precision** design philosophy:
- **Playful:** Warm, rounded, inviting, tactile, and rewarding to touch and explore.
- **Precision:** Clean, organized typography, intentional whitespace, zero chaotic visual clutter, and accessible contrast ratios (WCAG AA compliant).
- **Anti-Patterns Strictly Avoided:**
  - ❌ No dry SaaS table grids or enterprise sidebar layouts.
  - ❌ No overwhelming rainbow gradients on every component.
  - ❌ No reliance on emojis as primary UI buttons or navigation icons.
  - ❌ No brittle external placeholder image URLs that could break offline.

---

## 2. Design Tokens (CSS Custom Properties)

```css
:root {
  /* Core Brand Colors */
  --color-brand-primary: #2563EB;        /* Adventure Blue */
  --color-brand-primary-hover: #1D4ED8;
  --color-brand-primary-light: #EFF6FF;
  --color-brand-secondary: #F59E0B;      /* Spark Yellow */
  --color-brand-secondary-hover: #D97706;
  --color-brand-accent: #10B981;         /* Discovery Mint */
  --color-brand-coral: #EF4444;          /* Energy Coral */

  /* Neutral & Canvas Tones */
  --color-bg-app: #F8FAFC;               /* Crisp Cloud White */
  --color-bg-card: #FFFFFF;
  --color-bg-elevated: #F1F5F9;
  --color-border-subtle: #E2E8F0;
  --color-border-interactive: #CBD5E1;
  --color-text-main: #0F172A;            /* Deep Midnight Charcoal */
  --color-text-muted: #64748B;           /* Friendly Slate */
  --color-text-inverse: #FFFFFF;

  /* World 01: Number City Colors */
  --world-number-primary: #F59E0B;
  --world-number-deep: #B45309;
  --world-number-bg: #FEF3C7;
  --world-number-border: #FCD34D;

  /* World 02: Discovery Lab Colors */
  --world-discovery-primary: #10B981;
  --world-discovery-deep: #047857;
  --world-discovery-bg: #D1FAE5;
  --world-discovery-border: #6EE7B7;

  /* World 03: Thinking Lab Colors */
  --world-thinking-primary: #6366F1;
  --world-thinking-deep: #4338CA;
  --world-thinking-bg: #E0E7FF;
  --world-thinking-border: #A5B4FC;

  /* Companion MIKO Theme */
  --miko-body-color: #38BDF8;
  --miko-accent-color: #FBBF24;
  --miko-screen-bg: #0F172A;
  --miko-eye-glow: #22D3EE;

  /* Typography Scale */
  --font-sans: 'Plus Jakarta Sans', 'Nunito', system-ui, -apple-system, sans-serif;
  --font-display: 'Fredoka', 'Plus Jakarta Sans', cursive, sans-serif;
  
  --fs-xs: 0.75rem;    /* 12px */
  --fs-sm: 0.875rem;   /* 14px */
  --fs-base: 1rem;     /* 16px */
  --fs-md: 1.125rem;   /* 18px */
  --fs-lg: 1.25rem;    /* 20px */
  --fs-xl: 1.5rem;     /* 24px */
  --fs-2xl: 1.875rem;  /* 30px */
  --fs-3xl: 2.25rem;   /* 36px */
  --fs-4xl: 3rem;      /* 48px */

  /* Spacing Scale */
  --space-1: 0.25rem;  /* 4px */
  --space-2: 0.5rem;   /* 8px */
  --space-3: 0.75rem;  /* 12px */
  --space-4: 1rem;     /* 16px */
  --space-5: 1.25rem;  /* 20px */
  --space-6: 1.5rem;   /* 24px */
  --space-8: 2rem;     /* 32px */
  --space-10: 2.5rem;  /* 40px */
  --space-12: 3rem;    /* 48px */

  /* Corner Radii */
  --radius-sm: 0.5rem;   /* 8px */
  --radius-md: 0.75rem;  /* 12px */
  --radius-lg: 1rem;     /* 16px */
  --radius-xl: 1.5rem;   /* 24px */
  --radius-2xl: 2rem;    /* 32px */
  --radius-pill: 9999px;

  /* Tactile Shadows & Physical Depth */
  --shadow-sm: 0 2px 4px rgba(15, 23, 42, 0.05);
  --shadow-md: 0 4px 12px rgba(15, 23, 42, 0.08);
  --shadow-lg: 0 10px 25px -5px rgba(15, 23, 42, 0.1);
  --shadow-button-primary: 0 4px 0 #1D4ED8;
  --shadow-button-success: 0 4px 0 #047857;
  --shadow-button-amber: 0 4px 0 #B45309;
  --shadow-button-active: 0 0 0 transparent;

  /* Transitions */
  --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
  --transition-bounce: 300ms cubic-bezier(0.34, 1.56, 0.64, 1);
}
```

---

## 3. Tactile Component System

### 3.1 Kid-Friendly "Pushable" Buttons
Kids love buttons that feel physical and respond immediately. Our button system features a 3D bottom bevel shadow that compresses on `:active` with an audible/visual click sensation:

```css
.btn-kid {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: var(--space-2);
  padding: 0.75rem 1.5rem;
  font-family: var(--font-display);
  font-size: var(--fs-md);
  font-weight: 600;
  border-radius: var(--radius-pill);
  border: 2px solid transparent;
  cursor: pointer;
  transition: transform var(--transition-fast), box-shadow var(--transition-fast);
  user-select: none;
  min-height: 48px; /* High touch target guarantee */
}

.btn-kid:active {
  transform: translateY(3px);
}

.btn-kid-primary {
  background-color: var(--color-brand-primary);
  color: var(--color-text-inverse);
  box-shadow: var(--shadow-button-primary);
}

.btn-kid-primary:active {
  box-shadow: var(--shadow-button-active);
}
```

### 3.2 Chunky Progress Bar
For XP and mission progression, progress bars feature a dual-tone fill with a subtle diagonal gloss highlight that signals energy and momentum:
- Border radius: `--radius-pill`
- Height: 20px (touch-visible)
- Fill animation: Smooth width tweening (duration 600ms, bounce easing).

### 3.3 MIKO Interactive Speech Bubble
When MIKO offers encouragement or hints, a speech bubble anchors to MIKO with a directional pointer triangle:
- Background: Pure White with subtle soft cyan border (`#E0F2FE`)
- Typography: Readable 16px with friendly line height (1.6)
- Animation: Gentle pop-in scale from 0.85 to 1.0 with a soft bounce.

---

## 4. MIKO Character Specification

MIKO is represented as an expressive, high-tech yet endearing personal study companion. Built using lightweight, scalable SVG vectors directly embedded in the DOM:

```text
    ╭───[ 💡 Antena Sensor ]───╮
    │                          │
    │      ╭────────────╮      │
    │      │  ◉      ◉  │  ◀── Expressive LED Eyes (Blink / Smile)
    │      ╰────────────╯      │
    │       \__________/   ◀── Animated Screen Smile
    │                          │
    ╰───────────┬──────────────╯
          ╭─────┴─────╮
          │  ✦ MIKO ✦ │
          ╰───────────╯
```

### Character States
1. **Idle / Waiting (`miko-idle`):** Eyes blink every 4 seconds, gentle subtle floating bob animation (2s ease-in-out infinite).
2. **Thinking (`miko-thinking`):** Eyes change to swirling gear dots, antenna light pulses cyan.
3. **Encouraging (`miko-happy`):** Eyes form smiling inverted crescents `^^`, slight upward bounce.
4. **Delivering Hint (`miko-hint`):** Speech bubble opens with a gentle chime, antenna flashes amber.
5. **Cheering (`miko-cheer`):** Confetti burst around MIKO, hands raise high.

---

## 5. Visual Hierarchy & Spacing Rhythm
- **Header:** Lightweight floating pill bar with Logo, Current World indicator, and Student XP pill.
- **Main Mission Canvas:** Generous padding (24px to 32px), bordered container with soft colored inset.
- **Action Tray:** Bottom-docked container with prominent, unmistakable primary action buttons (e.g. *"JALANKAN ROBOT!"*, *"PERIKSA JAWABAN"*).
