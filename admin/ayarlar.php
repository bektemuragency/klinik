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
                    Klinik Ayarları
                </div>

                <h1 class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Ayarlar
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Klinik bilgilerini, iletişim alanlarını, sosyal medya linklerini, harita ve görünüm ayarlarını buradan yönet.
                </p>
            </div>

            <div class="bg-white/10 border border-white/15 rounded-2xl p-5 min-w-[240px] backdrop-blur">
                <p class="text-xs text-blue-100 uppercase font-semibold tracking-wide">
                    Ayar Durumu
                </p>

                <div class="flex items-center gap-2 mt-3">
                    <span id="settingsStatusDot" class="w-3 h-3 rounded-full bg-yellow-300"></span>
                    <span id="settingsStatusText" class="text-sm font-bold">
                        Yükleniyor
                    </span>
                </div>

                <p id="settingsStatusMsg" class="text-xs text-blue-100 mt-2">
                    Klinik ayarları kontrol ediliyor.
                </p>
            </div>

        </div>

    </div>

    <div id="loading" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-slate-500">
        Ayarlar yükleniyor...
    </div>

    <form id="form" class="hidden space-y-6">

        <!-- GENEL BİLGİLER -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl">
                        🏥
                    </div>

                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            Genel Bilgiler
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Klinik adı, slogan ve hakkımızda metni.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Klinik Adı
                    </label>
                    <input name="clinic_name"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Klinik Adı">
                </div>

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Slogan
                    </label>
                    <input name="slogan"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Slogan">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Hakkımızda Metni
                    </label>
                    <textarea name="about_text"
                              rows="5"
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Klinik hakkında kısa açıklama..."></textarea>
                </div>

            </div>

        </div>

        <!-- İLETİŞİM -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl">
                        ☎️
                    </div>

                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            İletişim Bilgileri
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Telefon, e-posta, WhatsApp, adres ve çalışma saatleri.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Telefon Ana
                    </label>
                    <input name="phone_primary"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="+90 212 000 00 00">
                </div>

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Telefon İkinci
                    </label>
                    <input name="phone_secondary"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="+90 212 000 00 01">
                </div>

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Email
                    </label>
                    <input name="email"
                           type="email"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="info@klinik.com">
                </div>

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        WhatsApp Numarası
                    </label>
                    <input name="whatsapp_number"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="905321234567">
                    <p class="text-xs text-slate-400 mt-2">
                        Örnek: 905321234567
                    </p>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Adres
                    </label>
                    <textarea name="address"
                              rows="3"
                              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Açık adres..."></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Çalışma Saatleri
                    </label>
                    <input name="working_hours"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Pzt-Cmt: 09:00 - 18:00">
                </div>

            </div>

        </div>

        <!-- SOSYAL MEDYA -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

            <div class="p-6 border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-xl">
                        🔗
                    </div>

                    <div>
                        <h2 class="text-xl font-black text-slate-900">
                            Sosyal Medya
                        </h2>
                        <p class="text-sm text-slate-500 mt-1">
                            Facebook ve Instagram bağlantıları.
                        </p>
                    </div>
                </div>
            </div>

            <div class="p-6 grid md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Facebook URL
                    </label>
                    <input name="facebook_url"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://facebook.com/...">
                </div>

                <div>
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Instagram URL
                    </label>
                    <input name="instagram_url"
                           class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="https://instagram.com/...">
                </div>

            </div>

        </div>

        <!-- HARİTA & GÖRÜNÜM -->
        <div class="grid lg:grid-cols-3 gap-6">

            <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-xl">
                            🗺️
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Harita
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Google Maps embed adresi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Google Maps Embed URL
                    </label>

                    <textarea name="google_maps_embed"
                            rows="4"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="https://www.google.com/maps/embed?pb=..."></textarea>

                    <p class="text-xs text-slate-400 mt-2">
                        Sadece Google Maps embed URL adresini girin. iframe kodu yapıştırmayın.
                    </p>
                </div>

            </div>

            <div class="space-y-6">

                <!-- COLOR -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                    <div class="p-6 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl">
                                🎨
                            </div>

                            <div>
                                <h2 class="text-xl font-black text-slate-900">
                                    Görünüm
                                </h2>
                                <p class="text-sm text-slate-500 mt-1">
                                    Site ana rengi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">

                        <div id="colorPreview"
                             class="h-24 rounded-2xl border border-slate-100 bg-blue-600 shadow-inner"></div>

                        <div>
                            <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                                Ana Renk
                            </label>

                            <div class="flex items-center gap-3">
                                <input type="color"
                                       id="colorPicker"
                                       class="h-12 w-16 border border-slate-200 rounded-xl cursor-pointer">

                                <input type="text"
                                       name="primary_color"
                                       id="colorText"
                                       class="border border-slate-200 rounded-xl px-4 py-3 w-full font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="#3b82f6"
                                       maxlength="7">
                            </div>
                        </div>

                    </div>

                </div>

                <!-- LOGO -->
                <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                    <div class="p-6 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 rounded-2xl bg-slate-900 text-white flex items-center justify-center text-xl">
                                🖼️
                            </div>

                            <div>
                                <h2 class="text-xl font-black text-slate-900">
                                    Logo
                                </h2>
                                <p class="text-sm text-slate-500 mt-1">
                                    Klinik logosu.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">

                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-center justify-center min-h-[120px]">
                            <img id="logoPreview"
                                 src=""
                                 class="max-h-24 hidden rounded-xl bg-white border border-slate-100 p-2">
                            <div id="logoEmpty" class="text-slate-400 text-sm">
                                Logo yok
                            </div>
                        </div>

                        <input type="file"
                               id="logoFile"
                               accept="image/*"
                               class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm">

                        <p class="text-xs text-slate-400">
                            PNG, JPG veya WEBP önerilir. Maksimum 3MB.
                        </p>

                        <div id="logoMsg" class="hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>

                    </div>

                </div>

            </div>

        </div>

        <!-- KAYDET -->
        <div class="sticky bottom-4 z-30 bg-white/90 backdrop-blur border border-slate-100 shadow-xl rounded-3xl p-4 flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
                <p class="font-black text-slate-900">
                    Ayarları Kaydet
                </p>
                <p class="text-sm text-slate-500">
                    Değişiklikler site genelinde kullanılacaktır.
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span id="msg" class="hidden rounded-2xl px-4 py-3 text-sm font-semibold"></span>

                <button type="submit"
                        id="saveBtn"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60 disabled:cursor-not-allowed">
                    Kaydet
                </button>
            </div>

        </div>

    </form>

</div>

<script>
const getCsrfToken = () => window.CSRF_TOKEN || '';

const picker = document.getElementById("colorPicker");
const colorTxt = document.getElementById("colorText");
const colorPreview = document.getElementById("colorPreview");

function setSettingsStatus(type, text, message = '') {
    const dot = document.getElementById("settingsStatusDot");
    const label = document.getElementById("settingsStatusText");
    const msg = document.getElementById("settingsStatusMsg");

    if (type === "success") {
        dot.className = "w-3 h-3 rounded-full bg-green-400";
        label.innerText = text || "Aktif";
        msg.innerText = message || "Ayarlar başarıyla yüklendi.";
        return;
    }

    if (type === "error") {
        dot.className = "w-3 h-3 rounded-full bg-red-400";
        label.innerText = text || "Kontrol Gerekli";
        msg.innerText = message || "Ayarlar yüklenirken sorun oluştu.";
        return;
    }

    dot.className = "w-3 h-3 rounded-full bg-yellow-300";
    label.innerText = text || "Yükleniyor";
    msg.innerText = message || "Klinik ayarları kontrol ediliyor.";
}

function showInlineMsg(el, type, text) {
    el.className = type === "success"
        ? "rounded-2xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "rounded-2xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    el.innerText = text;
    el.classList.remove("hidden");
}

function updateColorPreview(value) {
    const color = /^#[0-9a-fA-F]{6}$/.test(value) ? value : "#2563eb";
    colorPreview.style.background = color;
}

/* renk picker senkron */
picker.addEventListener("input", () => {
    colorTxt.value = picker.value;
    updateColorPreview(picker.value);
});

colorTxt.addEventListener("input", () => {
    if (/^#[0-9a-fA-F]{6}$/.test(colorTxt.value)) {
        picker.value = colorTxt.value;
        updateColorPreview(colorTxt.value);
    }
});

/* logo upload */
document.getElementById("logoFile").addEventListener("change", async (e) => {
    const file = e.target.files[0];

    if (!file) return;

    const logoMsg = document.getElementById("logoMsg");

    showInlineMsg(logoMsg, "success", "Logo yükleniyor...");

    const fd = new FormData();
    fd.append("logo", file);
    fd.append("csrf_token", getCsrfToken());

    try {
        const res = await fetch("../api/admin/logo-upload.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            showInlineMsg(logoMsg, "success", "Logo güncellendi");

            const prev = document.getElementById("logoPreview");
            const empty = document.getElementById("logoEmpty");

            prev.src = "../" + data.data + "?t=" + Date.now();
            prev.classList.remove("hidden");
            empty.classList.add("hidden");
        } else {
            showInlineMsg(logoMsg, "error", data.message ?? "Yükleme başarısız");
        }
    } catch {
        showInlineMsg(logoMsg, "error", "Bağlantı hatası");
    }
});

/* ayarları yükle */
async function loadSettings() {
    setSettingsStatus("loading", "Yükleniyor", "Ayarlar getiriliyor...");

    try {
        const res = await fetch("../api/admin/settings-get.php?_=" + Date.now(), {
            cache: "no-store"
        });

        const data = await res.json();

        if (!data.success || !data.data) {
            setSettingsStatus("error", "Yüklenemedi", "Ayarlar API tarafından döndürülmedi.");
            return;
        }

        const s = data.data;

        const set = (name, val) => {
            const el = document.querySelector(`[name="${name}"]`);

            if (el && val != null) {
                el.value = val;
            }
        };

        set("clinic_name", s.clinic_name);
        set("slogan", s.slogan);
        set("about_text", s.about_text);
        set("phone_primary", s.phone_primary);
        set("phone_secondary", s.phone_secondary);
        set("email", s.email);
        set("whatsapp_number", s.whatsapp_number);
        set("address", s.address);
        set("working_hours", s.working_hours);
        set("facebook_url", s.facebook_url);
        set("instagram_url", s.instagram_url);
        set("google_maps_embed", s.google_maps_embed);

        if (s.primary_color && /^#[0-9a-fA-F]{6}$/.test(s.primary_color)) {
            picker.value = s.primary_color;
            colorTxt.value = s.primary_color;
            updateColorPreview(s.primary_color);
        } else {
            picker.value = "#2563eb";
            colorTxt.value = "#2563eb";
            updateColorPreview("#2563eb");
        }

        if (s.logo_path) {
            const prev = document.getElementById("logoPreview");
            const empty = document.getElementById("logoEmpty");

            prev.src = "../" + s.logo_path + "?t=" + Date.now();
            prev.classList.remove("hidden");
            empty.classList.add("hidden");
        }

        setSettingsStatus("success", "Aktif", "Ayarlar başarıyla yüklendi.");

    } catch (e) {
        console.error("Ayarlar yüklenemedi", e);
        setSettingsStatus("error", "Hata", "Bağlantı hatası oluştu.");
    } finally {
        document.getElementById("loading").style.display = "none";
        document.getElementById("form").classList.remove("hidden");
    }
}

/* kaydet */
document.getElementById("form").addEventListener("submit", async (e) => {
    e.preventDefault();

    const msg = document.getElementById("msg");
    const saveBtn = document.getElementById("saveBtn");

    msg.className = "rounded-2xl px-4 py-3 text-sm font-semibold bg-slate-50 border border-slate-100 text-slate-600";
    msg.innerText = "Kaydediliyor...";
    msg.classList.remove("hidden");

    saveBtn.disabled = true;
    saveBtn.innerText = "Kaydediliyor...";

    const fd = new FormData(e.target);
    fd.append("csrf_token", getCsrfToken());

    try {
        const res = await fetch("../api/admin/settings-update.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            showInlineMsg(msg, "success", "Kaydedildi");
            setSettingsStatus("success", "Güncel", "Ayarlar başarıyla kaydedildi.");
        } else {
            showInlineMsg(msg, "error", data.message ?? "Hata oluştu");
            setSettingsStatus("error", "Kontrol Gerekli", data.message ?? "Ayarlar kaydedilemedi.");
        }
    } catch {
        showInlineMsg(msg, "error", "Bağlantı hatası");
        setSettingsStatus("error", "Hata", "Bağlantı hatası oluştu.");
    }

    saveBtn.disabled = false;
    saveBtn.innerText = "Kaydet";
});

updateColorPreview("#2563eb");
loadSettings();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>