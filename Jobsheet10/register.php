<?php
require_once __DIR__ . '/includes/init.php';

if (isset($_SESSION['user_logged_in'])) {
    header('Location: ' . base_url('index.php'));
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $username     = trim($_POST['username'] ?? '');
    $password     = trim($_POST['password'] ?? '');

    if (!empty($nama_lengkap) && !empty($username) && !empty($password)) {
        // Cek ketersediaan username
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);

        if ($stmt->fetch()) {
            $error = 'Username sudah digunakan, pilih username lain!';
        } else {
            // Hash password menggunakan BCrypt
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $stmt_insert = $pdo->prepare(
                "INSERT INTO users (nama_lengkap, username, password, role) 
                 VALUES (:nama_lengkap, :username, :password, 'user')"
            );
            $stmt_insert->execute([
                'nama_lengkap' => $nama_lengkap,
                'username'     => $username,
                'password'     => $hashed_password
            ]);

            $success = 'Pendaftaran berhasil! Silakan login.';
        }
    } else {
        $error = 'Harap isi semua kolom pendaftaran!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - POLIMEDIC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-xl p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Buat Akun Baru</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar sebagai pengguna Polimedic</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl text-center font-medium">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 text-emerald-600 text-sm rounded-xl text-center font-medium">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" required placeholder="Contoh: John Doe" class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Username</label>
                <input type="text" name="username" required placeholder="Masukkan username" class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition shadow-md mt-2">
                Daftar
            </button>
        </form>

        <p class="text-xs text-center text-slate-500 mt-6">
            Sudah punya akun? <a href="<?= base_url('login.php'); ?>" class="text-indigo-600 font-semibold hover:underline">Login di sini</a>
        </p>
    </div>

</body>
</html>