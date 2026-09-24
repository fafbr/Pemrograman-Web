document.addEventListener("DOMContentLoaded", () => {
    // Global Form Submit Handler (Simulasi Submit Form)
    const forms = document.querySelectorAll("form");
    forms.forEach((form) => {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            alert("Data berhasil disimpan! (Simulasi Jobsheet 06)");
            window.location.href = form.getAttribute("data-redirect") || "list.html";
        });
    });
});

// Global Function untuk Delete Row dari DOM
function deleteRow(btn) {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        const row = btn.closest("tr");
        if (row) row.remove();
    }
}