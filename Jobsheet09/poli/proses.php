<?php
require_once __DIR__ . '/../includes/init.php';

$action = $_GET['action'] ?? '';

if ($action === 'delete') {
    $id = $_POST['id'] ?? $_GET['id'] ?? null;
    
    if ($id) {
        $stmt = $pdo->prepare("DELETE FROM poli WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
    
    header('Location: ' . base_url('poli/list.php'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id        = $_POST['id'] ?? null;
    $nama_poli = trim($_POST['nama_poli'] ?? '');
    $gedung    = trim($_POST['gedung'] ?? '');

    if (!empty($nama_poli) && !empty($gedung)) {
        if ($id) {
            $stmt = $pdo->prepare(
                "UPDATE poli 
                 SET nama_poli = :nama_poli, gedung = :gedung 
                 WHERE id = :id"
            );
            $stmt->execute([
                'id'        => $id,
                'nama_poli' => $nama_poli,
                'gedung'    => $gedung
            ]);
        } else {
            // Jika ID tidak ada -> INSERT
            $stmt = $pdo->prepare(
                "INSERT INTO poli (nama_poli, gedung) 
                 VALUES (:nama_poli, :gedung)"
            );
            $stmt->execute([
                'nama_poli' => $nama_poli,
                'gedung'    => $gedung
            ]);
        }
    }

    header('Location: ' . base_url('poli/list.php'));
    exit;
}

header('Location: ' . base_url('poli/list.php'));
exit;