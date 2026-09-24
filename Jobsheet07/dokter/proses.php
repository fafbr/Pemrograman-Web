<?php
require_once __DIR__ . '/../includes/init.php';

// 1. PROSES HAPUS DATA (Via GET)
if (isset($_GET['action']) && $_GET['action'] === 'delete') {
    $id = $_GET['id'] ?? null;

    if ($id !== null && isset($_SESSION['dokter'])) {
        foreach ($_SESSION['dokter'] as $key => $item) {
            if ($item['id'] == $id) {
                unset($_SESSION['dokter'][$key]);
                $_SESSION['dokter'] = array_values($_SESSION['dokter']); // Re-index array
                break;
            }
        }
    }

    // Redirect kembali ke list.php
    header('Location: ' . base_url('dokter/list.php'));
    exit;
}

// 2. PROSES TAMBAH & EDIT DATA (Via POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;
    $nama = trim($_POST['nama'] ?? '');
    $spesialis = trim($_POST['spesialis'] ?? '');
    $telepon = trim($_POST['telepon'] ?? '');

    if (!isset($_SESSION['dokter'])) {
        $_SESSION['dokter'] = [];
    }

    if ($id !== null && $id !== '') {
        // Mode Update
        foreach ($_SESSION['dokter'] as $key => $item) {
            if ($item['id'] == $id) {
                $_SESSION['dokter'][$key]['nama'] = $nama;
                $_SESSION['dokter'][$key]['spesialis'] = $spesialis;
                $_SESSION['dokter'][$key]['telepon'] = $telepon;
                break;
            }
        }
    } else {
        // Mode Insert
        $new_id = count($_SESSION['dokter']) > 0 ? max(array_column($_SESSION['dokter'], 'id')) + 1 : 1;
        $_SESSION['dokter'][] = [
            'id' => $new_id,
            'nama' => $nama,
            'spesialis' => $spesialis,
            'telepon' => $telepon
        ];
    }

    // Redirect kembali ke list.php
    header('Location: ' . base_url('dokter/list.php'));
    exit;
}