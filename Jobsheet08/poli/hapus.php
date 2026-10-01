<?php
require_once __DIR__ . '/../includes/init.php';

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM poli WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header('Location: ' . base_url('poli/list.php'));
exit;