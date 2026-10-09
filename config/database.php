<?php
/**
 * MISSION KIDS — Database Connection Factory
 * Provides PDO connection with automatic MySQL -> SQLite fallback.
 */

declare(strict_types=1);

class Database
{
    private static ?PDO $instance = null;
    private static string $driverUsed = 'none';

    public static function getConnection(): PDO
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $config = require __DIR__ . '/config.php';
        $dbConfig = $config['db'];

        // Attempt 1: Connect to MySQL
        try {
            $dsn = sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $dbConfig['host'],
                $dbConfig['port'],
                $dbConfig['database'],
                $dbConfig['charset']
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_TIMEOUT => 2,
            ];

            self::$instance = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
            self::$driverUsed = 'mysql';
            return self::$instance;
        } catch (PDOException $e) {
            // Check if error is unknown database (1049) -> try to auto-create
            if ($e->getCode() === 1049 || str_contains($e->getMessage(), 'Unknown database')) {
                try {
                    $rootDsn = sprintf('mysql:host=%s;port=%d;charset=%s', $dbConfig['host'], $dbConfig['port'], $dbConfig['charset']);
                    $tempPdo = new PDO($rootDsn, $dbConfig['username'], $dbConfig['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
                    $tempPdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbConfig['database']}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                    
                    self::$instance = new PDO($dsn, $dbConfig['username'], $dbConfig['password'], $options);
                    self::$driverUsed = 'mysql';
                    return self::$instance;
                } catch (Exception $inner) {
                    // Fall through to SQLite
                }
            }

            // Attempt 2: Fallback to SQLite for zero-downtime portability
            $sqlitePath = $dbConfig['sqlite_path'];
            $sqliteDir = dirname($sqlitePath);
            if (!is_dir($sqliteDir)) {
                mkdir($sqliteDir, 0777, true);
            }

            self::$instance = new PDO('sqlite:' . $sqlitePath, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            self::$instance->exec('PRAGMA foreign_keys = ON;');
            self::$driverUsed = 'sqlite';
            return self::$instance;
        }
    }

    public static function getDriverUsed(): string
    {
        return self::$driverUsed;
    }
}
