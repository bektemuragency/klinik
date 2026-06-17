<?php
require_once __DIR__ . '/includes/config.php';

$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "Hizmet Detayı";

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    http_response_code(404);
    die("Geçersiz istek: Hizmet bilgisi eksik.");
}

/* =========================
   API FETCH
========================= */
$apiUrl = api_url('services.php');
$response = @file_get_contents($apiUrl);
$apiData = json_decode($response, true);

$service = null;
$isFromApi = false;

/* =========================
   API SEARCH
========================= */
if (
    is_array($apiData) &&
    isset($apiData['success']) &&
    $apiData['success'] === true &&
    !empty($apiData['data']) &&
    is_array($apiData['data'])
) {
    foreach ($apiData['data'] as $item) {
        if (($item['slug'] ?? '') === $slug) {
            $service = $item;
            $isFromApi = true;
            break;
        }
    }
}

/* =========================
   FALLBACK MOCKDATA
========================= */
if (!$service) {
    $json = @file_get_contents(__DIR__ . '/mockdata.json');
    $data = $json ? json_decode($json, true) : [];
    $mockServices = $data['services'] ?? [];

    foreach ($mockServices as $item) {
        if (($item['slug'] ?? '') === $slug) {
            $service = $item;
            $isFromApi = false;
            break;
        }
    }
}

/* =========================
   NOT FOUND / PASSIVE
========================= */
if (!$service || (isset($service['is_active']) && (int)$service['is_active'] !== 1)) {
    http_response_code(404);
    die("Hizmet bulunamadı veya aktif değil.");
}

$pageTitle = $service['title'] ?? 'Hizmet Detayı';

/* =========================
   IMAGE URL
========================= */
$imageUrl = '';

if ($isFromApi && !empty($service['image_path'])) {
    $imageUrl = asset_url($service['image_path']);
} elseif (!$isFromApi && !empty($service['image_url'])) {
    $imageUrl = $service['image_url'];
}

/* =========================
   CONTENT CLEANER
========================= */
function parseServiceContent($html): string
{
    $text = html_entity_decode(strip_tags((string)$html), ENT_QUOTES, 'UTF-8');

    $text = preg_replace("/\r\n|\r/", "\n", $text);
    $lines = array_filter(array_map('trim', explode("\n", $text)));

    $output = "";

    foreach ($lines as $line) {
        $safeLine = htmlspecialchars($line, ENT_QUOTES, 'UTF-8');

        if (
            mb_strlen($line, 'UTF-8') < 90 &&
            (
                preg_match('/(Hangi|Tedavi|Aşamaları|Esnasında|Durumlarda|Avantajları|Süreç|Nasıl|Neden|\?)/u', $line)
                || ctype_upper(mb_substr($line, 0, 1, 'UTF-8'))
            )
        ) {
            $output .= "<h2 class='text-black font-bold text-2xl mt-8 mb-3 leading-snug'>{$safeLine}</h2>";
        } else {
            $output .= "<p class='text-slate-700 leading-relaxed mb-4'>{$safeLine}</p>";
        }
    }

    return $output;
}
?>

<?php include __DIR__ . '/header.php'; ?>

<!-- HERO -->
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
            <?= htmlspecialchars($service['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            <?= htmlspecialchars($service['short_desc'] ?? '', ENT_QUOTES, 'UTF-8') ?>
        </p>

    </div>

    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- CONTENT -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

            <!-- IMAGE -->
            <?php if (!empty($imageUrl)): ?>
                <div class="h-64 md:h-96 relative bg-slate-100">
                    <img src="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>"
                         class="w-full h-full object-cover"
                         alt="<?= htmlspecialchars($service['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>
            <?php endif; ?>

            <!-- BODY -->
            <div class="p-8 md:p-12">

                <div class="prose max-w-none">
                    <?= parseServiceContent($service['content'] ?? '') ?>
                </div>

                <hr class="my-10 border-slate-100">

                <!-- CTA -->
                <div class="bg-slate-50 rounded-2xl p-6 md:p-8 text-center border border-slate-100">

                    <h3 class="text-xl font-bold text-slate-800 mb-2">
                        Bu Tedavi İçin Randevu Almak İster misiniz?
                    </h3>

                    <p class="text-slate-500 text-sm max-w-xl mx-auto mb-6">
                        Uzman hekimlerimiz eşliğinde güvenli ve hızlı tedavi süreci.
                    </p>

                    <a href="<?= htmlspecialchars(site_url('randevu.php'), ENT_QUOTES, 'UTF-8') ?>"
                       class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-10 py-4 rounded-xl font-bold transition-all">
                        Randevu Al
                    </a>

                </div>

            </div>

        </div>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>