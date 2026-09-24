<?php
require_once __DIR__ . '/includes/init.php';

// Jika sudah login, redirect ke dashboard
if (isset($_SESSION['user_logged_in'])) {
    header('Location: ' . base_url('index.php'));
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Kredensial dummy (Sesuaikan sesuai kebutuhan)
    $dummy_user = 'admin';
    $dummy_pass = 'admin123';

    if ($username === $dummy_user && $password === $dummy_pass) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        
        header('Location: ' . base_url('index.php'));
        exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POLIMEDIC</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-xl p-8">
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
                <input 
                    type="text" 
                    name="username" 
                    required 
                    placeholder="Masukkan username" 
                    class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Password</label>
                <input 
                    type="password" 
                    name="password" 
                    required 
                    placeholder="••••••••" 
                    class="w-full px-4 py-2.5 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                >
            </div>

            <button 
                type="submit" 
                class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl transition shadow-md mt-2"
            >
                Masuk
            </button>
        </form>

        <p class="text-xs text-center text-slate-400 mt-6">
            Gunakan username: <span class="font-mono text-slate-600">admin</span> & password: <span class="font-mono text-slate-600">admin123</span>
        </p>
    </div>

</body>
</html>