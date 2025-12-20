<?php

/**
 * Create a PDO connection using DATABASE_URL when provided (Neon/Postgres),
 * otherwise fall back to traditional MySQL environment variables for local dev.
 */
function get_db_connection(): PDO
{
    $databaseUrl = getenv('DATABASE_URL');

    if ($databaseUrl) {
        $parts = parse_url($databaseUrl);
        if ($parts === false) {
            throw new RuntimeException('Invalid DATABASE_URL.');
        }

        $host = $parts['host'] ?? 'localhost';
        $port = isset($parts['port']) ? (int) $parts['port'] : 5432;
        $user = $parts['user'] ?? '';
        $password = $parts['pass'] ?? '';
        $database = ltrim($parts['path'] ?? '', '/');

        $dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s;sslmode=require', $host, $port, $database);

        return new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }

    $host = getenv('MYSQL_HOST') ?: 'localhost';
    $user = getenv('MYSQL_USER') ?: 'root';
    $password = getenv('MYSQL_PASSWORD') ?: '';
    $database = getenv('MYSQL_DATABASE') ?: 'ev_charge_loc';
    $port = (int) (getenv('MYSQL_PORT') ?: 3306);

    $dsn = sprintf('mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4', $host, $port, $database);

    return new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}
