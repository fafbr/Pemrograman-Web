<?php
if (file_exists(__DIR__ . '/../.env')) {
    $lines = file(__DIR__ . '/../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
            putenv(sprintf('%s=%s', $name, $value));
            $_ENV[$name] = $value;
            $_SERVER[$name] = $value;
        }
    }
}

$host = $_ENV['POSTGRES_HOST'] ?? $_SERVER['POSTGRES_HOST'] ?? getenv('POSTGRES_HOST') ?: 'localhost';
$port = $_ENV['POSTGRES_PORT'] ?? $_SERVER['POSTGRES_PORT'] ?? getenv('POSTGRES_PORT') ?: '5432';
$db   = $_ENV['POSTGRES_DATABASE'] ?? $_SERVER['POSTGRES_DATABASE'] ?? getenv('POSTGRES_DATABASE') ?: 'polimedic_db';
$user = $_ENV['POSTGRES_USER'] ?? $_SERVER['POSTGRES_USER'] ?? getenv('POSTGRES_USER') ?: 'postgres';
$pass = $_ENV['POSTGRES_PASSWORD'] ?? $_SERVER['POSTGRES_PASSWORD'] ?? getenv('POSTGRES_PASSWORD') ?: 'satuduatiga';

$isLocal = ($host === '127.0.0.1' || $host === 'localhost');

if ($isLocal) {
    $dsn = "pgsql:host={$host};port={$port};dbname={$db}";
} else {
    $dsn = "pgsql:host={$host};port={$port};dbname={$db};sslmode=require";
}

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}