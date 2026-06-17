<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- HEADER -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-blue-950 to-teal-900 p-6 md:p-8 text-white shadow-xl">

        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-teal-400/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-3 py-1 text-xs font-semibold mb-4">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    Doktor Yönetimi
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Doktorlar
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Klinik kadrosundaki doktorları listele, düzenle, sil ve yeni doktor ekle.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <button onclick="refreshDoctors()"
                        id="refreshBtn"
                        class="bg-white/10 hover:bg-white/15 border border-white/15 text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                    Yenile
                </button>

                <a href="doktor-ekle.php"
                   class="bg-white text-slate-900 hover:bg-blue-50 px-4 py-2 rounded-xl text-sm font-bold transition">
                    + Yeni Doktor
                </a>
            </div>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide">
                Toplam Doktor
            </p>
            <h2 id="stat_total" class="text-4xl font-black text-slate-900 mt-3">0</h2>
            <p class="text-xs text-slate-400 mt-2">Tüm doktor kayıtları</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-blue-700 uppercase font-bold tracking-wide">
                Bu Sayfa
            </p>
            <h2 id="stat_page" class="text-4xl font-black text-blue-700 mt-3">1</h2>
            <p class="text-xs text-slate-400 mt-2">Aktif liste sayfası</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-teal-700 uppercase font-bold tracking-wide">
                Görseli Olan
            </p>
            <h2 id="stat_image" class="text-4xl font-black text-teal-700 mt-3">0</h2>
            <p class="text-xs text-slate-400 mt-2">Fotoğraflı doktorlar</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-purple-700 uppercase font-bold tracking-wide">
                Liste
            </p>
            <h2 class="text-4xl font-black text-purple-700 mt-3">CRM</h2>
            <p class="text-xs text-slate-400 mt-2">Doktor panel görünümü</p>
        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">

        <div class="flex flex-col md:flex-row md:items-end gap-4">

            <div class="flex-1">
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                    Doktor Ara
                </label>

                <input type="text"
                       id="searchInput"
                       placeholder="Ad, unvan, branş, telefon veya email ara..."
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="flex gap-2">
                <button onclick="applyFilters()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition">
                    Filtrele
                </button>

                <button onclick="clearFilters()"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl text-sm font-bold transition">
                    Temizle
                </button>
            </div>

        </div>

        <div id="filterInfo" class="hidden mt-4 bg-blue-50 border border-blue-100 text-blue-700 rounded-2xl px-4 py-3 text-sm font-semibold"></div>

    </div>

    <!-- LIST -->
    <div id="list" class="grid lg:grid-cols-2 gap-4"></div>

    <div id="pagination" class="flex flex-wrap justify-center items-center gap-2 mt-8"></div>

</div>

<script>
let currentPage = 1;
const perPage = 6;
let allDoctors = [];

function esc(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function safeId(value) {
    return Number.parseInt(value, 10) || 0;
}

function normalize(value) {
    return String(value ?? '').toLocaleLowerCase('tr-TR').trim();
}

function truncateText(value, max = 120) {
    const text = String(value ?? '').trim();

    if (!text) return '-';
    if (text.length <= max) return esc(text);

    return esc(text.slice(0, max)) + '...';
}

function getImageUrl(path) {
    const imagePath = String(path ?? '').trim();

    if (!imagePath) return '';

    if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
        return imagePath;
    }

    return '../' + imagePath.replace(/^\/+/, '');
}

function setText(id, value) {
    const el = document.getElementById(id);

    if (el) {
        el.innerText = value ?? 0;
    }
}

function normalizeDoctorsResponse(data) {
    if (data.success && Array.isArray(data.data)) {
        return data.data;
    }

    if (data.success && data.data && Array.isArray(data.data.items)) {
        return data.data.items;
    }

    return [];
}

async function fetchAllDoctors() {
    const res = await fetch('../api/admin/doctor-list.php?_=' + Date.now(), {
        cache: 'no-store'
    });

    const data = await res.json();
    allDoctors = normalizeDoctorsResponse(data);
}

function hasActiveFilters() {
    return Boolean(document.getElementById('searchInput').value.trim());
}

function applyLocalFilters(items) {
    const q = normalize(document.getElementById('searchInput').value);

    return items.filter(item => {
        const searchable = normalize([
            item.name,
            item.title,
            item.specialty,
            item.bio,
            item.phone,
            item.email
        ].join(' '));

        return !q || searchable.includes(q);
    });
}

function paginateLocal(items, page = 1) {
    const total = items.length;
    const totalPages = Math.max(1, Math.ceil(total / perPage));
    const safePage = Math.min(Math.max(1, page), totalPages);

    currentPage = safePage;

    const start = (safePage - 1) * perPage;
    const end = start + perPage;

    return {
        items: items.slice(start, end),
        pagination: {
            page: safePage,
            per_page: perPage,
            total: total,
            total_pages: totalPages
        }
    };
}

function updateStats(filtered, pagination) {
    setText('stat_total', allDoctors.length);
    setText('stat_page', pagination?.page ?? currentPage);
    setText('stat_image', allDoctors.filter(item => String(item.image ?? '').trim() !== '').length);

    const info = document.getElementById('filterInfo');

    if (hasActiveFilters()) {
        info.innerText = `${filtered.length} sonuç gösteriliyor.`;
        info.classList.remove('hidden');
    } else {
        info.innerText = '';
        info.classList.add('hidden');
    }
}

async function loadDoctors(page = 1, forceFetch = false) {
    currentPage = page;

    const list = document.getElementById("list");
    const paginationBox = document.getElementById("pagination");

    list.innerHTML = `
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-slate-500">
            Doktorlar yükleniyor...
        </div>
    `;

    paginationBox.innerHTML = "";

    try {
        if (forceFetch || allDoctors.length === 0) {
            await fetchAllDoctors();
        }

        const filtered = applyLocalFilters(allDoctors);
        const result = paginateLocal(filtered, page);

        renderDoctors(result.items);
        renderPagination(result.pagination);
        updateStats(filtered, result.pagination);

    } catch (err) {
        list.innerHTML = `
            <div class="lg:col-span-2 bg-red-50 text-red-700 p-5 rounded-3xl border border-red-100">
                Doktorlar yüklenemedi.
            </div>
        `;
    }
}

function renderDoctors(items) {
    const list = document.getElementById("list");
    list.innerHTML = "";

    if (!items || items.length === 0) {
        list.innerHTML = `
            <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center">
                <div class="text-5xl mb-3">👨‍⚕️</div>
                <h3 class="font-black text-slate-800 text-lg">Doktor bulunamadı</h3>
                <p class="text-sm text-slate-500 mt-1">Filtrelere uygun doktor kaydı yok.</p>
            </div>
        `;
        return;
    }

    items.forEach(item => {
        const id = safeId(item.id);
        const name = esc(item.name || 'İsimsiz Doktor');
        const title = esc(item.title || '-');
        const specialty = esc(item.specialty || '-');
        const phone = esc(item.phone || '-');
        const email = esc(item.email || '-');
        const bio = truncateText(item.bio, 120);
        const image = getImageUrl(item.image);

        list.innerHTML += `
            <div class="group bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-100 transition overflow-hidden">

                <div class="p-5 flex gap-4">

                    <div class="w-28 h-28 shrink-0 rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">
                        ${
                            image
                                ? `<img src="${esc(image)}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="${name}">`
                                : `<div class="w-full h-full flex items-center justify-center text-4xl text-slate-300">👨‍⚕️</div>`
                        }
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex items-start justify-between gap-3">
                            <div class="min-w-0">
                                <h2 class="text-lg font-black text-slate-900 truncate">
                                    ${name}
                                </h2>

                                <p class="text-sm text-slate-500 mt-1 truncate">
                                    ${title}${specialty !== '-' ? ' · ' + specialty : ''}
                                </p>
                            </div>

                            <span class="shrink-0 bg-blue-50 text-blue-700 border border-blue-100 rounded-full px-3 py-1 text-xs font-bold">
                                ID: ${id}
                            </span>
                        </div>

                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            ${bio}
                        </p>

                        <div class="flex flex-wrap gap-2 mt-4">
                            <span class="bg-slate-50 border border-slate-100 rounded-full px-3 py-1 text-xs font-semibold text-slate-500">
                                📞 ${phone}
                            </span>

                            <span class="bg-slate-50 border border-slate-100 rounded-full px-3 py-1 text-xs font-semibold text-slate-500 truncate max-w-full">
                                ✉️ ${email}
                            </span>
                        </div>

                    </div>

                </div>

                <div class="flex justify-between items-center gap-3 px-5 py-4 bg-slate-50 border-t border-slate-100">

                    <span class="text-sm font-bold text-slate-600">
                        Doktor Kaydı
                    </span>

                    <div class="flex gap-2">

                        <a href="doktor-duzenle.php?id=${id}"
                           class="bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-white rounded-xl text-sm font-bold transition">
                            Düzenle
                        </a>

                        <button onclick="deleteDoctor(${id})"
                                class="bg-red-600 hover:bg-red-700 px-3 py-2 text-white rounded-xl text-sm font-bold transition">
                            Sil
                        </button>

                    </div>

                </div>

            </div>
        `;
    });
}

function renderPagination(pagination) {
    const box = document.getElementById("pagination");
    box.innerHTML = "";

    if (!pagination) return;

    const page = Number(pagination.page || 1);
    const totalPages = Number(pagination.total_pages || 1);

    if (totalPages <= 1) return;

    box.innerHTML += `
        <button onclick="loadDoctors(${page - 1})"
                ${page <= 1 ? 'disabled' : ''}
                class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
            Önceki
        </button>
    `;

    const start = Math.max(1, page - 2);
    const end = Math.min(totalPages, page + 2);

    for (let i = start; i <= end; i++) {
        box.innerHTML += `
            <button onclick="loadDoctors(${i})"
                    class="px-4 py-2 rounded-xl border text-sm font-bold ${i === page ? 'bg-blue-600 text-white border-blue-600' : 'bg-white hover:bg-slate-50'}">
                ${i}
            </button>
        `;
    }

    box.innerHTML += `
        <button onclick="loadDoctors(${page + 1})"
                ${page >= totalPages ? 'disabled' : ''}
                class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
            Sonraki
        </button>
    `;
}

function applyFilters() {
    loadDoctors(1);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    loadDoctors(1);
}

async function refreshDoctors() {
    const btn = document.getElementById("refreshBtn");

    btn.disabled = true;
    btn.innerText = "Yenileniyor...";

    try {
        await loadDoctors(1, true);
    } finally {
        btn.disabled = false;
        btn.innerText = "Yenile";
    }
}

async function deleteDoctor(id) {
    id = safeId(id);

    if (!id) {
        alert("Geçersiz ID");
        return;
    }

    if (!confirm("Bu doktor silinsin mi?")) return;

    const fd = new FormData();
    fd.append("id", id);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    try {
        const res = await fetch("../api/admin/doctor-delete.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json().catch(() => ({}));

        if (data.success === false) {
            alert(data.message || "Silme işlemi başarısız");
            return;
        }

        allDoctors = allDoctors.filter(item => safeId(item.id) !== id);
        loadDoctors(currentPage);

    } catch (err) {
        alert("Sunucu hatası oluştu");
    }
}

document.getElementById("searchInput").addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        applyFilters();
    }
});

loadDoctors(1, true);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>