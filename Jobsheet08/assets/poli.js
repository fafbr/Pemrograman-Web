let listPoliData = [];

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("tbody-poli")) {
        loadDataPoli();
    }
});

async function loadDataPoli() {
    const tbody = document.getElementById("tbody-poli");
    try {
        const res = await fetch("../data/poli.json");
        listPoliData = await res.json();
        renderTablePoli(listPoliData);
        setupSearchPoli();
    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-rose-500">Gagal memuat data poliklinik.</td></tr>`;
    }
}

function renderTablePoli(data) {
    const tbody = document.getElementById("tbody-poli");
    if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="4" class="py-6 text-center text-slate-400">Data poliklinik tidak ditemukan.</td></tr>`;
        return;
    }

    tbody.innerHTML = data.map((item) => `
        <tr class="hover:bg-slate-50/80 transition">
            <td class="py-4 px-6 font-semibold text-slate-400">#${item.id}</td>
            <td class="py-4 px-6 font-semibold text-slate-800">${item.nama}</td>
            <td class="py-4 px-6 text-slate-600">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                    📍 ${item.lokasi}
                </span>
            </td>
            <td class="py-4 px-6 text-right space-x-2">
                <button class="px-3 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition">Edit</button>
                <button onclick="deleteRow(this)" class="px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition">Hapus</button>
            </td>
        </tr>
    `).join("");
}

function setupSearchPoli() {
    const searchInput = document.getElementById("search-poli");
    if (!searchInput) return;

    searchInput.addEventListener("input", (e) => {
        const keyword = e.target.value.toLowerCase();
        const filtered = listPoliData.filter((item) =>
            item.nama.toLowerCase().includes(keyword) || item.lokasi.toLowerCase().includes(keyword)
        );
        renderTablePoli(filtered);
    });
}