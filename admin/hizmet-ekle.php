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
                    Yeni Hizmet Ekle
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Klinik sitesinde görünecek hizmet başlığı, açıklaması, detay metni ve görselini buradan ekle.
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

    <form id="serviceForm" enctype="multipart/form-data" class="grid xl:grid-cols-3 gap-6">

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
                               id="titleInput"
                               required
                               placeholder="Örn: Diş Beyazlatma"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Kısa Açıklama
                        </label>

                        <textarea name="short_desc"
                                  id="shortDescInput"
                                  rows="4"
                                  maxlength="500"
                                  placeholder="Listeleme kartlarında görünecek kısa açıklama..."
                                  class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>

                        <div class="flex justify-between mt-2">
                            <p class="text-xs text-slate-400">
                                Kısa, net ve kullanıcıya faydayı anlatan metin yaz.
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
                              id="contentInput"
                              rows="14"
                              placeholder="Hizmet hakkında detaylı bilgi yaz..."
                              class="w-full border border-slate-200 rounded-2xl px-4 py-4 text-sm leading-7 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>

                    <div class="mt-4 bg-blue-50 border border-blue-100 rounded-2xl p-4">
                        <p class="text-sm font-bold text-blue-900">
                            Yazım önerisi
                        </p>
                        <p class="text-sm text-blue-800 mt-1 leading-relaxed">
                            İçeriği başlıklar halinde yazarsan detay sayfası daha okunabilir olur. Örneğin:
                            Genel Bilgi, Uygulama Süreci, Avantajları, Tedavi Sonrası.
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
                                Hizmet kartı görseli.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl overflow-hidden min-h-[220px] flex items-center justify-center">
                        <img id="imagePreview"
                             src=""
                             class="hidden w-full h-[220px] object-cover">

                        <div id="imageEmpty" class="text-center p-6">
                            <div class="text-5xl mb-3">🧾</div>
                            <p class="text-sm font-bold text-slate-700">
                                Görsel seçilmedi
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
                        Önerilen boyut: 1200x800. Dosya boyutu düşük olursa site daha hızlı açılır.
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
                            id="statusSelect"
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
                        Kaydet
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Hizmeti oluştur ve listeye dön.
                    </p>
                </div>

                <div class="p-6 space-y-4">

                    <button type="submit"
                            id="saveBtn"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60 disabled:cursor-not-allowed">
                        Hizmeti Kaydet
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
const form = document.getElementById('serviceForm');
const saveBtn = document.getElementById('saveBtn');
const messageBox = document.getElementById('message');

const shortDescInput = document.getElementById('shortDescInput');
const shortCount = document.getElementById('shortCount');

const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const imageEmpty = document.getElementById('imageEmpty');

const statusSelect = document.getElementById('statusSelect');
const statusInfo = document.getElementById('statusInfo');

function showMessage(type, text) {
    messageBox.className = type === "success"
        ? "rounded-2xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "rounded-2xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    messageBox.innerText = text;
    messageBox.classList.remove("hidden");
}

shortDescInput.addEventListener('input', () => {
    shortCount.innerText = `${shortDescInput.value.length} / 500`;
});

imageInput.addEventListener('change', () => {
    const file = imageInput.files[0];

    if (!file) {
        imagePreview.classList.add('hidden');
        imageEmpty.classList.remove('hidden');
        imagePreview.src = '';
        return;
    }

    const url = URL.createObjectURL(file);

    imagePreview.src = url;
    imagePreview.classList.remove('hidden');
    imageEmpty.classList.add('hidden');
});

statusSelect.addEventListener('change', () => {
    if (statusSelect.value === "1") {
        statusInfo.className = "mt-4 bg-green-50 border border-green-100 text-green-800 rounded-2xl p-4 text-sm font-semibold";
        statusInfo.innerText = "Bu hizmet sitede görünür.";
    } else {
        statusInfo.className = "mt-4 bg-red-50 border border-red-100 text-red-800 rounded-2xl p-4 text-sm font-semibold";
        statusInfo.innerText = "Bu hizmet pasif olur ve sitede görünmez.";
    }
});

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    messageBox.classList.add("hidden");

    saveBtn.disabled = true;
    saveBtn.innerText = "Kaydediliyor...";

    const fd = new FormData(form);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    try {
        const res = await fetch('../api/admin/service-create.php', {
            method: 'POST',
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            showMessage("success", data.message || "Hizmet başarıyla oluşturuldu");

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
    saveBtn.innerText = "Hizmeti Kaydet";
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>