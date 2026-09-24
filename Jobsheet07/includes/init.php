<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base_url = '/';

function base_url($path = '') {
    global $base_url;
    return rtrim($base_url, '/') . '/' . ltrim($path, '/');
}

// Inisialisasi data dummy di session jika belum ada
if (!isset($_SESSION['dokter'])) {
    $_SESSION['dokter'] = [
        ['id' => 1, 'nama' => 'Dr. Andi Pratama', 'spesialis' => 'Spesialis Anak', 'telepon' => '08123456789'],
        ['id' => 2, 'nama' => 'Dr. Budi Santoso', 'spesialis' => 'Spesialis Penyakit Dalam', 'telepon' => '08234567890']
    ];
}

if (!isset($_SESSION['poli'])) {
    $_SESSION['poli'] = [
        ['id' => 1, 'nama_poli' => 'Poli Umum', 'gedung' => 'Gedung A'],
        ['id' => 2, 'nama_poli' => 'Poli Gigi', 'gedung' => 'Gedung B']
    ];
}

// Helper untuk filter/pencarian array session
function search_array($data, $keyword, $fields = []) {
    if (empty($keyword)) {
        return $data;
    }
    
    $keyword = strtolower(trim($keyword));
    return array_filter($data, function($item) use ($keyword, $fields) {
        foreach ($fields as $field) {
            if (isset($item[$field]) && strpos(strtolower($item[$field]), $keyword) !== false) {
                return true;
            }
        }
        return false;
    });
}

function auth_protect() {
    // Ambil path asli dari URL browser (bukan skrip entry point serverless)
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Izinkan akses tanpa login khusus untuk endpoint login.php
    $is_login_page = ($request_uri === '/login.php');

    if (!$is_login_page && !isset($_SESSION['user_logged_in'])) {
        header('Location: ' . base_url('login.php'));
        exit;
    }
}

// Panggil guard otomatis saat file init di-load
auth_protect();