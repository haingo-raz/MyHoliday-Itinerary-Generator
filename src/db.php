<?php

function getDbConnection(): PDO
{
    $envPath = __DIR__ . '/../.env';
    if (is_readable($envPath)) {
        foreach (file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }
            [$key, $value] = array_pad(explode('=', $line, 2), 2, null);
            if ($key !== null && $value !== null && getenv(trim($key)) === false) {
                putenv(trim($key) . '=' . trim($value, " \t\"'"));
            }
        }
    }

    $url = getenv('DATABASE_URL');
    if (!$url) {
        throw new RuntimeException('DATABASE_URL is not set');
    }

    $parts = parse_url($url);
    if ($parts === false || empty($parts['host']) || empty($parts['user'])) {
        throw new RuntimeException('DATABASE_URL is malformed');
    }

    $host = $parts['host'];
    $port = $parts['port'] ?? 5432;
    $name = isset($parts['path']) ? ltrim($parts['path'], '/') : '';
    $user = urldecode($parts['user']);
    $pass = isset($parts['pass']) ? urldecode($parts['pass']) : '';

    $sslmode = 'require';
    if (!empty($parts['query'])) {
        parse_str($parts['query'], $query);
        if (!empty($query['sslmode'])) {
            $sslmode = $query['sslmode'];
        }
    }

    $dsn = "pgsql:host={$host};port={$port};dbname={$name};sslmode={$sslmode}";

    return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
