<?php
require_once __DIR__ . '/includes/config.php';

$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "İletişim";

/*
========================================
MOCKDATA FALLBACK
========================================
*/
$json = @file_get_contents(__DIR__ . '/mockdata.json');
$data = $json ? json_decode($json, true) : [];
$fallbackSettings = $data['settings'] ?? [];

/*
========================================
SETTINGS API
========================================
*/
$apiUrl = api_url('settings.php');
$response = @file_get_contents($apiUrl);
$apiData = json_decode($response, true);

if (
    is_array($apiData) &&
    isset($apiData['success']) &&
    $apiData['success'] === true &&
    !empty($apiData['data']) &&
    is_array($apiData['data'])
) {
    $settings = $apiData['data'];
    $isHoursArray = false;
} else {
    $settings = $fallbackSettings;
    $isHoursArray = is_array($settings['working_hours'] ?? null);
}

$clinicName = $settings['clinic_name'] ?? 'Nova Dent';
$address = $settings['address'] ?? 'Adres Belirtilmemiş';
$phonePrimary = $settings['phone_primary'] ?? '';
$phoneSecondary = $settings['phone_secondary'] ?? '';
$email = $settings['email'] ?? '';
$workingHours = $settings['working_hours'] ?? 'Hafta içi ve Cumartesi: 09:00 - 20:00';
$whatsappNumber = preg_replace('/\D+/', '', $settings['whatsapp_number'] ?? '');
$mapsEmbed = trim($settings['google_maps_embed'] ?? '');

$allowedMap = false;

if (!empty($mapsEmbed)) {
    $allowedMap = filter_var($mapsEmbed, FILTER_VALIDATE_URL)
        && str_starts_with($mapsEmbed, 'https://www.google.com/maps/embed');
}
?>

<?php include __DIR__ . '/header.php'; ?>

<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            Bizimle İletişime Geçin
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            Tedavi süreçleri hakkında bilgi almak, randevu oluşturmak veya merak ettiğiniz tüm konular için uzman ekibimizle iletişime geçebilirsiniz.
        </p>
    </div>

    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-10 items-stretch">

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100 flex flex-col justify-between">

                <div>
                    <p class="text-slate-600 text-sm md:text-base mb-8 leading-relaxed">
                        Sağlıklı ve estetik gülüşler için yanınızdayız. Aşağıdaki iletişim bilgilerinden bize doğrudan ulaşabilirsiniz.
                    </p>

                    <div class="space-y-6">

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">
                                Klinik Adı
                            </h3>
                            <p class="text-slate-800 font-semibold text-lg">
                                <?= htmlspecialchars($clinicName, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">
                                Adres
                            </h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                <?= htmlspecialchars($address, ENT_QUOTES, 'UTF-8') ?>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">
                                Telefon
                            </h3>

                            <?php if (!empty($phonePrimary)): ?>
                                <p class="text-slate-800 font-medium text-sm">
                                    <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', $phonePrimary), ENT_QUOTES, 'UTF-8') ?>"
                                       class="hover:text-teal-600 transition">
                                        <?= htmlspecialchars($phonePrimary, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </p>
                            <?php endif; ?>

                            <?php if (!empty($phoneSecondary)): ?>
                                <p class="text-slate-800 font-medium text-sm mt-0.5">
                                    <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', $phoneSecondary), ENT_QUOTES, 'UTF-8') ?>"
                                       class="hover:text-teal-600 transition">
                                        <?= htmlspecialchars($phoneSecondary, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">
                                E-Posta
                            </h3>

                            <?php if (!empty($email)): ?>
                                <p class="text-slate-600 text-sm">
                                    <a href="mailto:<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                                       class="hover:text-teal-600 transition">
                                        <?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-3">
                                Çalışma Saatleri
                            </h3>

                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-2">
                                <?php if ($isHoursArray && is_array($workingHours)): ?>

                                    <?php foreach ($workingHours as $day => $hour): ?>
                                        <div class="flex justify-between border-b border-slate-200/60 pb-2 last:border-0 last:pb-0 text-sm text-slate-600">
                                            <span class="font-medium text-slate-700">
                                                <?= htmlspecialchars($day, ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                            <span class="text-slate-500">
                                                <?= htmlspecialchars($hour, ENT_QUOTES, 'UTF-8') ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>

                                <?php else: ?>

                                    <div class="text-sm text-slate-600 font-medium py-1">
                                        <?= nl2br(htmlspecialchars((string)$workingHours, ENT_QUOTES, 'UTF-8')) ?>
                                    </div>

                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

                <?php if (!empty($whatsappNumber)): ?>
                    <div class="pt-8 border-t border-slate-100 mt-6">
                        <a href="https://wa.me/<?= htmlspecialchars($whatsappNumber, ENT_QUOTES, 'UTF-8') ?>"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="inline-flex items-center justify-center w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-emerald-600/20 hover:scale-[1.02] transition-all duration-300">
                            <span class="mr-2">💬</span> WhatsApp ile İletişime Geç
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100 min-h-[450px] lg:min-h-full flex items-center justify-center">

                <?php if ($allowedMap): ?>
                    <iframe
                        src="<?= htmlspecialchars($mapsEmbed, ENT_QUOTES, 'UTF-8') ?>"
                        width="100%"
                        height="100%"
                        style="min-height:500px; border:0; display:block;"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen>
                    </iframe>
                <?php else: ?>
                    <div class="text-center p-8 space-y-3">
                        <span class="text-4xl">📍</span>
                        <h4 class="text-lg font-bold text-slate-700">Klinik Konumu</h4>
                        <p class="text-slate-500 text-sm max-w-sm">
                            Klinik harita konumu şu anda güncellenmektedir. Adres bilgisini kullanarak bizi ziyaret edebilirsiniz.
                        </p>
                    </div>
                <?php endif; ?>

            </div>

        </div>

    </div>
</section>

<section class="py-20 bg-white border-t border-slate-100">
    <div class="max-w-4xl mx-auto px-6 text-center">

        <span class="text-teal-600 font-bold uppercase tracking-widest text-sm">
            Sağlıklı Gülüşler
        </span>

        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mt-2 mb-6">
            İlk Adımı Hemen Atın
        </h2>

        <p class="text-slate-600 text-base md:text-lg max-w-3xl mx-auto mb-10 leading-relaxed font-light">
            Uzman hekim kadromuz ve modern teknolojik altyapımız ile ağız ve diş sağlığınız için en doğru çözümleri sunuyoruz. Randevu almak veya detaylı bilgi edinmek için hemen bize ulaşabilirsiniz.
        </p>

        <a href="<?= htmlspecialchars(site_url('randevu.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-teal-600/20 hover:scale-105 transition-all duration-300">
            Randevu Talep Et
        </a>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>