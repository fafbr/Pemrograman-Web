document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("anggota-tbody");
    const inputCari = document.getElementById("input-cari");

    const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

    async function muatDataAnggota() {
        if (!tbody) return;

        tbody.innerHTML = `
            <tr>
                <td colspan="6" class="py-14 text-center text-slate-500 font-medium">
                    <div class="inline-flex flex-col items-center gap-3">
                        <span class="w-7 h-7 border-3 border-emerald-600 border-t-transparent rounded-full animate-spin"></span>
                        <span class="text-sm tracking-wide">Sedang memuat data anggota...</span>
                    </div>
                </td>
            </tr>
        `;

        try {
            await delay(700);

            const response = await fetch("../data/anggota.json");
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const dataAnggota = await response.json();

            if (dataAnggota.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="py-8 text-center text-slate-400">Tidak ada data anggota terdaftar.</td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = dataAnggota.map((anggota, index) => {
                const isZebra = index % 2 === 1 ? "bg-slate-50/40" : "";
                return `
                    <tr class="${isZebra} hover:bg-emerald-50/40 transition-colors">
                        <td class="py-4 px-5 font-mono font-bold text-emerald-800 whitespace-nowrap">${anggota.no_anggota}</td>
                        <td class="py-4 px-5 font-semibold text-slate-900 whitespace-nowrap">${anggota.nama}</td>
                        <td class="py-4 px-5 text-slate-600 whitespace-nowrap">${anggota.alamat}</td>
                        <td class="py-4 px-5 text-slate-500 whitespace-nowrap">${anggota.no_hp}</td>
                        <td class="py-4 px-5 text-slate-500 whitespace-nowrap">${anggota.tgl_bergabung}</td>
                        <td class="py-4 px-5 whitespace-nowrap text-center space-x-1.5">
                            <button type="button" class="bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-300/80 text-xs font-bold px-3 py-1.5 rounded-lg transition">Edit</button>
                            <button type="button" class="btn-hapus bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-300/80 text-xs font-bold px-3 py-1.5 rounded-lg transition">Hapus</button>
                        </td>
                    </tr>
                `;
            }).join("");

        } catch (error) {
            console.error("Gagal memuat data anggota:", error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="py-10 text-center text-rose-600 font-semibold">
                        Gagal memuat data anggota. Pastikan server lokal aktif.
                    </td>
                </tr>
            `;
        }
    }

    if (tbody) {
        tbody.addEventListener("click", (e) => {
            const targetBtn = e.target.closest(".btn-hapus");
            if (targetBtn) {
                const row = targetBtn.closest("tr");
                const nama = row.cells[1]?.textContent.trim();
                if (confirm(`Apakah Anda yakin ingin menghapus anggota "${nama}"?`)) {
                    row.remove();
                }
            }
        });
    }

    if (inputCari && tbody) {
        inputCari.addEventListener("input", () => {
            const keyword = inputCari.value.toLowerCase().trim();
            const rows = tbody.querySelectorAll("tr");

            rows.forEach((row) => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(keyword) ? "" : "none";
            });
        });
    }

    muatDataAnggota();
});