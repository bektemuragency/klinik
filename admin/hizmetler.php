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
                    Hizmet Yönetimi
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Hizmetler
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Klinik hizmetlerini listele, düzenle, sil ve yeni hizmet ekle.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <button onclick="refreshServices()"
                        id="refreshBtn"
                        class="bg-white/10 hover:bg-white/15 border border-white/15 text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                    Yenile
                </button>

                <a href="hizmet-ekle.php"
                   class="bg-white text-slate-900 hover:bg-blue-50 px-4 py-2 rounded-xl text-sm font-bold transition">
                    + Yeni Hizmet
                </a>
            </div>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide">
                Toplam Hizmet
            </p>
            <h2 id="stat_total" class="text-4xl font-black text-slate-900 mt-3">0</h2>
            <p class="text-xs text-slate-400 mt-2">Tüm hizmet kayıtları</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-green-700 uppercase font-bold tracking-wide">
                Aktif
            </p>
            <h2 id="stat_active" class="text-4xl font-black text-green-700 mt-3">0</h2>
            <p class="text-xs text-slate-400 mt-2">Sitede görünen hizmetler</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-red-700 uppercase font-bold tracking-wide">
                Pasif
            </p>
            <h2 id="stat_passive" class="text-4xl font-black text-red-700 mt-3">0</h2>
            <p class="text-xs text-slate-400 mt-2">Sitede gizlenen hizmetler</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <p class="text-xs text-blue-700 uppercase font-bold tracking-wide">
                Sayfa
            </p>
            <h2 id="stat_page" class="text-4xl font-black text-blue-700 mt-3">1</h2>
            <p class="text-xs text-slate-400 mt-2">Aktif liste sayfası</p>
        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">

        <div class="grid md:grid-cols-5 gap-4">

            <div class="md:col-span-3">
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                    Hizmet Ara
                </label>

                <input type="text"
                       id="searchInput"
                       placeholder="Başlık veya açıklama ara..."
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                    Durum
                </label>

                <select id="statusFilter"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tüm Hizmetler</option>
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button onclick="applyFilters()"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-xl text-sm font-bold w-full">
                    Filtrele
                </button>

                <button onclick="clearFilters()"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 rounded-xl text-sm font-bold">
                    Temizle
                </button>
            </div>

        </div>

        <div id="filterInfo" class="hidden mt-4 text-sm text-slate-500"></div>

    </div>

    <!-- LIST -->
    <div id="list" class="grid lg:grid-cols-2 gap-4"></div>

    <div id="pagination" class="flex flex-wrap justify-center items-center gap-2 mt-6"></div>

</div>

<script>
let currentPage = 1;
const perPage = 6;

let allServices = [];

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
    return String(value ?? '')
        .toLocaleLowerCase('tr-TR')
        .trim();
}

function truncateText(value, max = 110) {
    const text = String(value ?? '').trim();

    if (!text) return '-';

    if (text.length <= max) return esc(text);

    return esc(text.slice(0, max)) + '...';
}

function getImageUrl(path) {
    const imagePath = String(path ?? '').trim();

    if (!imagePath) {
        return '';
    }

    if (imagePath.startsWith('http://') || imagePath.startsWith('https://')) {
        return imagePath;
    }

    return '../' + imagePath.replace(/^\/+/, '');
}

function getStatusData(value) {
    const active = Number(value) === 1;

    if (active) {
        return {
            label: 'Aktif',
            cls: 'bg-green-100 text-green-800 border-green-200',
            dot: 'bg-green-500'
        };
    }

    return {
        label: 'Pasif',
        cls: 'bg-red-100 text-red-800 border-red-200',
        dot: 'bg-red-500'
    };
}

function setText(id, value) {
    const el = document.getElementById(id);

    if (el) {
        el.innerText = value ?? 0;
    }
}

function hasActiveFilters() {
    return Boolean(
        document.getElementById('searchInput').value.trim() ||
        document.getElementById('statusFilter').value !== ''
    );
}

function updateStats(items, pagination = null) {
    const total = allServices.length;
    const active = allServices.filter(item => Number(item.is_active) === 1).length;
    const passive = allServices.filter(item => Number(item.is_active) !== 1).length;

    setText('stat_total', total);
    setText('stat_active', active);
    setText('stat_passive', passive);
    setText('stat_page', pagination?.page ?? currentPage);

    const info = document.getElementById('filterInfo');

    if (hasActiveFilters()) {
        info.innerText = `${items.length} sonuç gösteriliyor.`;
        info.classList.remove('hidden');
    } else {
        info.innerText = '';
        info.classList.add('hidden');
    }
}

function applyLocalFilters(items) {
    const q = normalize(document.getElementById('searchInput').value);
    const status = document.getElementById('statusFilter').value;

    return items.filter(item => {
        const statusOk = status === '' || String(Number(item.is_active)) === status;

        const searchable = normalize([
            item.title,
            item.slug,
            item.short_desc,
            item.content
        ].join(' '));

        const keywordOk = !q || searchable.includes(q);

        return statusOk && keywordOk;
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

async function fetchAllServices() {
    const cacheBuster = Date.now();

    const res = await fetch('../api/admin/service-list.php?_=' + cacheBuster, {
        cache: 'no-store'
    });

    const data = await res.json();

    if (data.success && Array.isArray(data.data)) {
        allServices = data.data;
        return;
    }

    if (data.success && data.data && Array.isArray(data.data.items)) {
        allServices = data.data.items;
        return;
    }

    allServices = [];
}

async function loadServices(page = 1, forceFetch = false) {
    currentPage = page;

    const list = document.getElementById("list");
    const paginationBox = document.getElementById("pagination");

    list.innerHTML = `
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-slate-500">
            Hizmetler yükleniyor...
        </div>
    `;

    paginationBox.innerHTML = "";

    try {
        if (forceFetch || allServices.length === 0) {
            await fetchAllServices();
        }

        const filtered = applyLocalFilters(allServices);
        const result = paginateLocal(filtered, page);

        renderServices(result.items);
        renderPagination(result.pagination);
        updateStats(filtered, result.pagination);

    } catch (err) {
        list.innerHTML = `
            <div class="lg:col-span-2 bg-red-50 text-red-700 p-5 rounded-3xl border border-red-100">
                Hizmetler yüklenemedi.
            </div>
        `;
    }
}

function renderServices(items) {
    const list = document.getElementById("list");
    list.innerHTML = "";

    if (!items || items.length === 0) {
        list.innerHTML = `
            <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center">
                <div class="text-5xl mb-3">🧾</div>
                <h3 class="font-black text-slate-800 text-lg">Hizmet bulunamadı</h3>
                <p class="text-sm text-slate-500 mt-1">Filtrelere uygun hizmet kaydı yok.</p>
            </div>
        `;
        return;
    }

    items.forEach(item => {
        const id = safeId(item.id);
        const title = esc(item.title || 'Başlıksız Hizmet');
        const slug = esc(item.slug || '-');
        const shortDesc = truncateText(item.short_desc, 130);
        const imagePath = getImageUrl(item.image_path);
        const sortOrder = esc(item.sort_order ?? '-');
        const st = getStatusData(item.is_active);

        list.innerHTML += `
            <div class="group bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-100 transition overflow-hidden">

                <div class="flex gap-4 p-5">

                    <div class="w-28 h-28 shrink-0 rounded-2xl overflow-hidden bg-slate-100 border border-slate-100">
                        ${
                            imagePath
                                ? `<img src="${esc(imagePath)}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300" alt="${title}">`
                                : `<div class="w-full h-full flex items-center justify-center text-3xl text-slate-300">🧾</div>`
                        }
                    </div>

                    <div class="min-w-0 flex-1">

                        <div class="flex items-start justify-between gap-3">

                            <div class="min-w-0">
                                <h2 class="text-lg font-black text-slate-900 truncate">
                                    ${title}
                                </h2>

                                <p class="text-xs text-slate-400 mt-1 truncate">
                                    Slug: ${slug}
                                </p>
                            </div>

                            <span class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full border text-xs font-bold ${st.cls}">
                                <span class="w-2 h-2 rounded-full ${st.dot}"></span>
                                ${st.label}
                            </span>

                        </div>

                        <p class="text-sm text-slate-500 mt-3 leading-relaxed">
                            ${shortDesc}
                        </p>

                        <div class="flex flex-wrap items-center gap-2 mt-4">

                            <span class="bg-slate-50 border border-slate-100 rounded-full px-3 py-1 text-xs font-semibold text-slate-500">
                                Sıra: ${sortOrder}
                            </span>

                            <span class="bg-blue-50 border border-blue-100 rounded-full px-3 py-1 text-xs font-semibold text-blue-700">
                                ID: ${id}
                            </span>

                        </div>

                    </div>

                </div>

                <div class="flex justify-between items-center gap-3 px-5 py-4 bg-slate-50 border-t border-slate-100">

                    <a href="../hizmet-detay.php?slug=${encodeURIComponent(item.slug || '')}"
                       target="_blank"
                       class="text-sm font-bold text-slate-600 hover:text-blue-600">
                        Sitede Gör →
                    </a>

                    <div class="flex gap-2">

                        <a href="hizmet-duzenle.php?id=${id}"
                           class="bg-yellow-500 hover:bg-yellow-600 px-3 py-2 text-white rounded-xl text-sm font-bold transition">
                            Düzenle
                        </a>

                        <button onclick="deleteService(${id})"
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
        <button onclick="loadServices(${page - 1})"
                ${page <= 1 ? 'disabled' : ''}
                class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
            Önceki
        </button>
    `;

    const start = Math.max(1, page - 2);
    const end = Math.min(totalPages, page + 2);

    if (start > 1) {
        box.innerHTML += `
            <button onclick="loadServices(1)"
                    class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50">
                1
            </button>
        `;

        if (start > 2) {
            box.innerHTML += `<span class="px-2 text-slate-400">...</span>`;
        }
    }

    for (let i = start; i <= end; i++) {
        box.innerHTML += `
            <button onclick="loadServices(${i})"
                    class="px-4 py-2 rounded-xl border text-sm font-bold ${i === page ? 'bg-blue-600 text-white border-blue-600' : 'bg-white hover:bg-slate-50'}">
                ${i}
            </button>
        `;
    }

    if (end < totalPages) {
        if (end < totalPages - 1) {
            box.innerHTML += `<span class="px-2 text-slate-400">...</span>`;
        }

        box.innerHTML += `
            <button onclick="loadServices(${totalPages})"
                    class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50">
                ${totalPages}
            </button>
        `;
    }

    box.innerHTML += `
        <button onclick="loadServices(${page + 1})"
                ${page >= totalPages ? 'disabled' : ''}
                class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
            Sonraki
        </button>
    `;
}

function applyFilters() {
    loadServices(1);
}

function clearFilters() {
    document.getElementById('searchInput').value = '';
    document.getElementById('statusFilter').value = '';

    loadServices(1);
}

async function refreshServices() {
    const btn = document.getElementById("refreshBtn");
    const list = document.getElementById("list");

    btn.disabled = true;
    btn.innerText = "Yenileniyor...";

    list.innerHTML = `
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-slate-500">
            Hizmetler yenileniyor...
        </div>
    `;

    try {
        allServices = [];
        await loadServices(1, true);
    } finally {
        btn.disabled = false;
        btn.innerText = "Yenile";
    }
}

async function deleteService(id) {
    id = safeId(id);

    if (!id) {
        alert("Geçersiz ID");
        return;
    }

    if (!confirm("Bu hizmet silinsin mi?")) return;

    const fd = new FormData();
    fd.append("id", id);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    try {
        const res = await fetch("../api/admin/service-delete.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json().catch(() => ({}));

        if (data.success === false) {
            alert(data.message || "Silme işlemi başarısız");
            return;
        }

        allServices = allServices.filter(item => safeId(item.id) !== id);

        loadServices(currentPage);

    } catch (err) {
        alert("Sunucu hatası oluştu");
    }
}

/*
|--------------------------------------------------------------------------
| FİLTRE DAVRANIŞI
|--------------------------------------------------------------------------
| Yazınca otomatik filtreleme yok.
| Filtrele butonuna basınca çalışır.
| Enter basınca çalışır.
|--------------------------------------------------------------------------
*/
["searchInput", "statusFilter"].forEach((fieldId) => {
    document.getElementById(fieldId).addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            applyFilters();
        }
    });
});

loadServices(1, true);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>