<?php
require_once __DIR__ . '/includes/init.php';

if (isset($_SESSION['user_logged_in'])) {
    header('Location: ' . base_url('index.php'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!empty($username) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if (!$user) {
            $error = 'Akun tidak ditemukan!';
        } elseif (password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id']        = $user['id'];
            $_SESSION['username']       = $user['username'];
            $_SESSION['nama_lengkap']   = $user['nama_lengkap'];
            $_SESSION['role']           = $user['role'];

            header('Location: ' . base_url('index.php'));
            exit;
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Harap isi username dan password!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POLIMEDIC</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">



    <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-xl p-8">

            <div class="my-4 p-4 bg-amber-50 border-l-4 border-amber-400 rounded-r-xl shadow-sm text-sm text-amber-900">
                <div class="flex items-start gap-3">
                    <!-- Icon Informasi -->
                    <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div class="space-y-1">
                        <p class="font-semibold text-amber-950">Informasi Akses Sistem:</p>
                        <ul class="list-disc list-inside space-y-0.5 text-xs text-amber-900/90">
                            <li><span class="font-medium">Admin (admin / pw:admin123):</span> Full Access </li>
                            <li><span class="font-medium">User :</span> Read-Only</li>
                        </ul>
                    </div>
                </div>
            </div>

        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-900">Selamat Datang</h1>
            <p class="text-sm text-slate-500 mt-1">Silakan login untuk mengakses sistem POLIMEDIC</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl text-center font-medium">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Username</label>
                <input type="text" name="username" required placeholder="Masukkan username" class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition shadow-md mt-2">
                Masuk
            </button>
        </form>

        <p class="text-xs text-center text-slate-500 mt-6">
            Belum punya akun? <a href="<?= base_url('register.php'); ?>" class="text-indigo-600 font-semibold hover:underline">Daftar di sini</a>
        </p>


    </div>



</body>
</html>