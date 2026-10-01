<?php
$host = "localhost";
$port = "5432";
$db   = "polimedic_db";
$user = "postgres";
$pass = "satuduatiga";

try {
    $dsn = "pgsql:host={$host};port={$port};dbname={$db}";
    
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}