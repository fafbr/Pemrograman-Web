<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/includes/init.php';

$page_title = 'POLIMEDIC - Modern Poliklinik';
$active_page = 'dashboard';

// Hitung total dari session
$total_dokter = isset($_SESSION['dokter']) ? count($_SESSION['dokter']) : 0;
$total_poli = isset($_SESSION['poli']) ? count($_SESSION['poli']) : 0;

require_once __DIR__ . '/includes/header.php';
?>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">Dashboard Sistem Informasi</h1>
        <p class="text-slate-500 text-sm mt-1">Ringkasan unit layanan kesehatan dan manajemen dokter aktif.</p>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 card-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Poliklinik</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-1"><?= $total_poli; ?> <span class="text-sm font-normal text-slate-500">Unit</span></h3>
            </div>
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center font-semibold">
                🏥
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 card-shadow flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Dokter Terdaftar</p>
                <h3 class="text-3xl font-bold text-slate-900 mt-1"><?= $total_dokter; ?> <span class="text-sm font-normal text-slate-500">Orang</span></h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-semibold">
                👨‍⚕️
            </div>
        </div>
    </div>

    <!-- Main Navigation Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Poli -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 card-shadow hover:border-indigo-300 transition duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 font-semibold text-xs rounded-full mb-3">Master Entity</span>
                    <h2 class="text-xl font-bold text-slate-900">Data Poliklinik</h2>
                    <p class="text-slate-500 text-sm mt-2 leading-relaxed">Kelola daftar ruangan, unit kesehatan, dan deskripsi lokasi poli.</p>
                </div>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex gap-3">
                <a href="<?= base_url('poli/list.php'); ?>" class="flex-1 text-center bg-indigo-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition shadow-sm shadow-indigo-200">Kelola Poli</a>
                <a href="<?= base_url('poli/tambah.php'); ?>" class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200 transition">+ Baru</a>
            </div>
        </div>

        <!-- Card Dokter -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 card-shadow hover:border-emerald-300 transition duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <span class="inline-block px-3 py-1 bg-emerald-50 text-emerald-700 font-semibold text-xs rounded-full mb-3">Detail Entity</span>
                    <h2 class="text-xl font-bold text-slate-900">Data Dokter & Spesialis</h2>
                    <p class="text-slate-500 text-sm mt-2 leading-relaxed">Kelola biodata dokter, nomor izin praktik (SIP), dan penugasan poli.</p>
                </div>
            </div>
            <div class="mt-8 pt-4 border-t border-slate-100 flex gap-3">
                <a href="<?= base_url('dokter/list.php'); ?>" class="flex-1 text-center bg-emerald-600 text-white py-2.5 rounded-xl text-sm font-semibold hover:bg-emerald-700 transition shadow-sm shadow-emerald-200">Kelola Dokter</a>
                <a href="<?= base_url('dokter/tambah.php'); ?>" class="px-4 py-2.5 bg-slate-100 text-slate-700 rounded-xl text-sm font-semibold hover:bg-slate-200 transition">+ Baru</a>
            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>