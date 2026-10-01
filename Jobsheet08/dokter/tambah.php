<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/init.php';

// Initial state data kosong (Mode Tambah)
$id = $_GET['id'] ?? null;
$is_edit = false;
$dokter = [
    'id' => '',
    'nama' => '',
    'spesialis' => '',
    'telepon' => ''
];

// Cek jika mode Edit
if ($id !== null && isset($_SESSION['dokter'])) {
    foreach ($_SESSION['dokter'] as $item) {
        if ($item['id'] == $id) {
            $dokter = $item;
            $is_edit = true;
            break;
        }
    }
}

$page_title = ($is_edit ? 'Edit Data Dokter' : 'Tambah Dokter Baru') . ' - POLIMEDIC';
$active_page = 'dokter';

require_once __DIR__ . '/../includes/header.php';
?>

<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-1 w-full">
    <div class="mb-6">
        <nav class="flex text-xs text-slate-400 mb-1" aria-label="Breadcrumb">
            <a href="<?= base_url('index.php'); ?>" class="hover:text-slate-600">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="<?= base_url('dokter/list.php'); ?>" class="hover:text-slate-600">Dokter</a>
            <span class="mx-2">/</span>
            <span class="text-slate-600 font-medium"><?= $is_edit ? 'Edit Dokter' : 'Tambah Dokter'; ?></span>
        </nav>
        <h1 class="text-2xl font-bold text-slate-900"><?= $is_edit ? 'Edit Data Dokter' : 'Tambah Dokter Baru'; ?></h1>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 card-shadow p-6">
        <form action="<?= base_url('dokter/proses.php'); ?>" method="POST" class="space-y-4">
            <!-- Hidden Input ID untuk penanda mode Update -->
            <?php if ($is_edit): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($dokter['id']); ?>">
            <?php endif; ?>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Nama Dokter</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($dokter['nama']); ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Spesialis</label>
                <input type="text" name="spesialis" value="<?= htmlspecialchars($dokter['spesialis']); ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500" required>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Telepon</label>
                <input type="text" name="telepon" value="<?= htmlspecialchars($dokter['telepon']); ?>" class="w-full px-3 py-2 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500" required>
            </div>

            <div class="flex justify-end gap-2 pt-4">
                <a href="<?= base_url('dokter/list.php'); ?>" class="px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100 rounded-xl transition">Batal</a>
                <button type="submit" name="simpan" class="px-4 py-2 text-sm font-semibold bg-emerald-600 text-white hover:bg-emerald-700 rounded-xl transition">
                    <?= $is_edit ? 'Perbarui Data' : 'Simpan Data'; ?>
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>