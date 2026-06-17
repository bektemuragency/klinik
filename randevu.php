<?php
require_once __DIR__ . '/includes/config.php';

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
$settingsApiUrl = api_url('settings.php');
$settingsResponse = @file_get_contents($settingsApiUrl);
$settingsApiData = json_decode($settingsResponse, true);

if (
    is_array($settingsApiData) &&
    isset($settingsApiData['success']) &&
    $settingsApiData['success'] === true &&
    !empty($settingsApiData['data']) &&
    is_array($settingsApiData['data'])
) {
    $settings = $settingsApiData['data'];
}

/*
========================
SERVICES API
========================
*/
$servicesApiUrl = api_url('services.php');
$servicesResponse = @file_get_contents($servicesApiUrl);
$servicesApiData = json_decode($servicesResponse, true);

if (
    is_array($servicesApiData) &&
    isset($servicesApiData['success']) &&
    $servicesApiData['success'] === true &&
    !empty($servicesApiData['data']) &&
    is_array($servicesApiData['data'])
) {
    $services = $servicesApiData['data'];
}

/*
========================
AKTİF HİZMETLER
========================
*/
$activeServices = array_filter($services, function ($service) {
    return !isset($service['is_active']) || (int)$service['is_active'] === 1;
});

$today = date('Y-m-d');
$appointmentApiUrl = api_url('appointment.php');
?>

<?php include __DIR__ . '/header.php'; ?>

<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            Online Randevu
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            <?= htmlspecialchars($settings['clinic_name'] ?? 'Klinik', ENT_QUOTES, 'UTF-8') ?>
            üzerinden kolayca randevu oluşturabilirsiniz.
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
                    <label class="block text-slate-700 font-medium mb-2 text-sm">
                        Ad Soyad
                    </label>
                    <input type="text"
                           name="full_name"
                           required
                           placeholder="Örn: Ahmet Yılmaz"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- TELEFON -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">
                        Telefon
                    </label>
                    <input type="text"
                           name="phone"
                           required
                           placeholder="0 (5XX) XXX XX XX"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">
                        E-Posta
                    </label>
                    <input type="email"
                           name="email"
                           placeholder="ornek@mail.com"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- HİZMET -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">
                        Hizmet Seçin
                    </label>

                    <select name="service_id"
                            required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                        <option value="" disabled selected>Hizmet seçiniz</option>

                        <?php foreach ($activeServices as $service): ?>
                            <?php
                            $serviceId = (int)($service['id'] ?? 0);
                            $serviceTitle = $service['title'] ?? '';
                            ?>

                            <?php if ($serviceId > 0): ?>
                                <option value="<?= $serviceId ?>">
                                    <?= htmlspecialchars($serviceTitle, ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endif; ?>

                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- TARİH -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">
                        Tarih
                    </label>
                    <input type="date"
                           name="appointment_date"
                           id="appointment_date"
                           required
                           min="<?= htmlspecialchars($today, ENT_QUOTES, 'UTF-8') ?>"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- SAAT -->
                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">
                        Saat
                    </label>
                    <input type="time"
                           name="appointment_time"
                           id="appointment_time"
                           required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5">
                </div>

                <!-- MESAJ -->
                <div class="md:col-span-2">
                    <label class="block text-slate-700 font-medium mb-2 text-sm">
                        Not (Opsiyonel)
                    </label>
                    <textarea name="message"
                              rows="4"
                              class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5"
                              placeholder="Varsa eklemek istediğiniz not..."></textarea>
                </div>
                <!-- KVKK -->
                <div class="md:col-span-2">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input
                            type="checkbox"
                            name="kvkk_consent"
                            value="1"
                            required
                            class="mt-1 w-4 h-4">

                        <span class="text-sm text-slate-600">
                            Kişisel verilerimin randevu oluşturulması amacıyla işlenmesini kabul ediyorum.
                        </span>
                    </label>
                </div>
                <!-- BUTON -->
                <div class="md:col-span-2 text-center">
                    <button type="submit"
                            id="submitBtn"
                            class="bg-teal-700 hover:bg-teal-800 text-white px-8 py-3 rounded-xl font-semibold disabled:opacity-60 disabled:cursor-not-allowed">
                        Randevu Oluştur
                    </button>
                </div>

            </form>

            <div id="msgBox" class="hidden mt-6 text-center font-semibold"></div>

        </div>
    </div>
</section>

<script>
const form = document.getElementById("appointmentForm");
const msgBox = document.getElementById("msgBox");
const submitBtn = document.getElementById("submitBtn");

const appointmentApiUrl = <?= json_encode($appointmentApiUrl, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?>;

form.addEventListener("submit", async (e) => {
    e.preventDefault();

    msgBox.classList.add("hidden");
    submitBtn.disabled = true;
    submitBtn.innerText = "Gönderiliyor...";

    const formData = new FormData(form);

    /*
    |--------------------------------------------------------------------------
    | API UYUMLULUK
    |--------------------------------------------------------------------------
    | Bazı appointment.php versiyonları date/time bekliyor.
    | Bazıları appointment_date/appointment_time bekliyor.
    | İkisini de gönderiyoruz, sistem bozulmasın.
    |--------------------------------------------------------------------------
    */
    const appointmentDate = document.getElementById("appointment_date")?.value || "";
    const appointmentTime = document.getElementById("appointment_time")?.value || "";

    formData.set("date", appointmentDate);
    formData.set("time", appointmentTime);

    try {
        const res = await fetch(appointmentApiUrl, {
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

<?php include __DIR__ . '/footer.php'; ?>