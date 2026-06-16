<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "İletişim";

// 1. Statik MockData.json yüklemesi (API hata verirse yedek olarak kullanılacak)
$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);
$fallbackSettings = $data['settings'] ?? [];

// 2. Canlı İletişim/Ayar API'sinden verileri çekiyoruz
// (Kendi projenizdeki gerçek API url yoluna göre güncelleyebilirsiniz)
$apiUrl = 'http://localhost/klinikcms/api/settings.php'; 
$response = @file_get_contents($apiUrl);
$apiData = json_decode($response, true);

// API'den veri başarıyla geldi mi kontrolü
if (isset($apiData['success']) && $apiData['success'] === true && !empty($apiData['data'])) {
    $settings = $apiData['data'];
    $isHoursArray = false; // API'den string (tek metin) geldiği için false yapıyoruz
} else {
    // API çalışmazsa json dosyasındaki verileri kullan
    $settings = $fallbackSettings;
    $isHoursArray = is_array($settings['working_hours'] ?? null); 
}
?>
<?php include __DIR__ . '/header.php'; ?>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

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
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">Klinik Adı</h3>
                            <p class="text-slate-800 font-semibold text-lg">
                                <?= htmlspecialchars($settings['clinic_name'] ?? 'Nova Dent') ?>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">Adres</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                <?= htmlspecialchars($settings['address'] ?? 'Adres Belirtilmemiş') ?>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">Telefon</h3>
                            <p class="text-slate-800 font-medium text-sm">
                                <?= htmlspecialchars($settings['phone_primary'] ?? '') ?>
                            </p>
                            <?php if(!empty($settings['phone_secondary'])): ?>
                                <p class="text-slate-800 font-medium text-sm mt-0.5">
                                    <?= htmlspecialchars($settings['phone_secondary']) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">E-Posta</h3>
                            <p class="text-slate-600 text-sm">
                                <?= htmlspecialchars($settings['email'] ?? '') ?>
                            </p>
                        </div>

                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-3">
                                Çalışma Saatleri
                            </h3>
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-2">
                                <?php if ($isHoursArray): ?>
                                    <?php foreach ($settings['working_hours'] as $day => $hour): ?>
                                        <div class="flex justify-between border-b border-slate-200/60 pb-2 last:border-0 last:pb-0 text-sm text-slate-600">
                                            <span class="font-medium text-slate-700"><?= htmlspecialchars($day) ?></span>
                                            <span class="text-slate-500"><?= htmlspecialchars($hour) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-sm text-slate-600 font-medium py-1">
                                        <?= htmlspecialchars($settings['working_hours'] ?? 'Hafta içi ve Cumartesi: 09:00 - 20:00') ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 mt-6">
                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $settings['whatsapp_number'] ?? '') ?>"
                       target="_blank"
                       class="inline-flex items-center justify-center w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-emerald-600/20 hover:scale-[1.02] transition-all duration-300">
                        <span class="mr-2">💬</span> WhatsApp ile İletişime Geç
                    </a>
                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100 min-h-[450px] lg:min-h-full flex items-center justify-center">
                <?php if (!empty($settings['google_maps_embed'])): ?>
                    <iframe
                        src="<?= $settings['google_maps_embed'] ?>"
                        width="100%"
                        height="100%"
                        style="min-height:500px; border:0; display:block;"
                        loading="lazy"
                        allowfullscreen>
                    </iframe>
                <?php else: ?>
                    <div class="text-center p-8 space-y-3">
                        <span class="text-4xl">📍</span>
                        <h4 class="text-lg font-bold text-slate-700">Klinik Konumu</h4>
                        <p class="text-slate-500 text-sm max-w-sm">Klinik harita konumu şu anda güncellenmektedir. Adres bilgisini kullanarak bizi ziyaret edebilirsiniz.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>

    </div>
</section>

<section class="py-20 bg-white border-t border-slate-100">
    <div class="max-w-4xl mx-auto px-6 text-center">

        <span class="text-teal-600 font-bold uppercase tracking-widest text-sm">Sağlıklı Gülüşler</span>
        <h2 class="text-3xl md:text-4xl font-extrabold text-slate-800 mt-2 mb-6">
            İlk Adımı Hemen Atın
        </h2>

        <p class="text-slate-600 text-base md:text-lg max-w-3xl mx-auto mb-10 leading-relaxed font-light">
            Uzman hekim kadromuz ve modern teknolojik altyapımız ile ağız ve diş sağlığınız için en doğru çözümleri sunuyoruz. Randevu almak veya detaylı bilgi edinmek için hemen bize ulaşabilirsiniz.
        </p>

        <a href="randevu.php"
           class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-teal-600/20 hover:scale-105 transition-all duration-300">
            Randevu Talep Et
        </a>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>