document.addEventListener("DOMContentLoaded", () => {
    const tbody = document.getElementById("buku-tbody");
    const inputCari = document.getElementById("input-cari");

    const delay = (ms) => new Promise((resolve) => setTimeout(resolve, ms));

    async function muatDataBuku() {
        if (!tbody) return;

        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="py-14 text-center text-slate-500 font-medium">
                    <div class="inline-flex flex-col items-center gap-3">
                        <span class="w-7 h-7 border-3 border-emerald-600 border-t-transparent rounded-full animate-spin"></span>
                        <span class="text-sm tracking-wide">Sedang memuat data katalog buku...</span>
                    </div>
                </td>
            </tr>
        `;

        try {
            await delay(700);

            const response = await fetch("../data/buku.json");
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const dataBuku = await response.json();

            if (dataBuku.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="5" class="py-8 text-center text-slate-400">Tidak ada koleksi buku yang tersedia.</td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = dataBuku.map((buku, index) => {
                const isZebra = index % 2 === 1 ? "bg-slate-50/40" : "";
                const stokBadge = buku.stok > 0
                        ? `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> ${buku.stok} Eks
                        </span>`
                        : `<span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Habis
                        </span>`;

                return `
                    <tr class="${isZebra} hover:bg-emerald-50/40 transition-colors">
                        <td class="py-4 px-5 font-semibold text-slate-900 whitespace-nowrap">${buku.judul}</td>
                        <td class="py-4 px-5 text-slate-600 whitespace-nowrap">${buku.pengarang}</td>
                        <td class="py-4 px-5 text-slate-500 whitespace-nowrap">${buku.tahun}</td>
                        <td class="py-4 px-5 whitespace-nowrap">${stokBadge}</td>
                        <td class="py-4 px-5 whitespace-nowrap text-center space-x-1">
                            <button type="button" class="bg-amber-50 hover:bg-amber-100 text-amber-700 border border-amber-300/80 text-xs font-bold px-3 py-1.5 rounded-lg transition">Edit</button>
                            <button type="button" class="bg-sky-50 hover:bg-sky-100 text-sky-700 border border-sky-300/80 text-xs font-bold px-3 py-1.5 rounded-lg transition">Detail</button>
                            <button type="button" class="btn-hapus bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-300/80 text-xs font-bold px-3 py-1.5 rounded-lg transition">Hapus</button>
                        </td>
                    </tr>
                `;
            }).join("");

        } catch (error) {
            console.error("Gagal memuat katalog buku:", error);
            tbody.innerHTML = `
                <tr>
                    <td colspan="5" class="py-10 text-center text-rose-600 font-semibold">
                        Gagal memuat data buku. Pastikan server lokal aktif.
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
                const judul = row.cells[0]?.textContent.trim();
                if (confirm(`Apakah Anda yakin ingin menghapus buku "${judul}"?`)) {
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

    muatDataBuku();
});