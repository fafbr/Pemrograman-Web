document.addEventListener("DOMContentLoaded", () => {
    // Handler Submit Form Tambah/Edit Data
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Data berhasil disimpan! (Simulasi Jobsheet 05)");
            window.location.href = form.getAttribute("data-redirect") || "list.html";
        });
    });

    // Handler Tombol Hapus (Hardcoded Row Alert)
    const deleteButtons = document.querySelectorAll(".btn-delete");
    deleteButtons.forEach((button) => {
        button.addEventListener("click", (e) => {
            e.preventDefault();
            if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
                const row = button.closest("tr");
                if (row) {
                    row.remove();
                    alert("Data berhasil dihapus dari tampilan (Temporary DOM).");
                }
            }
        });
    });
});