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
                    Randevu Detayı
                </div>

                <h1 id="page_title" class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Randevu Detayı
                </h1>

                <p id="page_subtitle" class="text-blue-100 mt-2 max-w-2xl">
                    Hasta bilgileri, randevu zamanı, notlar ve durum işlemleri.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="randevular.php"
                   class="bg-white text-slate-900 hover:bg-blue-50 px-4 py-2 rounded-xl text-sm font-bold transition">
                    ← Listeye Dön
                </a>
            </div>

        </div>

    </div>

    <!-- LOADING -->
    <div id="loading" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-slate-500">
        Randevu bilgileri yükleniyor...
    </div>

    <!-- CONTENT -->
    <div id="content" class="hidden space-y-6">

        <!-- TOP SUMMARY -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="p-6 flex flex-col xl:flex-row xl:items-center xl:justify-between gap-5">

                <div class="flex items-start gap-4 min-w-0">

                    <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-2xl shrink-0">
                        👤
                    </div>

                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-3">
                            <h2 id="full_name_head" class="text-2xl font-black text-slate-900 truncate">
                                -
                            </h2>

                            <span id="status_head" class="inline-flex px-3 py-1 rounded-full border text-xs font-bold">
                                -
                            </span>
                        </div>

                        <p id="service_head" class="text-sm text-slate-500 mt-1">
                            -
                        </p>

                        <div class="flex flex-wrap gap-2 mt-4 text-sm">

                            <span class="inline-flex items-center gap-2 bg-blue-50 text-blue-800 border border-blue-100 px-3 py-2 rounded-xl font-bold">
                                📅 <span id="summary_requested_date">-</span>
                            </span>

                            <span class="inline-flex items-center gap-2 bg-indigo-50 text-indigo-800 border border-indigo-100 px-3 py-2 rounded-xl font-bold">
                                🕐 <span id="summary_requested_time">-</span>
                            </span>

                            <span class="inline-flex items-center gap-2 bg-slate-50 text-slate-700 border border-slate-100 px-3 py-2 rounded-xl font-semibold">
                                🕓 <span id="summary_created_at">-</span>
                            </span>

                        </div>
                    </div>

                </div>

                <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 xl:max-w-sm">
                    <p class="text-xs text-slate-500 uppercase font-bold mb-1">
                        Zaman Özeti
                    </p>

                    <p id="time_summary" class="text-sm text-slate-700 font-semibold leading-relaxed">
                        -
                    </p>
                </div>

            </div>

        </div>

        <!-- MAIN GRID -->
        <div class="grid xl:grid-cols-3 gap-6">

            <!-- LEFT CONTENT -->
            <div class="xl:col-span-2 space-y-6">

                <!-- PATIENT INFO -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-xl font-black text-slate-900">
                            Hasta Bilgileri
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Randevu talebini oluşturan kişinin iletişim bilgileri.
                        </p>
                    </div>

                    <div class="p-6 grid md:grid-cols-2 gap-4">

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-1">Ad Soyad</p>
                            <p id="full_name" class="text-slate-900 font-black text-lg">-</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-1">Telefon</p>
                            <p id="phone" class="text-slate-900 font-black text-lg">-</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-1">Email</p>
                            <p id="email" class="text-slate-900 font-black text-lg break-all">-</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-1">IP Adresi</p>
                            <p id="ip_address" class="text-slate-900 font-black text-lg">-</p>
                        </div>

                        <div class="rounded-2xl border border-green-100 bg-green-50 p-4">
                            <p class="text-xs text-green-700 uppercase font-bold mb-1">KVKK Onayı</p>
                            <p id="kvkk_consent" class="text-green-900 font-black text-lg">-</p>
                        </div>

                        <div class="rounded-2xl border border-green-100 bg-green-50 p-4">
                            <p class="text-xs text-green-700 uppercase font-bold mb-1">KVKK Onay Tarihi</p>
                            <p id="kvkk_consent_at" class="text-green-900 font-black text-lg">-</p>
                        </div>

                    </div>

                </div>

                <!-- APPOINTMENT INFO -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-xl font-black text-slate-900">
                            Randevu Bilgileri
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Seçilen hizmet, randevu tarihi ve sistem kayıt zamanları.
                        </p>
                    </div>

                    <div class="p-6 grid md:grid-cols-2 gap-4">

                        <div class="rounded-2xl border border-teal-100 bg-teal-50 p-4 md:col-span-2">
                            <p class="text-xs text-teal-700 uppercase font-bold mb-1">Seçilen Hizmet</p>
                            <p id="service_title" class="text-teal-950 font-black text-lg">-</p>
                        </div>

                        <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                            <p class="text-xs text-blue-700 uppercase font-bold mb-1">Randevu Tarihi</p>
                            <p id="appointment_date" class="text-blue-950 font-black text-xl">-</p>
                        </div>

                        <div class="rounded-2xl border border-indigo-100 bg-indigo-50 p-4">
                            <p class="text-xs text-indigo-700 uppercase font-bold mb-1">Randevu Saati</p>
                            <p id="appointment_time" class="text-indigo-950 font-black text-xl">-</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-1">Kayıt Zamanı</p>
                            <p id="created_at" class="text-slate-900 font-black">-</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-1">Son Güncelleme</p>
                            <p id="updated_at" class="text-slate-900 font-black">-</p>
                        </div>

                    </div>

                </div>

                <!-- NOTES -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-xl font-black text-slate-900">
                            Notlar
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Kullanıcı notu ve admin işlem notu.
                        </p>
                    </div>

                    <div class="p-6 space-y-5">

                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold mb-2">
                                Kullanıcı Notu
                            </p>

                            <div id="message"
                                 class="bg-slate-50 border border-slate-100 rounded-2xl p-4 text-sm text-slate-700 min-h-[90px] whitespace-pre-wrap leading-relaxed">
                                -
                            </div>
                        </div>

                        <div>
                            <label for="admin_note" class="block text-xs text-slate-500 uppercase font-bold mb-2">
                                Admin Notu
                            </label>

                            <textarea id="admin_note"
                                      class="w-full border border-slate-200 rounded-2xl p-4 min-h-[150px] text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Admin notu yaz..."></textarea>

                            <p class="text-xs text-slate-400 mt-2">
                                Bu not, durum güncellemesiyle birlikte kaydedilir.
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            <!-- RIGHT PANEL -->
            <div class="space-y-6">

                <!-- ACTION PANEL -->
                <div class="sticky top-6 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-xl font-black text-slate-900">
                            Durum İşlemleri
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Randevu durumunu güncelle.
                        </p>
                    </div>

                    <div class="p-6 space-y-3">

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4 mb-4">
                            <p class="text-xs text-slate-500 uppercase font-bold mb-2">
                                Mevcut Durum
                            </p>

                            <span id="status_side" class="inline-flex px-3 py-1 rounded-full border text-xs font-bold">
                                -
                            </span>
                        </div>

                        <button onclick="updateStatus('confirmed')"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60">
                            ✅ Onayla
                        </button>

                        <button onclick="updateStatus('pending')"
                                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60">
                            ⏳ Beklemeye Al
                        </button>

                        <button onclick="updateStatus('cancelled')"
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60">
                            ❌ İptal Et
                        </button>

                        <div id="actionMsg" class="hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>

                    </div>

                </div>

                <!-- MINI HELP -->
                <div class="bg-blue-50 border border-blue-100 rounded-3xl p-5">
                    <p class="text-sm font-black text-blue-900">
                        Bilgi
                    </p>

                    <p class="text-sm text-blue-800 mt-1 leading-relaxed">
                        Randevu durumu değiştirildiğinde admin notu da aynı işlemde kaydedilir.
                    </p>
                </div>

            </div>

        </div>

    </div>

</div>

<script>
const id = new URLSearchParams(window.location.search).get('id');

function esc(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function formatTime(value) {
    if (!value) return '-';
    return String(value).slice(0, 5);
}

function formatDate(value) {
    if (!value) return '-';

    const parts = String(value).split('-');

    if (parts.length !== 3) {
        return value;
    }

    return `${parts[2]}.${parts[1]}.${parts[0]}`;
}

function formatDateTime(value) {
    if (!value) return '-';

    const dateObj = new Date(String(value).replace(' ', 'T'));

    if (isNaN(dateObj.getTime())) {
        return value;
    }

    return dateObj.toLocaleString('tr-TR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

function formatStatus(status) {
    const statusMap = {
        pending: {
            label: "Bekliyor",
            className: "inline-flex px-3 py-1 rounded-full border text-xs font-bold bg-yellow-100 text-yellow-800 border-yellow-200"
        },
        confirmed: {
            label: "Onaylı",
            className: "inline-flex px-3 py-1 rounded-full border text-xs font-bold bg-green-100 text-green-800 border-green-200"
        },
        cancelled: {
            label: "İptal",
            className: "inline-flex px-3 py-1 rounded-full border text-xs font-bold bg-red-100 text-red-800 border-red-200"
        }
    };

    return statusMap[status] || {
        label: status || "-",
        className: "inline-flex px-3 py-1 rounded-full border text-xs font-bold bg-slate-100 text-slate-700 border-slate-200"
    };
}

function setText(id, value) {
    const el = document.getElementById(id);

    if (el) {
        el.innerText = value || '-';
    }
}

function setStatusElements(status) {
    const statusData = formatStatus(status);

    ["status_head", "status_side"].forEach((elId) => {
        const el = document.getElementById(elId);

        if (el) {
            el.innerText = statusData.label;
            el.className = statusData.className;
        }
    });
}

function buildAppointmentDateTime(date, time) {
    if (!date || !time) return null;

    const cleanTime = String(time).slice(0, 5);
    const value = `${date}T${cleanTime}:00`;
    const dateObj = new Date(value);

    if (isNaN(dateObj.getTime())) {
        return null;
    }

    return dateObj;
}

function buildTimeSummary(appointmentDate, appointmentTime, createdAt) {
    const requestedDateTime = buildAppointmentDateTime(appointmentDate, appointmentTime);

    if (!requestedDateTime) {
        return 'Randevu tarihi veya saati hesaplanamadı.';
    }

    const now = new Date();
    const diffMs = requestedDateTime.getTime() - now.getTime();

    const requestedText = `${formatDate(appointmentDate)} ${formatTime(appointmentTime)}`;

    let summary = `Kullanıcı ${requestedText} için randevu talep etmiş.`;

    if (createdAt) {
        summary += ` Talep sisteme ${formatDateTime(createdAt)} tarihinde düşmüş.`;
    }

    const absMs = Math.abs(diffMs);
    const diffDays = Math.floor(absMs / (1000 * 60 * 60 * 24));
    const diffHours = Math.floor((absMs / (1000 * 60 * 60)) % 24);
    const diffMinutes = Math.floor((absMs / (1000 * 60)) % 60);

    if (diffMs > 0) {
        if (diffDays > 0) {
            summary += ` Randevuya yaklaşık ${diffDays} gün ${diffHours} saat var.`;
        } else if (diffHours > 0) {
            summary += ` Randevuya yaklaşık ${diffHours} saat ${diffMinutes} dakika var.`;
        } else {
            summary += ` Randevuya yaklaşık ${diffMinutes} dakika var.`;
        }
    } else {
        if (diffDays > 0) {
            summary += ` Randevu zamanı yaklaşık ${diffDays} gün ${diffHours} saat önce geçmiş.`;
        } else if (diffHours > 0) {
            summary += ` Randevu zamanı yaklaşık ${diffHours} saat ${diffMinutes} dakika önce geçmiş.`;
        } else {
            summary += ` Randevu zamanı yaklaşık ${diffMinutes} dakika önce geçmiş.`;
        }
    }

    return summary;
}

function showActionMsg(type, text) {
    const msg = document.getElementById("actionMsg");

    msg.className = type === "success"
        ? "rounded-2xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "rounded-2xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    msg.innerText = text;
    msg.classList.remove("hidden");
}

function setActionButtonsDisabled(disabled) {
    document.querySelectorAll("button[onclick^='updateStatus']").forEach((btn) => {
        btn.disabled = disabled;
    });
}

async function load() {
    if (!id) {
        alert("Geçersiz randevu ID");
        location.href = "randevular.php";
        return;
    }

    try {
        const res = await fetch('../api/admin/appt-detail.php?id=' + encodeURIComponent(id) + '&_=' + Date.now(), {
            cache: 'no-store'
        });

        const json = await res.json();

        if (!json.success) {
            alert(json.message || "Randevu bulunamadı");
            location.href = "randevular.php";
            return;
        }

        const a = json.data || {};

        const formattedDate = formatDate(a.appointment_date);
        const formattedTime = formatTime(a.appointment_time);
        const formattedCreatedAt = formatDateTime(a.created_at);
        const formattedUpdatedAt = a.updated_at ? formatDateTime(a.updated_at) : 'Henüz güncellenmedi';
        const serviceTitle = a.service_title || 'Hizmet seçilmemiş';

        setText('page_title', a.full_name || 'Randevu Detayı');
        setText('page_subtitle', serviceTitle);

        setText('full_name_head', a.full_name);
        setText('service_head', serviceTitle);

        setText('full_name', a.full_name);
        setText('phone', a.phone);
        setText('email', a.email);
        setText('ip_address', a.ip_address);

        setText('kvkk_consent', Number(a.kvkk_consent) === 1 ? 'Evet ✅' : 'Hayır');
        setText('kvkk_consent_at', a.kvkk_consent_at ? formatDateTime(a.kvkk_consent_at) : '-');

        setText('service_title', serviceTitle);
        setText('appointment_date', formattedDate);
        setText('appointment_time', formattedTime);
        setText('created_at', formattedCreatedAt);
        setText('updated_at', formattedUpdatedAt);

        setText('summary_requested_date', formattedDate);
        setText('summary_requested_time', formattedTime);
        setText('summary_created_at', formattedCreatedAt);

        setText('message', a.message);
        document.getElementById('admin_note').value = a.admin_note || '';

        setText(
            'time_summary',
            buildTimeSummary(a.appointment_date, a.appointment_time, a.created_at)
        );

        setStatusElements(a.status);

        document.getElementById('loading').style.display = "none";
        document.getElementById('content').classList.remove("hidden");

    } catch (err) {
        alert("Sunucu hatası oluştu");
        location.href = "randevular.php";
    }
}

async function updateStatus(status) {
    const statusTexts = {
        confirmed: "Randevuyu ONAYLAMAK istiyor musun?",
        cancelled: "Randevuyu İPTAL etmek istiyor musun?",
        pending: "Randevuyu BEKLEMEYE almak istiyor musun?"
    };

    const confirmText = statusTexts[status] || "Durumu güncellemek istiyor musun?";

    if (!confirm(confirmText)) return;

    setActionButtonsDisabled(true);
    showActionMsg("success", "İşlem yapılıyor...");

    try {
        const res = await fetch('../api/admin/appt-status.php', {
            method: 'POST',
            body: new URLSearchParams({
                id: id,
                status: status,
                admin_note: document.getElementById('admin_note').value,
                csrf_token: window.CSRF_TOKEN || ""
            })
        });

        const result = await res.json().catch(() => ({}));

        if (result.success === false) {
            showActionMsg("error", result.message || "İşlem başarısız");
            return;
        }

        showActionMsg("success", "Durum başarıyla güncellendi ✔");

        await load();

    } catch (err) {
        showActionMsg("error", "Sunucu hatası oluştu ❌");
    } finally {
        setActionButtonsDisabled(false);
    }
}

load();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>