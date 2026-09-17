# Perancangan UI/UX & Wireframe — SIMPUS-Mini

Sub-CPMK: Merancang UI/UX aplikasi (proyek).

Halaman yang sudah ada (Beranda, Daftar/Tambah Buku, Daftar/Tambah Anggota — Jobsheet 1-3) belum mencakup fitur Login, Dashboard Petugas, dan Peminjaman/Pengembalian. Dokumen ini merancang wireframe untuk halaman-halaman tersebut sebelum diimplementasikan mulai Jobsheet 5 dan seterusnya.

---

## 1. Identifikasi Aktor & Batasan Hak Akses

1. **Tamu (Publik / Anggota Umum):**
   - Hak akses terbatas hanya untuk melihat katalog pustaka (*read-only*).
   - Halaman yang dapat diakses: Beranda (`index.html`) dan Katalog Buku (`buku/list.html`).
   - Tidak memiliki akses terhadap modul anggota, registrasi buku, maupun transaksi.

2. **Petugas (User / Administrator):**
   - Memiliki autentikasi untuk mengelola seluruh siklus data perpustakaan.
   - Hak akses penuh:
     - Manajemen master data Buku (`buku/*`) dan Anggota (`anggota/*`).
     - Pemrosesan sirkulasi transaksi Peminjaman dan Pengembalian.
     - Akses Dashboard operasional dan laporan riwayat sirkulasi.

---

## 2. User Flow Diagram

### 2.1 Skenario: Petugas Meminjamkan Buku ke Anggota
Alur operasional pencatatan peminjaman baru oleh petugas:

```text
[Petugas Masuk Dashboard]
           │
           ▼
[Akses Modul "Peminjaman Baru"]
           │
           ▼
[Pilih Anggota Peminjam]
           │
           ▼
[Cek Status Tunggakan Anggota] ──(Ada tunggakan/terlambat)──> [Tampilkan Peringatan & Tolak]
           │ (Bebas tanggungan)
           ▼
[Pilih Koleksi Buku]
           │
           ▼
[Validasi Ketersediaan] ─────────(Stok = 0)─────────────────> [Buku Di-disable / Nonaktif]
           │ (Stok > 0)
           ▼
[Tentukan Tanggal Pinjam & Batas Tempo]
           │
           ▼
[Simpan Transaksi]
           │
           ├──> [Kurangi Stok Buku: stok = stok - 1]
           └──> [Simpan Record Peminjaman (Status: 'dipinjam')]
           │
           ▼
[Tampilkan Konfirmasi Berhasil & Redirect ke Riwayat]
```

### 2.2 Skenario: Petugas Memproses Pengembalian Buku
Alur penyelesaian sirkulasi buku yang kembali ke perpustakaan:

```text
[Petugas Masuk Dashboard]
           │
           ▼
[Akses Modul "Pengembalian Buku"]
           │
           ▼
[Cari Transaksi Peminjaman Aktif Berdasarkan Nama/ID]
           │
           ▼
[Pilih Baris Transaksi Terkait]
           │
           ▼
[Verifikasi Tanggal Pengembalian Riil terhadap Batas Tempo]
           │
           ├──(Melewati Batas Tempo)──> [Hitung Durasi Keterlambatan & Catat Denda]
           └──(Tepat Waktu)───────────> [Denda = Rp 0]
           │
           ▼
[Konfirmasi Penerimaan Kembali]
           │
           ├──> [Ubah Status Transaksi: 'dikembalikan']
           ├──> [Catat Tanggal Kembali Realtime]
           └──> [Pulihkan Stok Koleksi: stok = stok + 1]
           │
           ▼
[Tampilkan Ringkasan & Perbarui Data Dashboard]
```

---

## 3. Wireframe Antarmuka Baru

Mengacu pada kebutuhan modul yang belum tersedia pada Jobsheet 1–3:

### 3.1 Halaman Login Petugas (`auth/login.html`)
Pintu masuk otentikasi petugas untuk mengunci hak akses CRUD.

```text
+-------------------------------------------------------------------+
| SIMPUS-MINI                                                       |
+-------------------------------------------------------------------+
|                                                                   |
|                   +---------------------------+                   |
|                   |       MASUK PETUGAS       |                   |
|                   +---------------------------+                   |
|                   | Username:                 |                   |
|                   | [                       ] |                   |
|                   |                           |                   |
|                   | Password:                 |                   |
|                   | [                       ] |                   |
|                   |                           |                   |
|                   | [     Masuk Sistem      ] |                   |
|                   +---------------------------+                   |
|                                                                   |
+-------------------------------------------------------------------+
| (c) 2026 SIMPUS-MINI — Desain dan Pemrograman Web                 |
+-------------------------------------------------------------------+
```

### 3.2 Dashboard Petugas (`index.html` — Mode Terautentikasi)
Halaman sentral petugas yang menyajikan ringkasan statistik dan tombol pintas navigasi.

```text
+-------------------------------------------------------------------+
| SIMPUS-MINI  Beranda | Buku | Anggota | Sirkulasi | [Petugas: Keluar] |
+-------------------------------------------------------------------+
| Panel Operasional Petugas                                         |
| Ringkasan Koleksi dan Transaksi:                                  |
|                                                                   |
| [ Total Koleksi ]  [ Anggota Terdaftar ]  [ Pinjaman Aktif ]      |
| [     12 Judul  ]  [       8 Orang     ]  [     3 Transaksi]      |
|                                                                   |
| Menu Pintasan:                                                    |
| [ + Catat Pinjaman Baru ]       [ + Verifikasi Pengembalian ]     |
|                                                                   |
| Peminjaman Terkini:                                               |
| +------------+----------------------+---------------+-----------+ |
| | Anggota    | Judul Koleksi        | Tgl Pinjam    | Status    | |
| +------------+----------------------+---------------+-----------+ |
| | Siti A.    | Laskar Pelangi       | 2026-09-01    | Dipinjam  | |
| | Budi S.    | Bumi Manusia         | 2026-09-02    | Dipinjam  | |
| +------------+----------------------+---------------+-----------+ |
+-------------------------------------------------------------------+
```

### 3.3 Form Peminjaman Buku (`peminjaman/tambah.html`)
Formulir sirkulasi penyerahan buku dari inventaris kepada peminjam.

```text
+-------------------------------------------------------------------+
| SIMPUS-MINI  Beranda | Buku | Anggota | Sirkulasi | [Petugas: Keluar] |
+-------------------------------------------------------------------+
| Transaksi Peminjaman Koleksi                                      |
|                                                                   |
| Pilih Anggota:                                                    |
| [ Pilih berdasarkan ID / Nama Anggota                         |v] |
|                                                                   |
| Pilih Buku (Hanya buku yang tersedia/stok > 0):                   |
| [ Pilih Judul Koleksi                                         |v] |
|                                                                   |
| Tanggal Transaksi:             Batas Akhir Kembali:               |
| [ 2026-09-10                ]  [ 2026-09-17                     ] |
|                                                                   |
| [ Simpan Peminjaman ]   [ Batal ]                                 |
+-------------------------------------------------------------------+
```

### 3.4 Form Pengembalian Buku (`peminjaman/kembali.html`)
Antarmuka verifikasi fisik buku dan pembaruan stok.

```text
+-------------------------------------------------------------------+
| SIMPUS-MINI  Beranda | Buku | Anggota | Sirkulasi | [Petugas: Keluar] |
+-------------------------------------------------------------------+
| Pengembalian & Penerimaan Koleksi                                 |
|                                                                   |
| Filter Pencarian: [ Masukkan Nomor Anggota / Judul Buku ] [Cari]  |
|                                                                   |
| Rincian Transaksi Ditemukan:                                      |
| - ID Transaksi  : TRX-202609-001                                  |
| - Peminjam      : Siti Aminah (A001)                              |
| - Buku          : Laskar Pelangi                                  |
| - Tgl Pinjam    : 2026-09-01                                      |
| - Jatuh Tempo   : 2026-09-08                                      |
| - Kondisi Waktu : Melewati Batas Tempo (Terlambat 2 Hari)         |
|                                                                   |
| [ Proses Pengembalian & Perbarui Stok ]                           |
+-------------------------------------------------------------------+
```

### 3.5 Riwayat Peminjaman per Anggota (`peminjaman/riwayat.html`)
Catatan riwayat transaksi historis perpustakaan untuk kebutuhan audit dan monitoring.

```text
+-------------------------------------------------------------------+
| SIMPUS-MINI  Beranda | Buku | Anggota | Sirkulasi | [Petugas: Keluar] |
+-------------------------------------------------------------------+
| Riwayat Sirkulasi Anggota: Siti Aminah (A001)                     |
|                                                                   |
| +------------+-----------------+------------+------------+------+ |
| | Kode Pinjam| Judul Buku      | Tgl Pinjam | Tgl Kembali|Status| |
| +------------+-----------------+------------+------------+------+ |
| | TRX-001    | Laskar Pelangi  | 2026-08-10 | 2026-08-17 |Kembali |
| | TRX-008    | Bumi Manusia    | 2026-09-01 | -          |Pinjam| |
| +------------+-----------------+------------+------------+------+ |
|                                                                   |
| [ Kembali ke Data Anggota ]                                       |
+-------------------------------------------------------------------+
```

---

## 4. Penyelarasan Desain & Antisipasi Kasus Khusus (*Edge Cases*)

1. **Konsistensi Visual & Navigasi:**
   - Seluruh halaman turunan mengadopsi struktur semantik konsisten: `<header>`, `<nav>`, `<main>`, `<section>`, dan `<footer>`[cite: 1].
   - Skema warna dan hierarki tata letak tetap merujuk pada styling yang telah dibangun di Jobsheet 2 dan 3[cite: 1].

2. **Kondisi Khusus (Edge Cases):**
   - **Koleksi Habis (`stok == 0`):** Buku yang tidak memiliki eksemplar fisik tersedia dilarang untuk dipilih pada form peminjaman (dinonaktifkan pada elemen select)[cite: 1].
   - **Tunggakan Anggota:** Sistem memblokir aksi tambah pinjam jika anggota masih memegang koleksi yang melewati batas tempo sebelum diselesaikan di form pengembalian[cite: 1].
   - **Integritas Stok:** Transaksi peminjaman dan pengembalian wajib dijalankan secara atomik (*database transaction*) untuk menjamin pembaruan kuantitas stok buku tidak bernilai negatif atau mengalami anomali data[cite: 1].