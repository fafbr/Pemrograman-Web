<?php
require_once __DIR__ . '/init.php';

// Default active page jika tidak di-set
if (!isset($active_page)) {
    $active_page = 'dashboard';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? htmlspecialchars($page_title) : 'POLIMEDIC - Modern Poliklinik'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?= base_url('assets/style.css'); ?>">
</head>
<body class="bg-slate-50 min-h-screen flex flex-col justify-between">
    <!-- Navbar Top -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <!-- Brand Logo -->
                <a href="<?= base_url('index.php'); ?>" class="flex items-center gap-3 shrink-0">
                    <div class="w-10 h-10 bg-indigo-600 text-white rounded-xl flex items-center justify-center font-bold text-lg shadow-md shadow-indigo-200">
                        S
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 text-lg leading-tight block">POLIMEDIC</span>
                        <span class="text-xs text-slate-500 font-medium">Poliklinik Management</span>
                    </div>
                </a>

                <!-- Nav Desktop -->
                <nav class="hidden sm:flex items-center space-x-1">
                    <a href="<?= base_url('index.php'); ?>" class="px-4 py-2 rounded-lg text-sm <?= $active_page === 'dashboard' ? 'font-semibold text-indigo-600 bg-indigo-50' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition'; ?>">Dashboard</a>
                    <a href="<?= base_url('poli/list.php'); ?>" class="px-4 py-2 rounded-lg text-sm <?= $active_page === 'poli' ? 'font-semibold text-indigo-600 bg-indigo-50' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition'; ?>">Data Poli</a>
                    <a href="<?= base_url('dokter/list.php'); ?>" class="px-4 py-2 rounded-lg text-sm <?= $active_page === 'dokter' ? 'font-semibold text-emerald-600 bg-emerald-50' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition'; ?>">Data Dokter</a>
                </nav>

                <!-- User & Logout Section (Desktop) -->
                <div class="hidden sm:flex items-center gap-4">
                    <div class="flex flex-col text-right">
                        <span class="text-xs font-semibold text-slate-900">
                            <?= htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>
                        </span>
                        <span class="text-[10px] text-slate-400">Administrator</span>
                    </div>
                    <a href="<?= base_url('logout.php'); ?>" 
                       onclick="return confirm('Apakah Anda yakin ingin keluar?');"
                       class="inline-flex items-center gap-1.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg transition"
                       title="Keluar dari Sistem">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </a>
                </div>

                <!-- Hamburger Button (Mobile Only) -->
                <button id="mobile-menu-btn" type="button" class="sm:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 focus:outline-none" aria-label="Toggle Menu">
                    <svg id="menu-icon-open" class="w-6 h-6 block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg id="menu-icon-close" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Nav Mobile Container -->
            <div id="mobile-menu" class="max-h-0 overflow-hidden transition-all duration-300 ease-in-out sm:hidden border-t border-slate-100">
                <nav class="flex flex-col space-y-1 py-3">
                    <a href="<?= base_url('index.php'); ?>" class="px-4 py-2.5 rounded-xl text-sm <?= $active_page === 'dashboard' ? 'font-semibold text-indigo-600 bg-indigo-50' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition'; ?>">Dashboard</a>
                    <a href="<?= base_url('poli/list.php'); ?>" class="px-4 py-2.5 rounded-xl text-sm <?= $active_page === 'poli' ? 'font-semibold text-indigo-600 bg-indigo-50' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition'; ?>">Data Poli</a>
                    <a href="<?= base_url('dokter/list.php'); ?>" class="px-4 py-2.5 rounded-xl text-sm <?= $active_page === 'dokter' ? 'font-semibold text-emerald-600 bg-emerald-50' : 'font-medium text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition'; ?>">Data Dokter</a>
                    
                    <div class="pt-2 mt-2 border-t border-slate-100 px-4 flex items-center justify-between">
                        <div class="flex flex-col">
                            <span class="text-xs font-semibold text-slate-900">
                                <?= htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?>
                            </span>
                            <span class="text-[10px] text-slate-400">Administrator</span>
                        </div>
                        <a href="<?= base_url('logout.php'); ?>" 
                           onclick="return confirm('Apakah Anda yakin ingin keluar?');"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-lg transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span>Logout</span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </header>