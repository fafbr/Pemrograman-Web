<?php
require_once __DIR__ . '/../includes/init.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM dokter WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header('Location: ' . base_url('dokter/list.php'));
exit;