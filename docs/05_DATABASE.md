# 05. DATABASE PLAN & SCHEMA SPECIFICATION — MISSION KIDS

## 1. Schema Design Principles
The MISSION KIDS database is designed with relational rigor:
- **Foreign Key Constraints:** Cascade or restrict integrity checks across student profiles, attempts, and XP.
- **Atomic Progress Updates:** Mission completion and XP award updates execute within a database transaction.
- **JSON Column for Mission Configuration:** Each mission stores its interactive payload (e.g. initial inventory, goal targets, grid obstacles) in `config_json`, allowing new missions to be configured without schema migrations.
- **Cross-Engine Compatibility:** The SQL schema utilizes standard ANSI SQL conventions, allowing seamless execution on both MariaDB/MySQL and SQLite.

---

## 2. Entity Relationship Diagram (ERD)

```text
┌─────────────────┐       1:1       ┌─────────────────┐
│      users      ├─────────────────┤    profiles     │
└────────┬────────┘                 └────────┬────────┘
         │ 1                                 │ 1
         │                                   │
         ▼ *                                 ▼ *
┌─────────────────┐                 ┌─────────────────┐
│ xp_transactions │                 │user_achievements│
└─────────────────┘                 └────────▲────────┘
                                             │ *
┌─────────────────┐       1:*       ┌────────┴────────┐
│     worlds      ├─────────────────┤  achievements   │
└────────┬────────┘                 └─────────────────┘
         │ 1
         ▼ *
┌─────────────────┐       1:*       ┌─────────────────┐
│    missions     ├─────────────────┤mission_progress │
└────────┬────────┘                 └─────────────────┘
         │ 1
         ▼ *
┌─────────────────┐
│mission_attempts │
└─────────────────┘
```

---

## 3. Data Dictionary

### Table: `users`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT UNSIGNED | PK, AUTO_INCREMENT | Unique user identifier |
| `username` | VARCHAR(50) | UNIQUE, NOT NULL | Child-friendly login name (e.g. `rian_juara`) |
| `password_hash` | VARCHAR(255) | NOT NULL | Securely hashed password (`PASSWORD_DEFAULT` / Bcrypt) |
| `role` | ENUM('student', 'parent', 'admin') | DEFAULT 'student' | User authorization role |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Registration timestamp |
| `updated_at` | DATETIME | ON UPDATE CURRENT_TIMESTAMP | Last modification |

### Table: `profiles`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT UNSIGNED | PK, AUTO_INCREMENT | Profile ID |
| `user_id` | INT UNSIGNED | UNIQUE, FK -> users(id) | Linked user account |
| `nickname` | VARCHAR(60) | NOT NULL | Friendly display name |
| `avatar_id` | VARCHAR(30) | DEFAULT 'astro_cat' | Selected avatar identifier |
| `current_level` | INT UNSIGNED | DEFAULT 1 | Student rank (1 to 5) |
| `total_xp` | INT UNSIGNED | DEFAULT 0 | Cumulative experience points |
| `preferred_world_id` | INT UNSIGNED | NULL, FK -> worlds(id) | Onboarding preference |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Creation timestamp |
| `updated_at` | DATETIME | ON UPDATE CURRENT_TIMESTAMP | Update timestamp |

### Table: `worlds`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT UNSIGNED | PK, AUTO_INCREMENT | World identifier |
| `slug` | VARCHAR(50) | UNIQUE, NOT NULL | e.g. `number-city`, `discovery-lab` |
| `title` | VARCHAR(100) | NOT NULL | World title (e.g. "Number City") |
| `subtitle` | VARCHAR(150) | NOT NULL | Short thematic summary |
| `theme_color` | VARCHAR(20) | NOT NULL | Hex or CSS token |
| `sort_order` | INT UNSIGNED | DEFAULT 1 | Display ordering |
| `is_active` | TINYINT(1) | DEFAULT 1 | Availability toggle |

### Table: `missions`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT UNSIGNED | PK, AUTO_INCREMENT | Mission ID |
| `world_id` | INT UNSIGNED | NOT NULL, FK -> worlds(id) | Associated world |
| `slug` | VARCHAR(60) | UNIQUE, NOT NULL | e.g. `toko-kue`, `tanaman-layu` |
| `title` | VARCHAR(120) | NOT NULL | Mission display title |
| `subtitle` | VARCHAR(200) | NOT NULL | Short challenge hook |
| `learning_objective` | TEXT | NOT NULL | Pedagogical focus statement |
| `interaction_type` | VARCHAR(40) | NOT NULL | `match_sort`, `simulation`, `sequence_logic` |
| `xp_reward` | INT UNSIGNED | DEFAULT 100 | Base XP awarded on clear |
| `sort_order` | INT UNSIGNED | DEFAULT 1 | Node position in world map |
| `config_json` | LONGTEXT | NOT NULL | JSON payload with story, tools, goals, hints |
| `is_active` | TINYINT(1) | DEFAULT 1 | Active status |

### Table: `mission_progress`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT UNSIGNED | PK, AUTO_INCREMENT | Progress ID |
| `user_id` | INT UNSIGNED | NOT NULL, FK -> users(id) | Student ID |
| `mission_id` | INT UNSIGNED | NOT NULL, FK -> missions(id) | Mission ID |
| `status` | ENUM('locked', 'available', 'completed') | DEFAULT 'locked' | World map unlock status |
| `stars` | TINYINT UNSIGNED | DEFAULT 0 | 1 to 3 stars rating |
| `completed_at` | DATETIME | NULL | Timestamp of first completion |
| `updated_at` | DATETIME | ON UPDATE CURRENT_TIMESTAMP | Last activity timestamp |

### Table: `mission_attempts`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT UNSIGNED | PK, AUTO_INCREMENT | Attempt ID |
| `user_id` | INT UNSIGNED | NOT NULL, FK -> users(id) | Student ID |
| `mission_id` | INT UNSIGNED | NOT NULL, FK -> missions(id) | Mission ID |
| `hints_used` | TINYINT UNSIGNED | DEFAULT 0 | Number of MIKO hints opened |
| `is_success` | TINYINT(1) | NOT NULL | 1 if completed, 0 if abandoned/failed |
| `reflection_answer` | TEXT | NULL | Selected or entered reflection insight |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Attempt timestamp |

### Table: `xp_transactions`
| Field | Type | Attributes | Description |
| :--- | :--- | :--- | :--- |
| `id` | INT UNSIGNED | PK, AUTO_INCREMENT | Transaction ID |
| `user_id` | INT UNSIGNED | NOT NULL, FK -> users(id) | Student ID |
| `amount` | INT | NOT NULL | XP granted (e.g. +100, +50, +20) |
| `source_type` | VARCHAR(50) | NOT NULL | `mission_clear`, `first_try_bonus`, etc. |
| `reference_id` | INT UNSIGNED | NULL | ID of linked mission or badge |
| `created_at` | DATETIME | DEFAULT CURRENT_TIMESTAMP | Award timestamp |

### Table: `achievements` & `user_achievements`
Standard badge system tracking criteria (`first_mission`, `world_complete_discovery`, etc.) and student unlock history.

---

## 4. DDL Script (MySQL / MariaDB & SQLite Compatible)

```sql
CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS profiles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    nickname VARCHAR(60) NOT NULL,
    avatar_id VARCHAR(30) NOT NULL DEFAULT 'astro_cat',
    current_level INT UNSIGNED NOT NULL DEFAULT 1,
    total_xp INT UNSIGNED NOT NULL DEFAULT 0,
    preferred_world_id INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS worlds (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(100) NOT NULL,
    subtitle VARCHAR(150) NOT NULL,
    theme_color VARCHAR(20) NOT NULL,
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    is_active TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS missions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    world_id INT UNSIGNED NOT NULL,
    slug VARCHAR(60) NOT NULL UNIQUE,
    title VARCHAR(120) NOT NULL,
    subtitle VARCHAR(200) NOT NULL,
    learning_objective TEXT NOT NULL,
    interaction_type VARCHAR(40) NOT NULL,
    xp_reward INT UNSIGNED NOT NULL DEFAULT 100,
    sort_order INT UNSIGNED NOT NULL DEFAULT 1,
    config_json LONGTEXT NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    FOREIGN KEY (world_id) REFERENCES worlds(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mission_progress (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    mission_id INT UNSIGNED NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'locked',
    stars TINYINT UNSIGNED NOT NULL DEFAULT 0,
    completed_at DATETIME NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_mission (user_id, mission_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS mission_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    mission_id INT UNSIGNED NOT NULL,
    hints_used TINYINT UNSIGNED NOT NULL DEFAULT 0,
    is_success TINYINT(1) NOT NULL,
    reflection_answer TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (mission_id) REFERENCES missions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS xp_transactions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    amount INT NOT NULL,
    source_type VARCHAR(50) NOT NULL,
    reference_id INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(60) NOT NULL UNIQUE,
    title VARCHAR(100) NOT NULL,
    description VARCHAR(255) NOT NULL,
    icon_name VARCHAR(50) NOT NULL,
    xp_reward INT UNSIGNED NOT NULL DEFAULT 50,
    criteria_type VARCHAR(50) NOT NULL,
    criteria_threshold INT UNSIGNED NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS user_achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    achievement_id INT UNSIGNED NOT NULL,
    unlocked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uq_user_achievement (user_id, achievement_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (achievement_id) REFERENCES achievements(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```
