<?php
$active_page = 'poli';
$page_title  = 'Data Poliklinik - POLIMEDIC';
require_once __DIR__ . '/../includes/header.php';

$search = isset($_GET['search']) ? $_GET['search'] : '';
$list_poli = search_array($_SESSION['poli'] ?? [], $search, ['nama_poli', 'gedung']);
?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Data Poliklinik</h1>
            <p class="text-sm text-slate-500">Kelola daftar poliklinik dan lokasi gedung</p>
        </div>
        <a href="<?= base_url('poli/tambah.php'); ?>" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
            + Tambah Poli
        </a>
    </div>

    <!-- Form Search -->
    <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6">
        <form method="GET" action="" class="flex gap-2">
            <input 
                type="text" 
                name="search" 
                value="<?= htmlspecialchars($search); ?>" 
                placeholder="Cari nama poli atau gedung..." 
                class="w-full px-4 py-2 text-sm border border-slate-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
            >
            <button type="submit" class="px-5 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl transition">
                Cari
            </button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('poli/list.php'); ?>" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-xl transition flex items-center">
                    Reset
                </a>
            <?php endif; ?>
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-semibold">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Nama Poliklinik</th>
                        <th class="px-6 py-4">Gedung</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <?php if (!empty($list_poli)): ?>
                        <?php foreach ($list_poli as $row): ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-6 py-4 font-medium text-slate-900">#<?= $row['id']; ?></td>
                                <td class="px-6 py-4 font-semibold text-slate-800"><?= htmlspecialchars($row['nama_poli']); ?></td>
                                <td class="px-6 py-4"><?= htmlspecialchars($row['gedung']); ?></td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <!-- Tombol Edit -->
                                        <a href="<?= base_url('poli/tambah.php?id=' . $row['id']); ?>" 
                                           class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" 
                                           title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        <!-- Tombol Hapus -->
                                        <a href="<?= base_url('poli/proses.php?action=delete&id=' . $row['id']); ?>" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data poli ini?');" 
                                           class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" 
                                           title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">Data tidak ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>