document.addEventListener("DOMContentLoaded", () => {
    // 1. Mobile Menu Toggle
    const btnMenu = document.getElementById("btn-menu");
    const navMenu = document.getElementById("nav-menu");

    if (btnMenu && navMenu) {
        btnMenu.addEventListener("click", () => {
            navMenu.classList.toggle("hidden");
            navMenu.classList.toggle("block");
        });
    }

    // Helper Fungsi Render Error
    const renderError = (inputEl, message) => {
        inputEl.classList.add("border-rose-500");
        const span = document.createElement("span");
        span.className = "error-msg block text-xs font-semibold text-rose-600 mt-1";
        span.textContent = message;
        inputEl.parentElement.appendChild(span);
    };

    const clearErrors = () => {
        document.querySelectorAll(".error-msg").forEach((el) => el.remove());
        document.querySelectorAll(".border-rose-500").forEach((el) => el.classList.remove("border-rose-500"));
    };

    // 2. Validasi Form Tambah Buku
    const formBuku = document.getElementById("form-buku");
    if (formBuku) {
        formBuku.addEventListener("submit", (e) => {
            let isValid = true;
            clearErrors();

            const judul = document.getElementById("judul");
            const pengarang = document.getElementById("pengarang");
            const tahun = document.getElementById("tahun");
            const isbn = document.getElementById("isbn");
            const stok = document.getElementById("stok");

            if (judul.value.trim() === "") {
                isValid = false;
                renderError(judul, "Judul buku wajib diisi.");
            }

            if (pengarang.value.trim() === "") {
                isValid = false;
                renderError(pengarang, "Nama pengarang wajib diisi.");
            }

            const tahunVal = parseInt(tahun.value, 10);
            const currentYear = new Date().getFullYear();
            if (isNaN(tahunVal) || tahunVal < 1900 || tahunVal > currentYear) {
                isValid = false;
                renderError(tahun, `Tahun harus antara 1900–${currentYear}.`);
            }

            if (isbn.value.trim() === "") {
                isValid = false;
                renderError(isbn, "Nomor ISBN wajib diisi.");
            }

            const stokVal = parseInt(stok.value, 10);
            if (isNaN(stokVal) || stokVal < 0) {
                isValid = false;
                renderError(stok, "Stok tidak boleh bernilai negatif.");
            }

            if (!isValid) {
                e.preventDefault();
            } else {
                alert("Data buku valid dan siap disimpan!");
                e.preventDefault();
            }
        });
    }

    // 3. Validasi Form Tambah Anggota
    const formAnggota = document.getElementById("form-anggota");
    if (formAnggota) {
        formAnggota.addEventListener("submit", (e) => {
            let isValid = true;
            clearErrors();

            const nama = document.getElementById("nama");
            const noAnggota = document.getElementById("no_anggota");
            const email = document.getElementById("email");
            const noHp = document.getElementById("no_hp");

            if (nama.value.trim() === "") {
                isValid = false;
                renderError(nama, "Nama lengkap wajib diisi.");
            }

            if (noAnggota.value.trim() === "") {
                isValid = false;
                renderError(noAnggota, "Nomor anggota wajib diisi.");
            }

            // Validasi format email sederhana
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value.trim() === "") {
                isValid = false;
                renderError(email, "Alamat email wajib diisi.");
            } else if (!emailPattern.test(email.value.trim())) {
                isValid = false;
                renderError(email, "Format email tidak valid (contoh: user@mail.com).");
            }

            // Validasi format nomor HP jika diisi
            if (noHp.value.trim() !== "" && !/^[0-9+]{9,15}$/.test(noHp.value.trim())) {
                isValid = false;
                renderError(noHp, "Nomor HP hanya boleh berisi 9-15 digit angka.");
            }

            if (!isValid) {
                e.preventDefault();
            } else {
                alert("Data anggota valid dan siap disimpan!");
                e.preventDefault();
            }
        });
    }

    // 4. Pencarian Tabel Real-Time
    const inputCari = document.getElementById("input-cari");
    const tbody = document.querySelector("table tbody");

    if (inputCari && tbody) {
        inputCari.addEventListener("input", () => {
            const keyword = inputCari.value.toLowerCase().trim();
            const rows = tbody.querySelectorAll("tr");

            rows.forEach((row) => {
                const rowText = row.textContent.toLowerCase();
                row.style.display = rowText.includes(keyword) ? "" : "none";
            });
        });
    }

    // 5. Konfirmasi Hapus Data
    const btnHapusList = document.querySelectorAll(".btn-hapus");
    btnHapusList.forEach((btn) => {
        btn.addEventListener("click", () => {
            const row = btn.closest("tr");
            const namaItem = row.cells[0]?.textContent.trim();

            if (confirm(`Apakah Anda yakin ingin menghapus "${namaItem}"?`)) {
                row.remove();
            }
        });
    });
});