<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "Hizmet Detayı";

// JSON oku
$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$services = $data['services'];

// URL'den gelen slug
$slug = $_GET['slug'] ?? null;

// Hizmeti bul
$service = null;

foreach ($services as $item) {
    if ($item['slug'] === $slug) {
        $service = $item;
        break;
    }
}

// Bulunamazsa
if (!$service) {
    http_response_code(404);
    echo "Hizmet bulunamadı.";
    exit;
}
?>

<?php include __DIR__ . '/header.php'; ?>

<!-- HERO SECTION -->
<!-- Diğer tüm iç sayfalarla tam senkronize premium gradient arka plan -->
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            <?= $service['title'] ?>
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            <?= $service['short_desc'] ?>
        </p>

    </div>
    <!-- Tasarım bütünlüğü için arka plan dekorasyonu -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- CONTENT SECTION -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-6">

        <!-- Detay kartı yumuşatılmış gölgelerle havaya kaldırıldı -->
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden border border-slate-100">

            <!-- IMAGE AREA -->
            <div class="h-64 md:h-96 relative">
                <img
                    src="<?= $service['image_url'] ?>"
                    class="w-full h-full object-cover"
                    alt="<?= $service['title'] ?>"
                >
                <!-- Resmin üzerine alt taraftan yumuşak bir karartma eklenerek derinlik hissi verildi -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
            </div>

            <!-- TEXT & ARTICLE AREA -->
            <div class="p-8 md:p-12">

                <!-- İçerikten gelecek olan p, h2, h3 tagleri için okunabilir satır aralığı (leading-relaxed) ayarlandı -->
                <div class="text-slate-600 text-base md:text-lg leading-relaxed space-y-6">
                    <?= $service['content'] ?>
                </div>

                <!-- SEPARATOR LINE -->
                <hr class="my-10 border-slate-100">

                <!-- CALL TO ACTION AREA (Kart İçi Randevu Alanı) -->
                <div class="bg-slate-50 rounded-2xl p-6 md:p-8 text-center border border-slate-100">
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Bu Tedavi İçin Randevu Almak İster misiniz?</h3>
                    <p class="text-slate-500 text-sm max-w-xl mx-auto mb-6">
                        Uzman hekimlerimiz eşliğinde konforlu ve güvenilir bir tedavi süreci için dakikalar içinde online randevu talebi oluşturun.
                    </p>
                    <a href="randevu.php"
                       class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-teal-600/20 hover:scale-105 transition-all duration-300">
                        Randevu Al
                    </a>
                </div>

            </div>

        </div>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>