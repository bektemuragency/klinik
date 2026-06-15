<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "İletişim";

$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$settings = $data['settings'];
?>
<?php include __DIR__ . '/header.php'; ?>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

<!-- HERO SECTION -->
<!-- Diğer sayfalarla tam uyumlu, derinlikli gradient arka plan ve ferah yerleşim -->
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            Bizimle İletişime Geçin
        </h1>
        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            Tedavi süreçleri hakkında bilgi almak, randevu oluşturmak veya merak ettiğiniz tüm konular için uzman ekibimizle iletişime geçebilirsiniz.
        </p>
    </div>
    <!-- Tasarım bütünlüğü için arka plan dekorasyonu -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- CONTENT SECTION -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid lg:grid-cols-2 gap-10 items-stretch">

            <!-- LEFT: İletişim Bilgileri Kartı -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100 flex flex-col justify-between">
                
                <div>
                    <p class="text-slate-600 text-sm md:text-base mb-8 leading-relaxed">
                        Sağlıklı ve estetik gülüşler için yanınızdayız. Aşağıdaki iletişim bilgilerinden bize doğrudan ulaşabilirsiniz.
                    </p>

                    <div class="space-y-6">
                        <!-- Klinik Adı -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">Klinik Adı</h3>
                            <p class="text-slate-800 font-semibold text-lg">
                                <?= $settings['clinic_name'] ?>
                            </p>
                        </div>

                        <!-- Adres -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">Adres</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">
                                <?= $settings['address'] ?>
                            </p>
                        </div>

                        <!-- Telefon -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">Telefon</h3>
                            <p class="text-slate-800 font-medium text-sm">
                                <?= $settings['phone_primary'] ?>
                            </p>
                            <?php if(!empty($settings['phone_secondary'])): ?>
                                <p class="text-slate-800 font-medium text-sm mt-0.5">
                                    <?= $settings['phone_secondary'] ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- E-Posta -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-1">E-Posta</h3>
                            <p class="text-slate-600 text-sm">
                                <?= $settings['email'] ?>
                            </p>
                        </div>

                        <!-- WORKING HOURS (Çalışma Saatleri Tablosu) -->
                        <div>
                            <h3 class="text-xs font-bold uppercase tracking-wider text-teal-600 mb-3">
                                Çalışma Saatleri
                            </h3>
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 space-y-2">
                                <?php foreach ($settings['working_hours'] as $day => $hour): ?>
                                    <div class="flex justify-between border-b border-slate-200/60 pb-2 last:border-0 last:pb-0 text-sm text-slate-600">
                                        <span class="font-medium text-slate-700"><?= $day ?></span>
                                        <span class="text-slate-500"><?= $hour ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WHATSAPP BUTONU -->
                <div class="pt-8 border-t border-slate-100 mt-6">
                    <a href="https://wa.me/<?= $settings['whatsapp_number'] ?>"
                       target="_blank"
                       class="inline-flex items-center justify-center w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3.5 rounded-xl font-bold shadow-lg shadow-emerald-600/20 hover:scale-[1.02] transition-all duration-300">
                        <span class="mr-2">💬</span> WhatsApp ile İletişime Geç
                    </a>
                </div>

            </div>

            <!-- RIGHT MAP: Harita Bölümü -->
            <!-- Harita kenarlarının kartla uyumlu dönmesi için overflow-hidden ve soft bir gölge uygulandı -->
            <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100 min-h-[450px] lg:min-h-full">
                <iframe
                    src="<?= $settings['google_maps_embed'] ?>"
                    width="100%"
                    height="100%"
                    style="min-height:500px; border:0; display:block;"
                    loading="lazy"
                    allowfullscreen>
                </iframe>
            </div>

        </div>

    </div>
</section>

<!-- BOTTOM CTA SECTION -->
<!-- Alt kısım tamamen beyaz yapıldı ve yazı/buton uyumları ana sayfayla eşitlendi -->
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