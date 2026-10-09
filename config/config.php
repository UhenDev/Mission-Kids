<?php
/**
 * MISSION KIDS — Master Configuration
 */

declare(strict_types=1);

// Load .env file if present in project root
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile) && is_readable($envFile)) {
    $envLines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envLines as $line) {
        $trimmed = trim($line);
        if ($trimmed === '' || str_starts_with($trimmed, '#')) {
            continue;
        }
        if (str_contains($trimmed, '=')) {
            [$k, $v] = explode('=', $trimmed, 2);
            $k = trim($k);
            $v = trim($v, " \t\n\r\0\x0B\"'");
            if (!array_key_exists($k, $_ENV)) {
                putenv("{$k}={$v}");
                $_ENV[$k] = $v;
                $_SERVER[$k] = $v;
            }
        }
    }
}

return [
    'app' => [
        'name' => 'MISSION KIDS',
        'tagline' => 'Petualangan Misimu Dimulai di Sini.',
        'version' => '1.0.0',
        'env' => getenv('APP_ENV') ?: 'development',
        'base_url' => getenv('APP_URL') ?: '', // Auto-detected by router if empty
    ],
    'db' => [
        'driver' => getenv('DB_DRIVER') ?: 'mysql', // 'mysql' or 'sqlite'
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => (int)(getenv('DB_PORT') ?: 3306),
        'database' => getenv('DB_DATABASE') ?: 'mission_kids',
        'username' => getenv('DB_USERNAME') ?: 'root',
        'password' => getenv('DB_PASSWORD') !== false ? (string)getenv('DB_PASSWORD') : '',
        'charset' => 'utf8mb4',
        'sqlite_path' => getenv('DB_SQLITE_PATH') ?: (__DIR__ . '/../database/mission_kids.sqlite'),
    ],
    'ai' => [
        'enabled' => true,
        // Optional LLM API Key (Gemini, Groq, or OpenAI compatible)
        'api_key' => getenv('GEMINI_API_KEY') ?: '',
        'model' => getenv('AI_MODEL') ?: 'gemini-1.5-flash',
        'timeout_seconds' => (int)(getenv('AI_TIMEOUT') ?: 4),
        'fallback_enabled' => true, // 100% deterministic pedagogic fallback
    ],
    'session' => [
        'name' => 'mk_session_id',
        'lifetime' => 86400 * 7, // 7 days for students
    ],
    'gamification' => [
        'xp_mission_clear' => 100,
        'xp_first_try_bonus' => 50,
        'xp_hint_bonus' => 20,
        'xp_reflection_bonus' => 30,
        'levels' => [
            1 => ['name' => 'Penjelajah Pemula', 'min_xp' => 0, 'max_xp' => 199, 'badge' => '🌱'],
            2 => ['name' => 'Petualang Cilik', 'min_xp' => 200, 'max_xp' => 499, 'badge' => '🧭'],
            3 => ['name' => 'Penemu Pintar', 'min_xp' => 500, 'max_xp' => 899, 'badge' => '🔬'],
            4 => ['name' => 'Kapten Misi', 'min_xp' => 900, 'max_xp' => 1499, 'badge' => '⚡'],
            5 => ['name' => 'Master Explorer', 'min_xp' => 1500, 'max_xp' => 999999, 'badge' => '👑'],
        ]
    ]
];
