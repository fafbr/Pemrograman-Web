<?php
require_once __DIR__ . '/../includes/init.php';

$page_title = 'Data Poli - POLIMEDIC';
$active_page = 'poli';

$search = trim($_GET['search'] ?? '');

// Pengaturan Pagination
$limit = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $limit;

// 1. Hitung Total Data (Count Query)
if (!empty($search)) {
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM poli WHERE nama_poli ILIKE :search OR gedung ILIKE :search");
    $stmt_count->execute(['search' => "%{$search}%"]);
} else {
    $stmt_count = $pdo->query("SELECT COUNT(*) FROM poli");
}
$total_rows = (int) $stmt_count->fetchColumn();
$total_pages = ceil($total_rows / $limit);

// 2. Fetch Data dengan Pagination
if (!empty($search)) {
    $stmt = $pdo->prepare("SELECT * FROM poli WHERE nama_poli ILIKE :search OR gedung ILIKE :search ORDER BY id ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':search', "%{$search}%", PDO::PARAM_STR);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
} else {
    $stmt = $pdo->prepare("SELECT * FROM poli ORDER BY id ASC LIMIT :limit OFFSET :offset");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
}

$list_poli = $stmt->fetchAll();

require_once __DIR__ . '/../includes/header.php';
?>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full">
    <!-- Breadcrumb & Header -->
    <div class="mb-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
                <a href="<?= base_url('index.php'); ?>" class="hover:text-slate-600">Dashboard</a>
                <span class="mx-2">/</span>
                <span class="text-slate-600 font-medium">Poli</span>
            </nav>
            <h1 class="text-2xl font-bold text-slate-900">Data Poliklinik</h1>
            <p class="text-slate-500 text-sm mt-0.5">Kelola daftar poliklinik dan lokasi gedung pelayanan.</p>
        </div>
        
        <!-- Button Add (Hanya Admin) -->
        <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
        <a href="<?= base_url('poli/tambah.php'); ?>" class="inline-flex items-center justify-center gap-2 bg-indigo-600 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-indigo-700 transition shadow-sm shadow-indigo-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Poli Baru
        </a>
        <?php endif; ?>
    </div>

    <!-- Table Card Container -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <!-- Top Toolbar / Search Form -->
        <div class="p-4 sm:p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <form method="GET" action="" class="relative w-full max-w-md flex items-center gap-2">
                <div class="relative flex-1">
                    <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" placeholder="Cari nama poli atau gedung..." class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white text-sm font-medium rounded-xl transition shrink-0">
                    Cari
                </button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('poli/list.php'); ?>" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-medium rounded-xl transition flex items-center shrink-0">
                        Reset
                    </a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Table Responsive Wrapper -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                        <th class="py-3.5 px-4 sm:px-6">ID</th>
                        <th class="py-3.5 px-4 sm:px-6">Nama Poliklinik</th>
                        <th class="py-3.5 px-4 sm:px-6">Gedung</th>
                        <th class="py-3.5 px-4 sm:px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php if (!empty($list_poli)): ?>
                        <?php foreach ($list_poli as $row): ?>
                        <tr class="hover:bg-slate-50/80 transition">
                            <td class="py-4 px-4 sm:px-6 font-mono text-xs text-slate-400">#POLI-<?= str_pad($row['id'], 3, '0', STR_PAD_LEFT); ?></td>
                            <td class="py-4 px-4 sm:px-6 font-semibold text-slate-800"><?= htmlspecialchars($row['nama_poli'] ?? ''); ?></td>
                            <td class="py-4 px-4 sm:px-6">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    <?= htmlspecialchars($row['gedung'] ?? '-'); ?>
                                </span>
                            </td>
                            <td class="py-4 px-4 sm:px-6 text-center">
                                <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                                    <div class="inline-flex items-center gap-1">
                                        <a href="<?= base_url('poli/tambah.php?id=' . $row['id']); ?>" class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Edit Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        <a href="<?= base_url('poli/proses.php?action=delete&id=' . $row['id']); ?>" 
                                           onclick="return confirm('Apakah Anda yakin ingin menghapus data poli ini?');" 
                                           class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" 
                                           title="Hapus Data">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <span class="text-xs text-slate-400 italic">Read-Only</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="py-8 text-center text-slate-400">Belum ada data poliklinik terdaftar.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($total_pages > 1): ?>
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="text-xs text-slate-500">
                    Halaman <span class="font-semibold text-slate-700"><?= $page; ?></span> dari <span class="font-semibold text-slate-700"><?= $total_pages; ?></span> (Total <?= $total_rows; ?> data)
                </div>
                <div class="flex items-center gap-1">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1; ?><?= !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                            &laquo; Prev
                        </a>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?= $i; ?><?= !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="px-3 py-1.5 text-xs rounded-xl border transition <?= $i === $page ? 'bg-indigo-600 text-white border-indigo-600 font-semibold' : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-100'; ?>">
                            <?= $i; ?>
                        </a>
                    <?php endfor; ?>

                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1; ?><?= !empty($search) ? '&search=' . urlencode($search) : ''; ?>" 
                           class="px-3 py-1.5 text-xs bg-white border border-slate-200 rounded-xl text-slate-600 hover:bg-slate-100 transition">
                            Next &raquo;
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>