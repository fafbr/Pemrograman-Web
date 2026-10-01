<?php
require_once __DIR__ . '/../includes/init.php';

$action = $_GET['action'] ?? '';

if ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM dokter WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    
    header('Location: ' . base_url('dokter/list.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = trim($_POST['nama'] ?? '');
    $spesialis = trim($_POST['spesialis'] ?? '');
    $telepon   = trim($_POST['telepon'] ?? '');

    if (!empty($nama) && !empty($spesialis) && !empty($telepon)) {
        $stmt = $pdo->prepare(
            "INSERT INTO dokter (nama, spesialis, telepon) 
             VALUES (:nama, :spesialis, :telepon)"
        );
        
        $stmt->execute([
            'nama'      => $nama,
            'spesialis' => $spesialis,
            'telepon'   => $telepon
        ]);
    }

    header('Location: ' . base_url('dokter/list.php'));
    exit;
}

header('Location: ' . base_url('dokter/list.php'));
exit;