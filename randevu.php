<?php
$config = require __DIR__ . '/config.php';

$pageTitle = "Randevu Al";

/*
========================
MOCK FALLBACK
========================
*/
$json = @file_get_contents(__DIR__ . '/mockdata.json');
$data = $json ? json_decode($json, true) : [];

$settings = $data['settings'] ?? [
    'clinic_name' => 'Klinik'
];

$services = $data['services'] ?? [];

/*
========================
SETTINGS API
========================
*/
$settingsApiUrl = 'http://localhost/klinikcms/api/settings.php';
$settingsResponse = @file_get_contents($settingsApiUrl);
$settingsApiData = json_decode($settingsResponse, true);

if (
    isset($settingsApiData['success']) &&
    $settingsApiData['success'] === true &&
    !empty($settingsApiData['data'])
) {
    $settings = $settingsApiData['data'];
}

/*
========================
SERVICES API
========================
*/
$servicesApiUrl = 'http://localhost/klinikcms/api/services.php';
$servicesResponse = @file_get_contents($servicesApiUrl);
$servicesApiData = json_decode($servicesResponse, true);

if (
    isset($servicesApiData['success']) &&
    $servicesApiData['success'] === true &&
    !empty($servicesApiData['data'])
) {
    $services = $servicesApiData['data'];
}

$today = date('Y-m-d');
?>

<?php include __DIR__ . '/header.php'; ?>

<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            Online Randevu
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            <?= htmlspecialchars($settings['clinic_name'] ?? 'Klinik', ENT_QUOTES, 'UTF-8') ?> üzerinden kolayca randevu oluşturabilirsiniz.
        </p>

    </div>
</section>

<section class="py-16">
    <div class="max-w-4xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 border border-slate-100">

            <h2 class="text-2xl md:text-3xl font-bold mb-8 text-center text-slate-800">
                Randevu Talep Formu
            </h2>

            <form id="appointmentForm" class="grid md:grid-cols-2 gap-6">

                <!-- HONEYPOT / SPAM KORUMA -->
                <input type="text"
                       name="website"
                       class="hidden"
                       tabindex="-1"
                       autocomplete="off">

                <!-- AD SOYAD -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Ad Soyad</label>
                    <input type="text" name="full_name" required
                           placeholder="Örn: Ahmet Yılmaz"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- TELEFON -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Telefon</label>
                    <input type="text" name="phone" required
                           placeholder="0 (5XX) XXX XX XX"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">E-Posta</label>
                    <input type="email" name="email"
                           placeholder="ornek@mail.com"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- HİZMET -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Hizmet Seçin</label>
                    <select name="service_id" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                        <option value="" disabled selected>Hizmet seçiniz</option>

                        <?php foreach ($services as $service): ?>
                            <option value="<?= (int)($service['id'] ?? 0) ?>">
                                <?= htmlspecialchars($service['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TARİH -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Tarih</label>
                    <input type="date" name="date" required
                           min="<?= htmlspecialchars($today, ENT_QUOTES, 'UTF-8') ?>"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- SAAT -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Saat</label>
                    <input type="time" name="time" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- MESAJ -->
                <div class="md:col-span-2">
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Not (Opsiyonel)</label>
                    <textarea name="message" rows="4"
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5"
                              placeholder="Varsa eklemek istediğiniz not..."></textarea>
                </div>

                <!-- BUTON -->
                <div class="md:col-span-2 text-center">
                    <button type="submit"
                            id="submitBtn"
                            class="bg-teal-700 hover:bg-teal-800 text-white px-8 py-3 rounded-xl font-semibold">
                        Randevu Oluştur
                    </button>
                </div>

            </form>

            <div id="msgBox" class="hidden mt-6 text-center font-semibold"></div>

        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>

<script>
const form = document.getElementById("appointmentForm");
const msgBox = document.getElementById("msgBox");
const submitBtn = document.getElementById("submitBtn");

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    msgBox.classList.add("hidden");
    submitBtn.disabled = true;
    submitBtn.innerText = "Gönderiliyor...";

    const formData = new FormData(form);

    try {
        const res = await fetch("http://localhost/klinikcms/api/appointment.php", {
            method: "POST",
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            msgBox.innerText = "✅ Randevunuz oluşturuldu!";
            msgBox.className = "mt-6 text-center font-semibold text-green-600";
            msgBox.classList.remove("hidden");

            form.reset();
        } else {
            msgBox.innerText = "❌ " + (data.message || "Hata oluştu");
            msgBox.className = "mt-6 text-center font-semibold text-red-600";
            msgBox.classList.remove("hidden");
        }

    } catch (err) {
        msgBox.innerText = "❌ Sunucu hatası";
        msgBox.className = "mt-6 text-center font-semibold text-red-600";
        msgBox.classList.remove("hidden");
    }

    submitBtn.disabled = false;
    submitBtn.innerText = "Randevu Oluştur";
});
</script>