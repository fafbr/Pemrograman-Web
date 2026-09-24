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

    // Global Mobile Menu Toggle Logic (Smooth Transition)
    const btn = document.getElementById("mobile-menu-btn");
    const menu = document.getElementById("mobile-menu");
    const iconOpen = document.getElementById("menu-icon-open");
    const iconClose = document.getElementById("menu-icon-close");

    if (btn && menu) {
        btn.addEventListener("click", () => {
            const isOpen = menu.style.maxHeight && menu.style.maxHeight !== "0px";

            if (isOpen) {
                menu.style.maxHeight = "0px";
                iconOpen.classList.remove("hidden");
                iconOpen.classList.add("block");
                iconClose.classList.remove("block");
                iconClose.classList.add("hidden");
            } else {
                menu.style.maxHeight = menu.scrollHeight + "px";
                iconOpen.classList.remove("block");
                iconOpen.classList.add("hidden");
                iconClose.classList.remove("hidden");
                iconClose.classList.add("block");
            }
        });
    }
});

// Global Function untuk Delete Row dari DOM
function deleteRow(btn) {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        const row = btn.closest("tr");
        if (row) row.remove();
    }
}