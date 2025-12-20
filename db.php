<?php

/**
 * Create a PDO connection using DATABASE_URL when provided (Neon/Postgres),
 * otherwise fall back to traditional MySQL environment variables for local dev.
 */
function get_db_connection(): PDO
{
    $databaseUrl = getenv('DATABASE_URL');

    if ($databaseUrl) {
        $cleanUrl = trim($databaseUrl);
        if (str_starts_with($cleanUrl, 'psql ')) {
            $cleanUrl = substr($cleanUrl, 5);
        }
        $cleanUrl = trim($cleanUrl, "'\"");
        $parts = parse_url($cleanUrl);
        if ($parts === false) {
            throw new RuntimeException('Invalid DATABASE_URL.');
        }

        $host = $parts['host'] ?? 'localhost';
        $port = isset($parts['port']) ? (int) $parts['port'] : 5432;
        $user = $parts['user'] ?? '';
        $password = $parts['pass'] ?? '';
        $database = ltrim($parts['path'] ?? '', '/');

        $dsn = sprintf('pgsql:host=%s;port=%d;dbname=%s', $host, $port, $database);

        $hasSslMode = false;
        if (!empty($parts['query'])) {
            parse_str($parts['query'], $queryParams);
            foreach ($queryParams as $key => $value) {
                if ($value === null || $value === '') {
                    continue;
                }
                if (strtolower($key) === 'sslmode') {
                    $hasSslMode = true;
                }
                $dsn .= sprintf(';%s=%s', $key, $value);
            }
        }

        if (!$hasSslMode) {
            $dsn .= ';sslmode=require';
        }

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
