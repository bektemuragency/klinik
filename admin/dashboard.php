<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- HERO -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-950 via-blue-950 to-teal-900 p-6 md:p-8 text-white shadow-xl">

        <div class="absolute -top-24 -right-24 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-72 h-72 bg-teal-400/20 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

            <div>
                <div class="inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-3 py-1 text-xs font-semibold mb-4">
                    <span class="w-2 h-2 rounded-full bg-green-400"></span>
                    KlinikCMS Admin Panel
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Dashboard
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Randevuları, doktorları, hizmetleri ve sistem durumunu tek ekrandan takip et.
                </p>

                <div class="flex flex-wrap gap-3 mt-5">
                    <a href="randevular.php"
                       class="bg-white text-slate-900 hover:bg-blue-50 px-4 py-2 rounded-xl text-sm font-bold transition">
                        Randevuları Yönet
                    </a>

                    <a href="hizmetler.php"
                       class="bg-white/10 hover:bg-white/15 border border-white/15 text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                        Hizmetleri Yönet
                    </a>

                    <a href="ayarlar.php"
                       class="bg-white/10 hover:bg-white/15 border border-white/15 text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                        Klinik Ayarları
                    </a>
                </div>
            </div>

            <div class="bg-white/10 border border-white/15 rounded-2xl p-5 min-w-[240px] backdrop-blur">
                <p class="text-xs text-blue-100 uppercase font-semibold tracking-wide">
                    Bugün
                </p>

                <h2 id="today_text" class="text-2xl font-extrabold mt-2">
                    -
                </h2>

                <p id="clock_text" class="text-blue-100 mt-1 text-sm">
                    -
                </p>

                <div class="mt-4 pt-4 border-t border-white/10">
                    <p class="text-xs text-blue-100">
                        Sistem durumu
                    </p>

                    <div class="flex items-center gap-2 mt-2">
                        <span id="hero_system_dot" class="w-2.5 h-2.5 rounded-full bg-yellow-300"></span>
                        <span id="hero_system_text" class="text-sm font-bold">
                            Kontrol ediliyor
                        </span>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- MAIN STATS -->
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-blue-50 rounded-full"></div>

            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wide">Toplam Randevu</p>
                    <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-sm">📅</div>
                </div>

                <h2 id="total" class="text-4xl font-black text-slate-900 mt-4">0</h2>

                <p class="text-xs text-slate-400 mt-2">
                    Sistemdeki tüm kayıtlar
                </p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-yellow-50 rounded-full"></div>

            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-yellow-700 uppercase font-bold tracking-wide">Bekleyen</p>
                    <div class="w-11 h-11 rounded-2xl bg-yellow-500 text-white flex items-center justify-center text-xl shadow-sm">⏳</div>
                </div>

                <h2 id="pending" class="text-4xl font-black text-yellow-700 mt-4">0</h2>

                <p class="text-xs text-slate-400 mt-2">
                    İşlem bekleyen talepler
                </p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-green-50 rounded-full"></div>

            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-green-700 uppercase font-bold tracking-wide">Onaylı</p>
                    <div class="w-11 h-11 rounded-2xl bg-green-600 text-white flex items-center justify-center text-xl shadow-sm">✅</div>
                </div>

                <h2 id="confirmed" class="text-4xl font-black text-green-700 mt-4">0</h2>

                <p class="text-xs text-slate-400 mt-2">
                    Onaylanmış randevular
                </p>
            </div>
        </div>

        <div class="relative overflow-hidden bg-white rounded-3xl shadow-sm border border-slate-100 p-5">
            <div class="absolute -right-8 -top-8 w-28 h-28 bg-red-50 rounded-full"></div>

            <div class="relative">
                <div class="flex items-center justify-between">
                    <p class="text-xs text-red-700 uppercase font-bold tracking-wide">İptal</p>
                    <div class="w-11 h-11 rounded-2xl bg-red-600 text-white flex items-center justify-center text-xl shadow-sm">❌</div>
                </div>

                <h2 id="cancelled" class="text-4xl font-black text-red-700 mt-4">0</h2>

                <p class="text-xs text-slate-400 mt-2">
                    İptal edilen kayıtlar
                </p>
            </div>
        </div>

    </div>

    <!-- GRID -->
    <div class="grid xl:grid-cols-3 gap-6">

        <!-- LEFT -->
        <div class="xl:col-span-2 space-y-6">

            <!-- PERFORMANCE -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Randevu Performansı</h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Bekleyen, onaylı ve iptal oranları.
                        </p>
                    </div>

                    <button onclick="refreshDashboard()"
                            class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-xl text-sm font-bold transition">
                        Yenile
                    </button>
                </div>

                <div class="grid md:grid-cols-3 gap-4 mb-6">

                    <div class="bg-yellow-50 border border-yellow-100 rounded-2xl p-4">
                        <p class="text-xs text-yellow-700 font-bold uppercase">Bekleyen Oranı</p>
                        <h3 id="pending_rate_text" class="text-2xl font-black text-yellow-800 mt-2">0%</h3>
                    </div>

                    <div class="bg-green-50 border border-green-100 rounded-2xl p-4">
                        <p class="text-xs text-green-700 font-bold uppercase">Onaylı Oranı</p>
                        <h3 id="confirmed_rate_text" class="text-2xl font-black text-green-800 mt-2">0%</h3>
                    </div>

                    <div class="bg-red-50 border border-red-100 rounded-2xl p-4">
                        <p class="text-xs text-red-700 font-bold uppercase">İptal Oranı</p>
                        <h3 id="cancelled_rate_text" class="text-2xl font-black text-red-800 mt-2">0%</h3>
                    </div>

                </div>

                <div class="space-y-5">

                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-slate-600 font-semibold">Bekleyen</span>
                            <span id="pending_bar_text" class="font-bold text-slate-800">0%</span>
                        </div>

                        <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
                            <div id="pending_bar" class="bg-yellow-500 h-4 rounded-full transition-all duration-700" style="width: 0%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-slate-600 font-semibold">Onaylı</span>
                            <span id="confirmed_bar_text" class="font-bold text-slate-800">0%</span>
                        </div>

                        <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
                            <div id="confirmed_bar" class="bg-green-500 h-4 rounded-full transition-all duration-700" style="width: 0%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-sm mb-2">
                            <span class="text-slate-600 font-semibold">İptal</span>
                            <span id="cancelled_bar_text" class="font-bold text-slate-800">0%</span>
                        </div>

                        <div class="w-full bg-slate-100 rounded-full h-4 overflow-hidden">
                            <div id="cancelled_bar" class="bg-red-500 h-4 rounded-full transition-all duration-700" style="width: 0%"></div>
                        </div>
                    </div>

                </div>

                <div id="dashboard_note"
                     class="mt-6 bg-blue-50 border border-blue-100 text-blue-800 rounded-2xl p-4 text-sm font-medium">
                    Veriler yükleniyor...
                </div>

            </div>

            <!-- LATEST APPOINTMENTS -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <div class="flex items-center justify-between mb-5">
                    <div>
                        <h2 class="text-xl font-black text-slate-900">Son Randevular</h2>
                        <p class="text-sm text-slate-500 mt-1">
                            En son gelen randevu talepleri.
                        </p>
                    </div>

                    <a href="randevular.php"
                       class="text-sm font-bold text-blue-600 hover:underline">
                        Tümünü Gör →
                    </a>
                </div>

                <div id="latest_appointments" class="space-y-3">
                    <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm text-slate-500">
                        Randevular yükleniyor...
                    </div>
                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="space-y-6">

            <!-- SYSTEM -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h2 class="text-xl font-black text-slate-900">Sistem Durumu</h2>
                <p class="text-sm text-slate-500 mt-1">
                    API bağlantıları ve panel sağlığı.
                </p>

                <div class="mt-5 bg-slate-50 border border-slate-100 rounded-2xl p-4">
                    <div class="flex items-center gap-3">
                        <span id="system_dot" class="w-4 h-4 rounded-full bg-yellow-400"></span>

                        <div>
                            <p id="system_status" class="font-black text-slate-900">
                                Kontrol ediliyor
                            </p>
                            <p id="system_message" class="text-xs text-slate-500 mt-1">
                                Veriler kontrol ediliyor.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 mt-4">

                    <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4">
                        <p class="text-xs text-blue-700 font-bold uppercase">Doktor</p>
                        <h3 id="doctor_count" class="text-3xl font-black text-blue-900 mt-2">-</h3>
                    </div>

                    <div class="bg-teal-50 border border-teal-100 rounded-2xl p-4">
                        <p class="text-xs text-teal-700 font-bold uppercase">Hizmet</p>
                        <h3 id="service_count" class="text-3xl font-black text-teal-900 mt-2">-</h3>
                    </div>

                </div>

            </div>

            <!-- QUICK ACTIONS -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6">

                <h2 class="text-xl font-black text-slate-900">Hızlı İşlemler</h2>
                <p class="text-sm text-slate-500 mt-1 mb-5">
                    En çok kullanılan admin işlemleri.
                </p>

                <div class="space-y-3">

                    <a href="randevular.php"
                       class="group flex items-center justify-between bg-slate-50 hover:bg-blue-50 border border-slate-100 hover:border-blue-100 rounded-2xl px-4 py-4 transition">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center">📅</span>
                            <span class="font-bold text-slate-800">Randevular</span>
                        </div>
                        <span class="text-slate-400 group-hover:text-blue-600">→</span>
                    </a>

                    <a href="hizmet-ekle.php"
                       class="group flex items-center justify-between bg-slate-50 hover:bg-teal-50 border border-slate-100 hover:border-teal-100 rounded-2xl px-4 py-4 transition">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center">🧾</span>
                            <span class="font-bold text-slate-800">Hizmet Ekle</span>
                        </div>
                        <span class="text-slate-400 group-hover:text-teal-600">→</span>
                    </a>

                    <a href="doktor-ekle.php"
                       class="group flex items-center justify-between bg-slate-50 hover:bg-indigo-50 border border-slate-100 hover:border-indigo-100 rounded-2xl px-4 py-4 transition">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center">👨‍⚕️</span>
                            <span class="font-bold text-slate-800">Doktor Ekle</span>
                        </div>
                        <span class="text-slate-400 group-hover:text-indigo-600">→</span>
                    </a>

                    <a href="ayarlar.php"
                       class="group flex items-center justify-between bg-slate-50 hover:bg-purple-50 border border-slate-100 hover:border-purple-100 rounded-2xl px-4 py-4 transition">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-purple-600 text-white flex items-center justify-center">⚙️</span>
                            <span class="font-bold text-slate-800">Ayarlar</span>
                        </div>
                        <span class="text-slate-400 group-hover:text-purple-600">→</span>
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
async function fetchJson(url) {
    const res = await fetch(url);
    return await res.json();
}

function setText(id, value) {
    const el = document.getElementById(id);

    if (el) {
        el.innerText = value ?? 0;
    }
}

function esc(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function formatDate(value) {
    if (!value) return '-';

    const parts = String(value).split('-');

    if (parts.length !== 3) {
        return esc(value);
    }

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
            cls: "bg-yellow-100 text-yellow-800 border-yellow-200"
        },
        confirmed: {
            label: "Onaylı",
            cls: "bg-green-100 text-green-800 border-green-200"
        },
        cancelled: {
            label: "İptal",
            cls: "bg-red-100 text-red-800 border-red-200"
        }
    };

    return statusMap[status] || {
        label: esc(status || "Bilinmiyor"),
        cls: "bg-slate-100 text-slate-700 border-slate-200"
    };
}

function updateClock() {
    const now = new Date();

    setText("today_text", now.toLocaleDateString("tr-TR", {
        day: "2-digit",
        month: "long",
        year: "numeric"
    }));

    setText("clock_text", now.toLocaleTimeString("tr-TR", {
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit"
    }));
}

function setSystemStatus(ok, message) {
    const dot = document.getElementById("system_dot");
    const status = document.getElementById("system_status");
    const msg = document.getElementById("system_message");

    const heroDot = document.getElementById("hero_system_dot");
    const heroText = document.getElementById("hero_system_text");

    if (ok) {
        dot.className = "w-4 h-4 rounded-full bg-green-500";
        status.innerText = "Aktif";
        msg.innerText = message || "API bağlantıları çalışıyor.";

        heroDot.className = "w-2.5 h-2.5 rounded-full bg-green-400";
        heroText.innerText = "Sistem Aktif";
    } else {
        dot.className = "w-4 h-4 rounded-full bg-red-500";
        status.innerText = "Kontrol Gerekli";
        msg.innerText = message || "Bazı API bağlantıları yanıt vermedi.";

        heroDot.className = "w-2.5 h-2.5 rounded-full bg-red-400";
        heroText.innerText = "Kontrol Gerekli";
    }
}

function percent(part, total) {
    total = Number(total || 0);
    part = Number(part || 0);

    if (total <= 0) return 0;

    return Math.round((part / total) * 100);
}

function updateBars(stats) {
    const total = Number(stats.total || 0);
    const pending = Number(stats.pending || 0);
    const confirmed = Number(stats.confirmed || 0);
    const cancelled = Number(stats.cancelled || 0);

    const pendingRate = percent(pending, total);
    const confirmedRate = percent(confirmed, total);
    const cancelledRate = percent(cancelled, total);

    document.getElementById("pending_bar").style.width = pendingRate + "%";
    document.getElementById("confirmed_bar").style.width = confirmedRate + "%";
    document.getElementById("cancelled_bar").style.width = cancelledRate + "%";

    setText("pending_rate_text", pendingRate + "%");
    setText("confirmed_rate_text", confirmedRate + "%");
    setText("cancelled_rate_text", cancelledRate + "%");

    setText("pending_bar_text", pendingRate + "%");
    setText("confirmed_bar_text", confirmedRate + "%");
    setText("cancelled_bar_text", cancelledRate + "%");

    const note = document.getElementById("dashboard_note");

    if (total === 0) {
        note.className = "mt-6 bg-slate-50 border border-slate-100 text-slate-700 rounded-2xl p-4 text-sm font-medium";
        note.innerText = "Henüz randevu kaydı yok. İlk kayıt geldiğinde özet burada görünecek.";
        return;
    }

    if (pending > 0) {
        note.className = "mt-6 bg-yellow-50 border border-yellow-100 text-yellow-800 rounded-2xl p-4 text-sm font-medium";
        note.innerText = `${pending} bekleyen randevu var. Randevular sayfasından kontrol etmen iyi olur.`;
        return;
    }

    note.className = "mt-6 bg-green-50 border border-green-100 text-green-800 rounded-2xl p-4 text-sm font-medium";
    note.innerText = "Bekleyen randevu yok. Panel düzenli görünüyor.";
}

async function loadAppointmentStats() {
    const data = await fetchJson("../api/admin/appt-list.php?stats=1");

    if (!data.success || !data.data) {
        throw new Error("Randevu istatistikleri alınamadı");
    }

    const stats = data.data;

    setText("total", stats.total);
    setText("pending", stats.pending);
    setText("confirmed", stats.confirmed);
    setText("cancelled", stats.cancelled);

    updateBars(stats);

    return true;
}

async function loadLatestAppointments() {
    const box = document.getElementById("latest_appointments");

    try {
        const data = await fetchJson("../api/admin/appt-list.php?page=1&per_page=3");

        if (!data.success || !data.data || !Array.isArray(data.data.items)) {
            box.innerHTML = `
                <div class="bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4 text-sm">
                    Son randevular yüklenemedi.
                </div>
            `;
            return false;
        }

        const items = data.data.items;

        if (items.length === 0) {
            box.innerHTML = `
                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm text-slate-500">
                    Henüz randevu yok.
                </div>
            `;
            return true;
        }

        box.innerHTML = "";

        items.forEach((item) => {
            const st = getStatus(item.status);
            const id = Number.parseInt(item.id, 10) || 0;

            box.innerHTML += `
                <a href="randevu-detay.php?id=${id}"
                   class="block bg-slate-50 hover:bg-slate-100 border border-slate-100 rounded-2xl p-4 transition">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <h3 class="font-black text-slate-900 truncate">
                                ${esc(item.full_name || "İsimsiz")}
                            </h3>

                            <p class="text-sm text-slate-500 mt-1 truncate">
                                ${esc(item.service_title || "Hizmet seçilmemiş")}
                            </p>

                            <div class="flex flex-wrap gap-2 mt-3 text-xs font-semibold">
                                <span class="bg-white border border-slate-200 rounded-full px-2.5 py-1">
                                    📅 ${formatDate(item.appointment_date)}
                                </span>

                                <span class="bg-white border border-slate-200 rounded-full px-2.5 py-1">
                                    🕐 ${formatTime(item.appointment_time)}
                                </span>
                            </div>
                        </div>

                        <span class="shrink-0 inline-flex px-2.5 py-1 rounded-full border text-xs font-bold ${st.cls}">
                            ${st.label}
                        </span>
                    </div>
                </a>
            `;
        });

        return true;

    } catch (err) {
        box.innerHTML = `
            <div class="bg-red-50 border border-red-100 text-red-700 rounded-2xl p-4 text-sm">
                Son randevular yüklenemedi.
            </div>
        `;
        return false;
    }
}

async function loadDoctorCount() {
    try {
        const data = await fetchJson("../api/doctors.php?stats=1");

        if (data.success && data.data && typeof data.data.count !== "undefined") {
            setText("doctor_count", data.data.count);
            return true;
        }

        const listData = await fetchJson("../api/admin/doctor-list.php");

        if (listData.success && Array.isArray(listData.data)) {
            setText("doctor_count", listData.data.length);
            return true;
        }

        setText("doctor_count", "-");
        return false;

    } catch (err) {
        setText("doctor_count", "-");
        return false;
    }
}

async function loadServiceCount() {
    try {
        const data = await fetchJson("../api/admin/service-list.php");

        if (data.success && Array.isArray(data.data)) {
            setText("service_count", data.data.length);
            return true;
        }

        setText("service_count", "-");
        return false;

    } catch (err) {
        setText("service_count", "-");
        return false;
    }
}

async function refreshDashboard() {
    setSystemStatus(true, "Veriler yenileniyor...");

    let okCount = 0;
    const totalChecks = 4;

    try {
        await loadAppointmentStats();
        okCount++;
    } catch (err) {
        console.error(err);
    }

    if (await loadLatestAppointments()) {
        okCount++;
    }

    if (await loadDoctorCount()) {
        okCount++;
    }

    if (await loadServiceCount()) {
        okCount++;
    }

    if (okCount === totalChecks) {
        setSystemStatus(true, "Randevu, doktor ve hizmet verileri çalışıyor.");
    } else if (okCount > 0) {
        setSystemStatus(false, "Bazı veriler yüklendi ama bazı API bağlantıları kontrol edilmeli.");
    } else {
        setSystemStatus(false, "Dashboard verileri yüklenemedi.");
    }
}

updateClock();
setInterval(updateClock, 1000);

refreshDashboard();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>