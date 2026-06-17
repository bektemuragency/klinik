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
                    Randevu Yönetimi
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Randevular
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Gelen randevu taleplerini takip et, filtrele, detayları incele ve manuel randevu oluştur.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <button onclick="openCreateModal()"
                        class="bg-white text-slate-900 hover:bg-blue-50 px-4 py-2 rounded-xl text-sm font-bold transition">
                    + Manuel Randevu
                </button>

                <button onclick="refreshAppointments()"
                        id="refreshBtn"
                        class="bg-white/10 hover:bg-white/15 border border-white/15 text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                    Yenile
                </button>
            </div>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-blue-50 rounded-full"></div>

            <div class="relative">
                <p class="text-xs text-slate-500 uppercase font-bold tracking-wide">
                    Toplam
                </p>

                <div class="flex items-end justify-between mt-3">
                    <h2 id="stat_total" class="text-4xl font-black text-slate-900">0</h2>
                    <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl">
                        📅
                    </div>
                </div>

                <p class="text-xs text-slate-400 mt-2">Tüm randevu talepleri</p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-yellow-50 rounded-full"></div>

            <div class="relative">
                <p class="text-xs text-yellow-700 uppercase font-bold tracking-wide">
                    Bekleyen
                </p>

                <div class="flex items-end justify-between mt-3">
                    <h2 id="stat_pending" class="text-4xl font-black text-yellow-700">0</h2>
                    <div class="w-11 h-11 rounded-2xl bg-yellow-500 text-white flex items-center justify-center text-xl">
                        ⏳
                    </div>
                </div>

                <p class="text-xs text-slate-400 mt-2">İşlem bekleyen kayıtlar</p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-green-50 rounded-full"></div>

            <div class="relative">
                <p class="text-xs text-green-700 uppercase font-bold tracking-wide">
                    Onaylı
                </p>

                <div class="flex items-end justify-between mt-3">
                    <h2 id="stat_confirmed" class="text-4xl font-black text-green-700">0</h2>
                    <div class="w-11 h-11 rounded-2xl bg-green-600 text-white flex items-center justify-center text-xl">
                        ✅
                    </div>
                </div>

                <p class="text-xs text-slate-400 mt-2">Onaylanmış randevular</p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-red-50 rounded-full"></div>

            <div class="relative">
                <p class="text-xs text-red-700 uppercase font-bold tracking-wide">
                    İptal
                </p>

                <div class="flex items-end justify-between mt-3">
                    <h2 id="stat_cancelled" class="text-4xl font-black text-red-700">0</h2>
                    <div class="w-11 h-11 rounded-2xl bg-red-600 text-white flex items-center justify-center text-xl">
                        ❌
                    </div>
                </div>

                <p class="text-xs text-slate-400 mt-2">İptal edilen kayıtlar</p>
            </div>
        </div>

    </div>

    <!-- FILTER -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-5">

        <div class="flex flex-col lg:flex-row lg:items-end gap-4">

            <div class="flex-1">
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                    Ara
                </label>

                <input type="text"
                       id="searchInput"
                       placeholder="Ad, telefon, email, hizmet veya not ara..."
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="w-full lg:w-48">
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                    Durum
                </label>

                <select id="statusFilter"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Tüm Durumlar</option>
                    <option value="pending">Bekleyen</option>
                    <option value="confirmed">Onaylı</option>
                    <option value="cancelled">İptal</option>
                </select>
            </div>

            <div class="w-full lg:w-48">
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                    Başlangıç
                </label>

                <input type="date"
                       id="dateFrom"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="w-full lg:w-48">
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                    Bitiş
                </label>

                <input type="date"
                       id="dateTo"
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

        <div id="filterInfo"
             class="hidden mt-4 bg-blue-50 border border-blue-100 text-blue-700 rounded-2xl px-4 py-3 text-sm font-semibold">
        </div>

    </div>

    <!-- LIST -->
    <div id="list" class="space-y-4"></div>

    <div id="pagination" class="flex flex-wrap justify-center items-center gap-2 mt-8"></div>

</div>

<!-- MANUEL RANDEVU MODAL -->
<div id="createModal"
     class="hidden fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-50 items-center justify-center p-4">

    <div class="bg-white rounded-3xl shadow-2xl max-w-4xl w-full max-h-[92vh] overflow-hidden border border-slate-100">

        <div class="relative overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-teal-900 p-6 text-white">

            <div class="absolute -top-20 -right-20 w-52 h-52 bg-white/10 rounded-full blur-3xl"></div>

            <div class="relative flex justify-between items-start gap-4">
                <div>
                    <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-3 py-1 text-xs font-semibold mb-3">
                        <span class="w-2 h-2 rounded-full bg-green-400"></span>
                        Admin İşlemi
                    </div>

                    <h2 class="text-2xl font-black">Manuel Randevu Ekle</h2>
                    <p class="text-blue-100 text-sm mt-1">
                        Telefonla veya klinikte alınan randevuları hızlıca sisteme kaydet.
                    </p>
                </div>

                <button onclick="closeCreateModal()"
                        class="w-10 h-10 rounded-xl bg-white/10 hover:bg-white/15 border border-white/15 flex items-center justify-center text-2xl leading-none">
                    ×
                </button>
            </div>

        </div>

        <form id="createForm" class="p-6 grid md:grid-cols-2 gap-4 overflow-auto max-h-[70vh]">

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Ad Soyad</label>
                <input type="text"
                       name="full_name"
                       required
                       placeholder="Örn: Ahmet Yılmaz"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Telefon</label>
                <input type="text"
                       name="phone"
                       required
                       placeholder="0 (5XX) XXX XX XX"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Email</label>
                <input type="email"
                       name="email"
                       placeholder="ornek@mail.com"
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Hizmet</label>
                <select name="service_id"
                        id="createServiceSelect"
                        required
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Hizmet seçiniz</option>
                </select>
            </div>

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Randevu Tarihi</label>
                <input type="date"
                       name="appointment_date"
                       required
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Randevu Saati</label>
                <input type="time"
                       name="appointment_time"
                       required
                       class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Durum</label>
                <select name="status"
                        class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="confirmed">Onaylı</option>
                    <option value="pending">Bekleyen</option>
                    <option value="cancelled">İptal</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="block text-xs text-slate-500 uppercase font-bold mb-2">Not</label>
                <textarea name="message"
                          rows="4"
                          placeholder="Hasta notu, özel istek veya açıklama..."
                          class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
            </div>

            <div id="createMsg" class="hidden md:col-span-2 rounded-2xl px-4 py-3 text-sm font-semibold"></div>

            <div class="md:col-span-2 flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button type="button"
                        onclick="closeCreateModal()"
                        class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl text-sm font-bold transition">
                    Vazgeç
                </button>

                <button type="submit"
                        id="createBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60 disabled:cursor-not-allowed">
                    Randevu Oluştur
                </button>
            </div>

        </form>

    </div>

</div>

<script>
let currentPage = 1;
const perPage = 10;

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

function formatDate(value) {
    if (!value) return '-';

    const parts = String(value).split('-');

    if (parts.length !== 3) return esc(value);

    return `${parts[2]}.${parts[1]}.${parts[0]}`;
}

function formatTime(value) {
    if (!value) return '-';
    return esc(String(value).slice(0, 5));
}

function formatDateTime(value) {
    if (!value) return '-';

    const dateObj = new Date(String(value).replace(' ', 'T'));

    if (isNaN(dateObj.getTime())) {
        return esc(value);
    }

    return dateObj.toLocaleString('tr-TR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function getStatus(status) {
    const statusMap = {
        pending: {
            label: "Bekliyor",
            cls: "bg-yellow-100 text-yellow-800 border-yellow-200",
            dot: "bg-yellow-500"
        },
        confirmed: {
            label: "Onaylı",
            cls: "bg-green-100 text-green-800 border-green-200",
            dot: "bg-green-500"
        },
        cancelled: {
            label: "İptal",
            cls: "bg-red-100 text-red-800 border-red-200",
            dot: "bg-red-500"
        }
    };

    return statusMap[status] ?? {
        label: esc(status || 'Bilinmiyor'),
        cls: "bg-slate-100 text-slate-700 border-slate-200",
        dot: "bg-slate-400"
    };
}

function buildTimeInfo(date, time) {
    if (!date || !time) return '-';

    const appointmentDateTime = new Date(`${date}T${String(time).slice(0, 5)}:00`);

    if (isNaN(appointmentDateTime.getTime())) return '-';

    const now = new Date();
    const diffMs = appointmentDateTime.getTime() - now.getTime();
    const absMs = Math.abs(diffMs);

    const days = Math.floor(absMs / (1000 * 60 * 60 * 24));
    const hours = Math.floor((absMs / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((absMs / (1000 * 60)) % 60);

    if (diffMs > 0) {
        if (days > 0) return `${days} gün ${hours} saat sonra`;
        if (hours > 0) return `${hours} saat ${minutes} dk sonra`;
        return `${minutes} dk sonra`;
    }

    if (days > 0) return `${days} gün ${hours} saat önce`;
    if (hours > 0) return `${hours} saat ${minutes} dk önce`;
    return `${minutes} dk önce`;
}

function getQueryParams(page = 1) {
    const params = new URLSearchParams();

    params.set("page", page);
    params.set("per_page", perPage);

    const q = document.getElementById("searchInput").value.trim();
    const status = document.getElementById("statusFilter").value;
    const dateFrom = document.getElementById("dateFrom").value;
    const dateTo = document.getElementById("dateTo").value;

    if (q) params.set("q", q);
    if (status) params.set("status", status);
    if (dateFrom) params.set("date_from", dateFrom);
    if (dateTo) params.set("date_to", dateTo);

    return params.toString();
}

function hasActiveFilters() {
    return Boolean(
        document.getElementById("searchInput").value.trim() ||
        document.getElementById("statusFilter").value ||
        document.getElementById("dateFrom").value ||
        document.getElementById("dateTo").value
    );
}

function updateFilterInfo(total = null) {
    const filterInfo = document.getElementById("filterInfo");

    if (!hasActiveFilters()) {
        filterInfo.classList.add("hidden");
        filterInfo.innerText = "";
        return;
    }

    filterInfo.innerText = total !== null ? `${total} sonuç bulundu.` : "Filtre aktif.";
    filterInfo.classList.remove("hidden");
}

async function loadStats() {
    try {
        const res = await fetch("../api/admin/appt-list.php?stats=1", {
            cache: "no-store"
        });

        const data = await res.json();

        if (!data.success || !data.data) return;

        document.getElementById("stat_total").innerText = data.data.total ?? 0;
        document.getElementById("stat_pending").innerText = data.data.pending ?? 0;
        document.getElementById("stat_confirmed").innerText = data.data.confirmed ?? 0;
        document.getElementById("stat_cancelled").innerText = data.data.cancelled ?? 0;

    } catch (err) {
        console.error("Stats yüklenemedi", err);
    }
}

async function loadAppointments(page = 1) {
    currentPage = page;

    const list = document.getElementById("list");
    const paginationBox = document.getElementById("pagination");

    list.innerHTML = `
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-slate-500">
            Randevular yükleniyor...
        </div>
    `;

    paginationBox.innerHTML = "";

    try {
        const cacheBuster = Date.now();
        const res = await fetch(`../api/admin/appt-list.php?${getQueryParams(page)}&_=${cacheBuster}`, {
            cache: "no-store"
        });

        const json = await res.json();

        if (!json.success || !json.data || !Array.isArray(json.data.items)) {
            list.innerHTML = `
                <div class="bg-red-50 text-red-700 p-5 rounded-3xl border border-red-100">
                    Randevular yüklenemedi.
                </div>
            `;
            return;
        }

        renderAppointments(json.data.items);
        renderPagination(json.data.pagination);

        const total = json.data.pagination?.total ?? json.data.items.length;
        updateFilterInfo(total);

    } catch (err) {
        list.innerHTML = `
            <div class="bg-red-50 text-red-700 p-5 rounded-3xl border border-red-100">
                Sunucu hatası oluştu. Randevular yüklenemedi.
            </div>
        `;
    }
}

function renderAppointments(items) {
    const list = document.getElementById("list");
    list.innerHTML = "";

    if (!items || items.length === 0) {
        list.innerHTML = `
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center">
                <div class="text-5xl mb-3">📅</div>
                <h3 class="font-black text-slate-800 text-lg">Randevu bulunamadı</h3>
                <p class="text-sm text-slate-500 mt-1">Filtrelere uygun kayıt yok.</p>
            </div>
        `;
        return;
    }

    items.forEach(item => {
        const id = safeId(item.id);
        const fullName = esc(item.full_name || 'İsimsiz');
        const phone = esc(item.phone || '-');
        const email = esc(item.email || '-');
        const serviceTitle = esc(item.service_title || "Hizmet seçilmemiş");

        const dateRaw = item.appointment_date || "";
        const timeRaw = item.appointment_time || "";

        const date = formatDate(dateRaw);
        const time = formatTime(timeRaw);
        const createdAt = formatDateTime(item.created_at);
        const timeInfo = esc(buildTimeInfo(dateRaw, timeRaw));

        const st = getStatus(item.status);

        list.innerHTML += `
            <div class="group bg-white rounded-3xl shadow-sm border border-slate-100 hover:shadow-lg hover:border-blue-100 transition overflow-hidden">

                <div class="p-5">

                    <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-5">

                        <div class="flex-1 min-w-0">

                            <div class="flex flex-wrap items-center gap-3 mb-4">

                                <h2 class="text-xl font-black text-slate-900 truncate">
                                    ${fullName}
                                </h2>

                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border ${st.cls}">
                                    <span class="w-2 h-2 rounded-full ${st.dot}"></span>
                                    ${st.label}
                                </span>

                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    ID: ${id}
                                </span>

                            </div>

                            <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-3 text-sm">

                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-xs text-slate-500 font-bold uppercase mb-1">Telefon</p>
                                    <p class="text-slate-800 font-semibold">📞 ${phone}</p>
                                </div>

                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-xs text-slate-500 font-bold uppercase mb-1">Email</p>
                                    <p class="text-slate-800 font-semibold truncate">✉️ ${email}</p>
                                </div>

                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-xs text-slate-500 font-bold uppercase mb-1">Hizmet</p>
                                    <p class="text-slate-800 font-semibold truncate">🧾 ${serviceTitle}</p>
                                </div>

                                <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                                    <p class="text-xs text-slate-500 font-bold uppercase mb-1">Talep Kayıt</p>
                                    <p class="text-slate-800 font-semibold">🕓 ${createdAt}</p>
                                </div>

                            </div>

                            <div class="flex flex-wrap gap-3 mt-4">

                                <div class="inline-flex items-center gap-2 bg-blue-50 text-blue-800 border border-blue-100 px-3 py-2 rounded-xl text-sm font-bold">
                                    📅 ${date}
                                </div>

                                <div class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-800 border border-indigo-100 px-3 py-2 rounded-xl text-sm font-bold">
                                    🕐 ${time}
                                </div>

                                <div class="inline-flex items-center gap-2 bg-slate-50 text-slate-700 border border-slate-100 px-3 py-2 rounded-xl text-sm font-semibold">
                                    ⏳ ${timeInfo}
                                </div>

                            </div>

                        </div>

                        <div class="flex xl:flex-col gap-2 xl:items-end shrink-0">

                            <a href="randevu-detay.php?id=${id}"
                               class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition">
                                Detay →
                            </a>

                        </div>

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
        <button onclick="loadAppointments(${page - 1})"
                ${page <= 1 ? 'disabled' : ''}
                class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
            Önceki
        </button>
    `;

    const start = Math.max(1, page - 2);
    const end = Math.min(totalPages, page + 2);

    if (start > 1) {
        box.innerHTML += `
            <button onclick="loadAppointments(1)"
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
            <button onclick="loadAppointments(${i})"
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
            <button onclick="loadAppointments(${totalPages})"
                    class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50">
                ${totalPages}
            </button>
        `;
    }

    box.innerHTML += `
        <button onclick="loadAppointments(${page + 1})"
                ${page >= totalPages ? 'disabled' : ''}
                class="px-4 py-2 rounded-xl border bg-white text-sm font-bold hover:bg-slate-50 disabled:opacity-50 disabled:cursor-not-allowed">
            Sonraki
        </button>
    `;
}

function applyFilters() {
    loadAppointments(1);
}

function clearFilters() {
    document.getElementById("searchInput").value = "";
    document.getElementById("statusFilter").value = "";
    document.getElementById("dateFrom").value = "";
    document.getElementById("dateTo").value = "";

    updateFilterInfo();
    loadAppointments(1);
}

async function refreshAppointments() {
    const btn = document.getElementById("refreshBtn");

    btn.disabled = true;
    btn.innerText = "Yenileniyor...";

    try {
        await loadStats();
        await loadAppointments(currentPage);
    } finally {
        btn.disabled = false;
        btn.innerText = "Yenile";
    }
}

/*
========================
MANUEL RANDEVU
========================
*/
function openCreateModal() {
    document.getElementById("createModal").classList.remove("hidden");
    document.getElementById("createModal").classList.add("flex");
}

function closeCreateModal() {
    document.getElementById("createModal").classList.add("hidden");
    document.getElementById("createModal").classList.remove("flex");

    const msg = document.getElementById("createMsg");
    msg.classList.add("hidden");
    msg.innerText = "";
}

function showCreateMsg(type, text) {
    const msg = document.getElementById("createMsg");

    msg.className = type === "success"
        ? "md:col-span-2 rounded-2xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "md:col-span-2 rounded-2xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    msg.innerText = text;
    msg.classList.remove("hidden");
}

async function loadServicesForCreate() {
    const select = document.getElementById("createServiceSelect");

    try {
        const res = await fetch("../api/admin/service-list.php?_=" + Date.now(), {
            cache: "no-store"
        });

        const data = await res.json();

        select.innerHTML = `<option value="">Hizmet seçiniz</option>`;

        let services = [];

        if (data.success && Array.isArray(data.data)) {
            services = data.data;
        } else if (data.success && data.data && Array.isArray(data.data.items)) {
            services = data.data.items;
        }

        services.forEach(service => {
            if (Number(service.is_active) !== 1) return;

            select.innerHTML += `
                <option value="${safeId(service.id)}">
                    ${esc(service.title)}
                </option>
            `;
        });

    } catch (err) {
        select.innerHTML = `<option value="">Hizmetler yüklenemedi</option>`;
    }
}

document.getElementById("createForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const btn = document.getElementById("createBtn");

    btn.disabled = true;
    btn.innerText = "Kaydediliyor...";

    const fd = new FormData(e.target);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    try {
        const res = await fetch("../api/admin/appt-create.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            showCreateMsg("success", data.message || "Randevu oluşturuldu");

            e.target.reset();

            setTimeout(() => {
                closeCreateModal();
                loadStats();
                loadAppointments(1);
            }, 700);

        } else {
            showCreateMsg("error", data.message || "İşlem başarısız");
        }

    } catch (err) {
        showCreateMsg("error", "Sunucu hatası");
    }

    btn.disabled = false;
    btn.innerText = "Randevu Oluştur";
});

/*
|--------------------------------------------------------------------------
| FİLTRE DAVRANIŞI
|--------------------------------------------------------------------------
| Yazınca otomatik arama yok.
| Filtrele butonuna basınca çalışır.
| Enter basınca çalışır.
|--------------------------------------------------------------------------
*/
["searchInput", "statusFilter", "dateFrom", "dateTo"].forEach((fieldId) => {
    document.getElementById(fieldId).addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            applyFilters();
        }
    });
});

loadStats();
loadServicesForCreate();
loadAppointments(1);
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>