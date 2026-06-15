<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "Hizmetler";

$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$services = $data['services'];
?>

<?php include __DIR__ . '/header.php'; ?>

<!-- HERO SECTION -->
<!-- Diğer sayfalarla tam uyumlu premium gradient arka plan -->
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            Hizmetlerimiz
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            Modern diş hekimliği uygulamaları ile sağlıklı ve estetik gülüşler için sunduğumuz tüm hizmetleri keşfedin.
        </p>

    </div>
    <!-- Tasarım bütünlüğü için arka plan dekorasyonu -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- SERVICES SECTION -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($services as $service): ?>

                <!-- Kart gölgeleri ve border yapıları yumuşatıldı, alt alta flex-col ile hizalandı -->
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:-translate-y-1 border border-slate-100 overflow-hidden group transition-all duration-300 flex flex-col justify-between">

                    <div>
                        <!-- IMAGE AREA: Resme şık bir zum/odaklanma efekti eklendi -->
                        <div class="h-56 overflow-hidden relative">
                            <img
                                src="<?= $service['image_url'] ?>"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            <!-- Resim üzerine hafif estetik bir degrade geçiş bindirildi -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent"></div>
                        </div>

                        <!-- CONTENT AREA -->
                        <div class="p-6 md:p-8">
                            <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-teal-600 transition duration-200">
                                <?= $service['title'] ?>
                            </h3>

                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                <?= $service['short_desc'] ?>
                            </p>
                        </div>
                    </div>

                    <!-- BUTTON AREA: Butonların hep aynı hizada durması sağlandı -->
                    <div class="px-6 pb-6 md:px-8 md:pb-8">
                        <a href="hizmet-detay.php?slug=<?= $service['slug'] ?>"
                           class="inline-flex items-center justify-center w-full md:w-auto bg-slate-50 hover:bg-teal-600 text-teal-700 hover:text-white border border-slate-200 hover:border-teal-600 px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow-lg hover:shadow-teal-600/20 transition-all duration-300">
                            Detaylı İncele <span class="ml-1.5 transform group-hover:translate-x-1 transition duration-200">→</span>
                        </a>
                    </div>

                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
