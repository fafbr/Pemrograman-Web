<?php
require_once __DIR__ . '/includes/init.php';

$username = 'admin';
$password_plain = 'admin123';
$password_hash = password_hash($password_plain, PASSWORD_BCRYPT);
$nama_lengkap = 'Administrator Utama';
$role = 'admin';

try {
    $stmt = $pdo->prepare("
        INSERT INTO users (username, password, nama_lengkap, role)
        VALUES (:username, :password, :nama_lengkap, :role)
        ON CONFLICT (username) 
        DO UPDATE SET password = EXCLUDED.password
    ");
    
    $stmt->execute([
        'username' => $username,
        'password' => $password_hash,
        'nama_lengkap' => $nama_lengkap,
        'role' => $role
    ]);

    echo "SUKSES! Akun admin berhasil dibuat/diperbarui.<br>";
    echo "Username: <b>admin</b><br>";
    echo "Password: <b>admin123</b><br>";
    echo "Hash BCRYPT: <code>" . $password_hash . "</code>";

} catch (PDOException $e) {
    echo "ERROR: " . $e->getMessage();
}