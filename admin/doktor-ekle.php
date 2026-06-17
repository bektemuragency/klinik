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
                    Yeni Doktor Ekle
                </h1>

                <p class="text-blue-100 mt-2 max-w-2xl">
                    Klinik kadrosunda görünecek doktor bilgilerini, branşını, biyografisini ve fotoğrafını ekle.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="doktorlar.php"
                   class="bg-white text-slate-900 hover:bg-blue-50 px-4 py-2 rounded-xl text-sm font-bold transition">
                    ← Listeye Dön
                </a>
            </div>

        </div>

    </div>

    <form id="doctorForm" enctype="multipart/form-data" class="grid xl:grid-cols-3 gap-6">

        <!-- LEFT -->
        <div class="xl:col-span-2 space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl">
                            👨‍⚕️
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Doktor Bilgileri
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Ad soyad, unvan ve branş bilgileri.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 grid md:grid-cols-2 gap-5">

                    <div class="md:col-span-2">
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Ad Soyad
                        </label>

                        <input type="text"
                               name="name"
                               required
                               placeholder="Örn: Dr. Ayşe Demir"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Unvan
                        </label>

                        <input type="text"
                               name="title"
                               placeholder="Uzm. Dr., Op. Dr., Diş Hekimi..."
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Branş
                        </label>

                        <input type="text"
                               name="specialty"
                               placeholder="Ortodonti, Diş Hekimi..."
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl">
                            ✍️
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Biyografi
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Doktor hakkında kısa ve okunabilir açıklama.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6">

                    <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                        Biyografi
                    </label>

                    <textarea name="bio"
                              id="bioInput"
                              rows="10"
                              maxlength="1200"
                              placeholder="Doktorun uzmanlık alanı, deneyimi ve kısa açıklaması..."
                              class="w-full border border-slate-200 rounded-2xl px-4 py-4 text-sm leading-7 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>

                    <div class="flex justify-between mt-2">
                        <p class="text-xs text-slate-400">
                            Public doktor sayfasında okunabilir olması için kısa paragraflar kullan.
                        </p>

                        <p id="bioCount" class="text-xs text-slate-400">
                            0 / 1200
                        </p>
                    </div>

                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-xl">
                            ☎️
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                İletişim
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Doktora ait telefon ve email bilgisi.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 grid md:grid-cols-2 gap-5">

                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Telefon
                        </label>

                        <input type="text"
                               name="phone"
                               placeholder="05XX XXX XX XX"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs text-slate-500 uppercase font-bold mb-2">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               placeholder="doktor@mail.com"
                               class="w-full border border-slate-200 rounded-2xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="space-y-6">

            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-11 h-11 rounded-2xl bg-purple-600 text-white flex items-center justify-center text-xl">
                            🖼️
                        </div>

                        <div>
                            <h2 class="text-xl font-black text-slate-900">
                                Fotoğraf
                            </h2>
                            <p class="text-sm text-slate-500 mt-1">
                                Doktor profil fotoğrafı.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-6 space-y-4">

                    <div class="bg-slate-50 border border-slate-100 rounded-2xl overflow-hidden min-h-[260px] flex items-center justify-center">
                        <img id="imagePreview"
                             src=""
                             class="hidden w-full h-[260px] object-cover">

                        <div id="imageEmpty" class="text-center p-6">
                            <div class="text-5xl mb-3">👨‍⚕️</div>
                            <p class="text-sm font-bold text-slate-700">
                                Fotoğraf seçilmedi
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
                        Profil görseli kare veya dikey olursa daha düzgün görünür.
                    </p>

                </div>

            </div>

            <div class="sticky top-6 bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">

                <div class="p-6 border-b border-slate-100">
                    <h2 class="text-xl font-black text-slate-900">
                        Kaydet
                    </h2>
                    <p class="text-sm text-slate-500 mt-1">
                        Doktor kaydını oluştur.
                    </p>
                </div>

                <div class="p-6 space-y-4">

                    <button type="submit"
                            id="saveBtn"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-bold transition disabled:opacity-60 disabled:cursor-not-allowed">
                        Doktoru Kaydet
                    </button>

                    <a href="doktorlar.php"
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
const form = document.getElementById('doctorForm');
const saveBtn = document.getElementById('saveBtn');
const messageBox = document.getElementById('message');

const bioInput = document.getElementById('bioInput');
const bioCount = document.getElementById('bioCount');

const imageInput = document.getElementById('imageInput');
const imagePreview = document.getElementById('imagePreview');
const imageEmpty = document.getElementById('imageEmpty');

function showMessage(type, text) {
    messageBox.className = type === "success"
        ? "rounded-2xl px-4 py-3 text-sm font-semibold bg-green-50 border border-green-100 text-green-700"
        : "rounded-2xl px-4 py-3 text-sm font-semibold bg-red-50 border border-red-100 text-red-700";

    messageBox.innerText = text;
    messageBox.classList.remove("hidden");
}

bioInput.addEventListener('input', () => {
    bioCount.innerText = `${bioInput.value.length} / 1200`;
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

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    messageBox.classList.add("hidden");

    saveBtn.disabled = true;
    saveBtn.innerText = "Kaydediliyor...";

    const fd = new FormData(form);
    fd.append("csrf_token", window.CSRF_TOKEN || "");

    try {
        const res = await fetch('../api/admin/doctor-create.php', {
            method: 'POST',
            body: fd
        });

        const data = await res.json();

        if (data.success) {
            showMessage("success", data.message || "Doktor başarıyla oluşturuldu");

            setTimeout(() => {
                location.href = "doktorlar.php";
            }, 800);
        } else {
            showMessage("error", data.message || "İşlem başarısız");
        }

    } catch (err) {
        showMessage("error", "Sunucu hatası oluştu");
    }

    saveBtn.disabled = false;
    saveBtn.innerText = "Doktoru Kaydet";
});
</script>

<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>