let listDokterData = [];

document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("tbody-dokter")) {
        loadDataDokter();
    }
    if (document.getElementById("select-poli")) {
        populatePoliOptions();
    }
});

async function loadDataDokter() {
    const tbody = document.getElementById("tbody-dokter");
    try {
        const res = await fetch("../data/dokter.json");
        listDokterData = await res.json();
        renderTableDokter(listDokterData);
        setupSearchDokter();
    } catch (err) {
        tbody.innerHTML = `<tr><td colspan="6" class="py-6 text-center text-rose-500">Gagal memuat data dokter.</td></tr>`;
    }
}

function renderTableDokter(data) {
    const tbody = document.getElementById("tbody-dokter");
    if (data.length === 0) {
        tbody.innerHTML = `<tr><td colspan="6" class="py-6 text-center text-slate-400">Data dokter tidak ditemukan.</td></tr>`;
        return;
    }

    tbody.innerHTML = data.map((item) => {
        const badgeColor = item.idPoli === 1 
            ? 'bg-indigo-50 text-indigo-700 border-indigo-100' 
            : item.idPoli === 2 
            ? 'bg-purple-50 text-purple-700 border-purple-100' 
            : 'bg-emerald-50 text-emerald-700 border-emerald-100';

        return `
            <tr class="hover:bg-slate-50/80 transition">
                <td class="py-4 px-6 font-semibold text-slate-400">#${item.id}</td>
                <td class="py-4 px-6 font-semibold text-slate-900">${item.nama}</td>
                <td class="py-4 px-6">
                    <span class="px-2.5 py-1 rounded-md text-xs font-semibold border ${badgeColor}">${item.namaPoli}</span>
                </td>
                <td class="py-4 px-6 font-mono text-xs text-slate-500">${item.sip}</td>
                <td class="py-4 px-6 text-slate-600">${item.jadwal}</td>
                <td class="py-4 px-6 text-right space-x-2">
                    <button class="px-3 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 rounded-lg transition">Edit</button>
                    <button onclick="deleteRow(this)" class="px-3 py-1.5 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition">Hapus</button>
                </td>
            </tr>
        `;
    }).join("");
}

function setupSearchDokter() {
    const searchInput = document.getElementById("search-dokter");
    if (!searchInput) return;

    searchInput.addEventListener("input", (e) => {
        const keyword = e.target.value.toLowerCase();
        const filtered = listDokterData.filter((item) =>
            item.nama.toLowerCase().includes(keyword) || 
            item.namaPoli.toLowerCase().includes(keyword) ||
            item.sip.toLowerCase().includes(keyword)
        );
        renderTableDokter(filtered);
    });
}

// Populate Dropdown Poli di Form Tambah Dokter
async function populatePoliOptions() {
    const select = document.getElementById("select-poli");
    try {
        const res = await fetch("../data/poli.json");
        const poliData = await res.json();
        poliData.forEach((item) => {
            const opt = document.createElement("option");
            opt.value = item.id;
            opt.textContent = item.nama;
            select.appendChild(opt);
        });
    } catch (err) {
        console.error("Gagal memuat opsi poli", err);
    }
}