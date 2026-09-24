<?php
require_once __DIR__ . '/../includes/init.php';

// 1. PROSES HAPUS DATA (Via GET)
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;

    if ($id !== null && isset($_SESSION['poli'])) {
        foreach ($_SESSION['poli'] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['poli'][$key]);
                $_SESSION['poli'] = array_values($_SESSION['poli']); // Re-index array
                break;
            }
        }
    }

    header('Location: ' . base_url('poli/list.php'));
    exit;
}

// 2. PROSES TAMBAH & EDIT DATA (Via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama_poli = trim($_POST['nama_poli'] ?? '');
    $gedung = trim($_POST['gedung'] ?? '');

    if (!isset($_SESSION['poli'])) {
        $_SESSION['poli'] = [];
    }

    if ($id !== null && $id !== '') {
        // Mode Update
        foreach ($_SESSION['poli'] as $key => $item) {
            if ($item['id'] == $id) {
                $_SESSION['poli'][$key]['nama_poli'] = $nama_poli;
                $_SESSION['poli'][$key]['gedung'] = $gedung;
                break;
            }
        }
    } else {
        // Mode Insert
        $new_id = count($_SESSION['poli']) > 0 ? max(array_column($_SESSION['poli'], 'id')) + 1 : 1;
        $_SESSION['poli'][] = [
            'id' => $new_id,
            'nama_poli' => $nama_poli,
            'gedung' => $gedung
        ];
    }

    header('Location: ' . base_url('poli/list.php'));
    exit;
}