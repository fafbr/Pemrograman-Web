<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/koneksi.php';

$base_url = '/';

function base_url($path = '') {
    global $base_url;
    return rtrim($base_url, '/') . '/' . ltrim($path, '/');
}

function auth_protect() {
    $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $is_login_page = ($request_uri === '/login.php');

    if (!$is_login_page && !isset($_SESSION['user_logged_in'])) {
        header('Location: ' . base_url('login.php'));
        exit;
    }
}

auth_protect();