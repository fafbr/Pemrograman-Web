<?php
require_once __DIR__ . '/includes/init.php';

// Hapus session autentikasi
unset($_SESSION['user_logged_in']);
unset($_SESSION['username']);

// Redirect kembali ke halaman login
header('Location: ' . base_url('login.php'));
exit;