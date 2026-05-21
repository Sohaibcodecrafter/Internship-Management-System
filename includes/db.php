<?php
/**
 * Database Connection — InternBridge PK
 *
 * Reads credentials from environment variables when deployed on Railway.
 * Falls back to XAMPP localhost defaults for local development.
 *
 * Railway automatically injects these env vars when you add a MySQL service:
 *   MYSQLHOST, MYSQLPORT, MYSQLDATABASE, MYSQLUSER, MYSQLPASSWORD
 *
 * For local XAMPP: none of these are set, so the defaults below are used.
 */

function getDB(): PDO {
    static $pdo = null;
    if ($pdo !== null) return $pdo;

    // ── Railway injects these automatically ──────────────────
    $host = getenv('MYSQLHOST')     ?: 'localhost';
    $port = getenv('MYSQLPORT')     ?: '3306';
    $db   = getenv('MYSQLDATABASE') ?: 'ims_db';
    $user = getenv('MYSQLUSER')     ?: 'root';
    $pass = getenv('MYSQLPASSWORD') ?: '';
    // ─────────────────────────────────────────────────────────

    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    } catch (PDOException $e) {
        // Never expose credentials in error messages
        error_log('DB Connection failed: ' . $e->getMessage());
        die('Database connection error. Please try again later.');
    }

    return $pdo;
}
