<?php
require_once __DIR__ . '/auth_check.php';
ob_start();
?>
 
<h1 class="text-2xl font-bold mb-6">Ayarlar</h1>
 
<div id="loading" class="text-gray-500 mb-4">Yükleniyor...</div>
 
<form id="form" class="hidden space-y-6">
 
    <!-- GENEL BİLGİLER -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Genel Bilgiler</h2>
 
        <div class="grid md:grid-cols-2 gap-4">
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Klinik Adı</label>
                <input name="clinic_name" class="w-full border rounded p-2" placeholder="Klinik Adı">
            </div>
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slogan</label>
                <input name="slogan" class="w-full border rounded p-2" placeholder="Slogan">
            </div>
 
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Hakkımızda Metni</label>
                <textarea name="about_text" rows="4" class="w-full border rounded p-2" placeholder="Klinik hakkında kısa açıklama..."></textarea>
            </div>
 
        </div>
    </div>
 
    <!-- İLETİŞİM -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">İletişim Bilgileri</h2>
 
        <div class="grid md:grid-cols-2 gap-4">
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefon (Ana)</label>
                <input name="phone_primary" class="w-full border rounded p-2" placeholder="+90 212 000 00 00">
            </div>
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Telefon (İkinci)</label>
                <input name="phone_secondary" class="w-full border rounded p-2" placeholder="+90 212 000 00 01">
            </div>
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input name="email" type="email" class="w-full border rounded p-2" placeholder="info@klinik.com">
            </div>
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp Numarası</label>
                <input name="whatsapp_number" class="w-full border rounded p-2" placeholder="905321234567">
                <p class="text-xs text-gray-400 mt-1">Başında + veya 0 olmadan: 905321234567</p>
            </div>
 
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Adres</label>
                <textarea name="address" rows="2" class="w-full border rounded p-2" placeholder="Açık adres..."></textarea>
            </div>
 
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Çalışma Saatleri</label>
                <input name="working_hours" class="w-full border rounded p-2" placeholder="Pzt-Cmt: 09:00 - 18:00">
            </div>
 
        </div>
    </div>
 
    <!-- SOSYAL MEDYA -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Sosyal Medya</h2>
 
        <div class="grid md:grid-cols-2 gap-4">
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Facebook URL</label>
                <input name="facebook_url" class="w-full border rounded p-2" placeholder="https://facebook.com/...">
            </div>
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Instagram URL</label>
                <input name="instagram_url" class="w-full border rounded p-2" placeholder="https://instagram.com/...">
            </div>
 
        </div>
    </div>
 
    <!-- HARİTA & GÖRÜNÜM -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Harita & Görünüm</h2>
 
        <div class="space-y-4">
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Google Maps Embed Kodu</label>
                <textarea name="google_maps_embed" rows="3" class="w-full border rounded p-2 font-mono text-xs" placeholder='<iframe src="https://maps.google.com/..." ...></iframe>'></textarea>
            </div>
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ana Renk</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="colorPicker" class="h-10 w-16 border rounded cursor-pointer">
                    <input type="text" name="primary_color" id="colorText" class="border rounded p-2 w-32 font-mono" placeholder="#3b82f6" maxlength="7">
                    <span class="text-xs text-gray-400">Site genelinde kullanılacak ana renk</span>
                </div>
            </div>
 
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                <div class="flex items-center gap-4">
                    <img id="logoPreview" src="" class="h-16 hidden border rounded p-1 bg-gray-50">
                    <div>
                        <input type="file" id="logoFile" accept="image/*" class="border rounded p-2">
                        <p class="text-xs text-gray-400 mt-1">PNG veya JPG, max 3MB</p>
                    </div>
                </div>
                <div id="logoMsg" class="text-sm mt-2"></div>
            </div>
 
        </div>
    </div>
 
    <!-- KAYDET -->
    <div class="flex items-center gap-4 pb-6">
        <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-medium">
            Kaydet
        </button>
        <span id="msg" class="text-sm"></span>
    </div>
 
</form>
 
<script>
const getCsrfToken = () => window.CSRF_TOKEN || '';

/* renk picker senkron */
const picker   = document.getElementById("colorPicker");
const colorTxt = document.getElementById("colorText");
 
picker.addEventListener("input", () => { colorTxt.value = picker.value; });
colorTxt.addEventListener("input", () => {
    if (/^#[0-9a-fA-F]{6}$/.test(colorTxt.value)) picker.value = colorTxt.value;
});
 
/* logo upload */
document.getElementById("logoFile").addEventListener("change", async (e) => {
    const file = e.target.files[0];
    if (!file) return;
 
    const logoMsg = document.getElementById("logoMsg");
    logoMsg.innerText = "Yükleniyor...";
    logoMsg.className = "text-sm text-gray-500";
 
    const fd = new FormData();
    fd.append("logo", file);
    fd.append("csrf_token", getCsrfToken());
 
    try {
        const res  = await fetch("../api/admin/logo-upload.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json();
 
        if (data.success) {
            logoMsg.innerText = "Logo güncellendi";
            logoMsg.className = "text-sm text-green-600";
            const prev = document.getElementById("logoPreview");
            prev.src = "../" + data.data + "?t=" + Date.now();
            prev.classList.remove("hidden");
        } else {
            logoMsg.innerText = data.message ?? "Yükleme başarısız";
            logoMsg.className = "text-sm text-red-600";
        }
    } catch {
        logoMsg.innerText = "Bağlantı hatası";
        logoMsg.className = "text-sm text-red-600";
    }
});
 
/* ayarları yükle */
async function loadSettings() {
    try {
        const res  = await fetch("../api/admin/settings-get.php");
        const data = await res.json();
 
        if (!data.success || !data.data) return;
 
        const s = data.data;
        const set = (name, val) => {
            const el = document.querySelector(`[name="${name}"]`);
            if (el && val != null) el.value = val;
        };
 
        set("clinic_name",       s.clinic_name);
        set("slogan",            s.slogan);
        set("about_text",        s.about_text);
        set("phone_primary",     s.phone_primary);
        set("phone_secondary",   s.phone_secondary);
        set("email",             s.email);
        set("whatsapp_number",   s.whatsapp_number);
        set("address",           s.address);
        set("working_hours",     s.working_hours);
        set("facebook_url",      s.facebook_url);
        set("instagram_url",     s.instagram_url);
        set("google_maps_embed", s.google_maps_embed);
 
        if (s.primary_color) {
            picker.value   = s.primary_color;
            colorTxt.value = s.primary_color;
        }
 
        if (s.logo_path) {
            const prev = document.getElementById("logoPreview");
            prev.src = "../" + s.logo_path + "?t=" + Date.now();
            prev.classList.remove("hidden");
        }
 
    } catch (e) {
        console.error("Ayarlar yüklenemedi", e);
    } finally {
        document.getElementById("loading").style.display = "none";
        document.getElementById("form").classList.remove("hidden");
    }
}
 
/* kaydet */
document.getElementById("form").addEventListener("submit", async (e) => {
    e.preventDefault();
 
    const msg = document.getElementById("msg");
    msg.innerText = "Kaydediliyor...";
    msg.className = "text-sm text-gray-500";
 
    const fd = new FormData(e.target);
    fd.append("csrf_token", getCsrfToken());

    try {
        const res  = await fetch("../api/admin/settings-update.php", {
            method: "POST",
            body: fd
        });

        const data = await res.json();
 
        if (data.success) {
            msg.innerText = "Kaydedildi";
            msg.className = "text-sm text-green-600";
        } else {
            msg.innerText = data.message ?? "Hata oluştu";
            msg.className = "text-sm text-red-600";
        }
    } catch {
        msg.innerText = "Bağlantı hatası";
        msg.className = "text-sm text-red-600";
    }
});
 
loadSettings();
</script>
 
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
?>