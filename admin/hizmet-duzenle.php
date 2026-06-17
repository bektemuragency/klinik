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

                <h1 id="pageTitle" class="text-3xl md:text-4xl font-extrabold tracking-tight">
                    Hizmet Düzenle
                </h1>

                <p id="pageSubtitle" class="text-blue-100 mt-2 max-w-2xl">
                    Klinik hizmetinin başlığını, açıklamasını, detay metnini, görselini ve yayın durumunu düzenle.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="hizmetler.php"
                   class="bg-white text-slate-900 hover:bg-blue-50 px-4 py-2 rounded-xl text-sm font-bold transition">
                    ← Listeye Dön
                </a>
            </div>

        </div>

    </div>

    <!-- LOADING -->
    <div id="loading" class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 text-slate-500">
        Hizmet bilgileri yükleniyor...
    </div>

    <!-- ERROR -->
    <div id="errorBox" class="hidden bg-red-50 border border-red-100 text-red-700 p-6 rounded-3xl font-semibold"></div>

    <form id="editForm" class="hidden grid xl:grid-cols-3 gap-6" enctype="multipart/form-data">

        <input type="hidden" name="id" id="id">

        <!-- LEFT CONTENT -->
        <div class="xl:col-span-2 space-y-6">

            <!-- BASIC INFO -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl">
                            🧾
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Hizmet Bilgileri
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Hizmetin başlığı ve kısa açıklaması.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-5">

                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Hizmet Başlığı
                        </label>

                        <input type="text"
                               name="title"
                               id="title"
                               required
                               placeholder="Örn: Diş Beyazlatma"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Kısa Açıklama
                        </label>

                        <textarea name="short_desc"
                                  id="short_desc"
                                  rows="4"
                                  maxlength="500"
                                  placeholder="Listeleme kartlarında görünecek kısa açıklama..."
                                  class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>

                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-slate-400">
                                Kısa ve anlaşılır bir açıklama yaz.
                            </p>

                            <p id="shortCount" class="text-xs text-slate-400">
                                0 / 500
                            </p>
                        </div>
                    </div>

                </div>

            </div>

            <!-- CONTENT -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl">
                            ✍️
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Detay İçerik
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Hizmet detay sayfasında görünecek ana içerik.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">

                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Detay Metni
                    </label>

                    <textarea name="content"
                              id="content"
                              rows="14"
                              placeholder="Hizmet hakkında detaylı bilgi yaz..."
                              class="w-full border border-slate-200 rounded-2xl px-4 py-4 text-sm leading-7 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>

                    <div class="mt-4 bg-blue-50 border border-blue-100 rounded-2xl p-4">
                        <p class="text-sm font-bold text-blue-900">
                            Okunabilirlik önerisi
                        </p>
                        <p class="text-sm text-blue-800 mt-1 leading-relaxed">
                            Detay metnini kısa paragraflara böl. Başlıklar kullanırsan public detay sayfasında daha iyi okunur.
                        </p>
                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="space-y-6">

            <!-- IMAGE -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-xl">
                            🖼️
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Görsel
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Mevcut görseli gör veya yeni görsel seç.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl overflow-hidden min-h-[220px] flex items-center justify-center">
                        <img id="preview"
                             src=""
                             class="hidden w-full h-[220px] object-cover">

                        <div id="imageEmpty" class="text-center p-6">
                            <div class="text-5xl mb-3">🧾</div>
                            <p class="text-sm font-bold text-slate-700">
                                Görsel yok
                            </p>
                            <p class="text-xs text-slate-400 mt-1">
                                PNG, JPG veya WEBP yükleyebilirsin.
                            </p>
                        </div>
                    </div>

                    <input type="file"
                           name="image"
                           id="imageInput"
                           accept="image/*"
                           class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm">

                    <p class="text-xs text-slate-400">
                        Yeni görsel seçersen mevcut görsel güncellenir. Boş bırakırsan eski görsel korunur.
                    </p>

                </div>

            </div>

            <!-- STATUS -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-green-600 text-white flex items-center justify-center text-xl">
                            ✅
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Yayın Durumu
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Hizmet sitede görünsün mü?
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">

                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Durum
                    </label>

                    <select name="is_active"
                            id="is_active"
                            class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                    </select>

                    <div id="statusInfo"
                         class="mt-4 bg-green-50 border border-green-100 text-green-800 rounded-2xl p-4 text-sm font-semibold">
                        Bu hizmet sitede görünür.
                    </div>

                </div>

            </div>

            <!-- SAVE -->
            <div class="sticky top-6 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-xl font-black text-slate-900">
                        Güncelle
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Değişiklikleri kaydet.
                    </p>
                </div>

                <div class="p-6 space-y-4">

                    <button type="submit"
                            id="saveBtn"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60 disabled:cursor-not-allowed">
                        Hizmeti Güncelle
                    </button>

                    <a href="hizmetler.php"
                       class="block w-full text-center bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-xl text-sm font-bold transition">
                        Vazgeç
                    </a>

                    <div id="message" class="hidden rounded-2xl px-4 py-3 text-sm font-semibold"></div>

                </div>

            </div>

        </div>

    </form>

</div>

<script>
const serviceId = new URLSearchParams(window.location.search).get("id");

const form = document.getElementById("editForm");
const loading = document.getElementById("loading");
const errorBox = document.getElementById("errorBox");
const saveBtn = document.getElementById("saveBtn");
const messageBox = document.getElementById("message");

const titleInput = document.getElementById("title");
const shortDescInput = document.getElementById("short_desc");
const shortCount = document.getElementById("shortCount");
const contentInput = document.getElementById("content");

const statusSelect = document.getElementById("is_active");
const statusInfo = document.getElementById("statusInfo");

const imageInput = document.getElementById("imageInput");
const preview = document.getElementById("preview");
const imageEmpty = document.getElementById("imageEmpty");

function showMessage(type, text) {
    messageBox.className = type === "success"
        ? "rounded-2xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "rounded-2xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    messageBox.innerText = text;
    messageBox.classList.remove("hidden");
}

function showError(text) {
    loading.style.display = "none";
    errorBox.innerText = text;
    errorBox.classList.remove("hidden");
}

function updateShortCount() {
    shortCount.innerText = `${shortDescInput.value.length} / 500`;
}

function updateStatusInfo() {
    if (statusSelect.value === "1") {
        statusInfo.className = "mt-4 bg-green-50 border border-green-100 text-green-800 rounded-2xl p-4 text-sm font-semibold";
        statusInfo.innerText = "Bu hizmet sitede görünür.";
    } else {
        statusInfo.className = "mt-4 bg-red-50 border border-red-100 text-red-800 rounded-2xl p-4 text-sm font-semibold";
        statusInfo.innerText = "Bu hizmet pasif olur ve sitede görünmez.";
    }
}

function setPreview(src) {
    if (!src) {
        preview.classList.add("hidden");
        preview.src = "";
        imageEmpty.classList.remove("hidden");
        return;
    }

    preview.src = src;
    preview.classList.remove("hidden");
    imageEmpty.classList.add("hidden");
}

function getImageUrl(path) {
    const imagePath = String(path ?? "").trim();

    if (!imagePath) return "";

    if (imagePath.startsWith("http://") || imagePath.startsWith("https://")) {
        return imagePath;
    }

    return "../" + imagePath.replace(/^\/+/, "");
}

function normalizeServicesResponse(data) {
    if (data.success && Array.isArray(data.data)) {
        return data.data;
    }

    if (data.success && data.data && Array.isArray(data.data.items)) {
        return data.data.items;
    }

    return [];
}

async function load() {
    if (!serviceId) {
        showError("Geçersiz hizmet ID");
        return;
    }

    try {
        const res = await fetch("../api/admin/service-list.php?_=" + Date.now(), {
            cache: "no-store"
        });

        const data = await res.json();
        const services = normalizeServicesResponse(data);
        const item = services.find(x => String(x.id) === String(serviceId));

        if (!item) {
            showError("Hizmet bulunamadı");
            return;
        }

        document.getElementById("id").value = item.id;

        titleInput.value = item.title || "";
        shortDescInput.value = item.short_desc || "";
        contentInput.value = item.content || "";
        statusSelect.value = String(Number(item.is_active));

        document.getElementById("pageTitle").innerText = item.title || "Hizmet Düzenle";
        document.getElementById("pageSubtitle").innerText = "Bu hizmetin bilgilerini düzenliyorsun.";

        updateShortCount();
        updateStatusInfo();

        if (item.image_path) {
            setPreview(getImageUrl(item.image_path) + "?t=" + Date.now());
        } else {
            setPreview("");
        }

        loading.style.display = "none";
        form.classList.remove("hidden");

    } catch (err) {
        showError("Sunucu hatası oluştu. Hizmet bilgileri yüklenemedi.");
    }
}

imageInput.addEventListener("change", () => {
    const file = imageInput.files[0];

    if (!file) {
        return;
    }

    const url = URL.createObjectURL(file);
    setPreview(url);
});

shortDescInput.addEventListener("input", updateShortCount);
statusSelect.addEventListener("change", updateStatusInfo);

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    messageBox.classList.add("hidden");

    saveBtn.disabled = true;
    saveBtn.innerText = "Güncelleniyor...";

    const fd = new FormData(form);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    try {
        const res = await fetch("../api/admin/service-update.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            showMessage("success", data.message || "Hizmet başarıyla güncellendi");

            setTimeout(() => {
                location.href = "hizmetler.php";
            }, 800);
        } else {
            showMessage("error", data.message || "İşlem başarısız");
        }

    } catch (err) {
        showMessage("error", "Sunucu hatası oluştu");
    }

    saveBtn.disabled = false;
    saveBtn.innerText = "Hizmeti Güncelle";
});

load();
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>