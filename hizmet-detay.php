<?php
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
$apiUrl = 'http://localhost/klinikcms/api/services.php';
$response = @file_get_contents($apiUrl);
$apiData = json_decode($response, true);

$service = null;
$isFromApi = false;

/* =========================
   API SEARCH
========================= */
if (isset($apiData['success']) && $apiData['success'] === true && !empty($apiData['data'])) {
    foreach ($apiData['data'] as $item) {
        if ($item['slug'] === $slug) {
            $service = $item;
            $isFromApi = true;
            break;
        }
    }
}

/* =========================
   FALLBACK
========================= */
if (!$service) {
    $json = file_get_contents(__DIR__ . '/mockdata.json');
    $data = json_decode($json, true);
    $mockServices = $data['services'] ?? [];

    foreach ($mockServices as $item) {
        if ($item['slug'] === $slug) {
            $service = $item;
            $isFromApi = false;
            break;
        }
    }
}

if (!$service || (isset($service['is_active']) && $service['is_active'] != 1)) {
    http_response_code(404);
    die("Hizmet bulunamadı veya aktif değil.");
}

$pageTitle = htmlspecialchars($service['title'] ?? 'Hizmet Detayı');

$imageUrl = $isFromApi
    ? 'http://localhost/klinikcms/' . ltrim($service['image_path'] ?? '', '/')
    : ($service['image_url'] ?? '');

/* =========================
   CONTENT CLEANER
========================= */
function parseServiceContent($html)
{
    $text = html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8');

    // satırları düzelt
    $text = preg_replace("/\r\n|\r/", "\n", $text);
    $lines = array_filter(array_map('trim', explode("\n", $text)));

    $output = "";

    foreach ($lines as $line) {

        // 🔥 Başlık tespiti
        if (
            mb_strlen($line) < 90 &&
            (
                preg_match('/(Hangi|Tedavi|Aşamaları|Esnasında|Durumlarda|\?)/u', $line)
                || ctype_upper(mb_substr($line, 0, 1))
            )
        ) {
            $output .= "<h2 class='text-black font-bold text-2xl mt-8 mb-3 leading-snug'>{$line}</h2>";
        } else {
            $output .= "<p class='text-slate-700 leading-relaxed mb-4'>{$line}</p>";
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
            <?= htmlspecialchars($service['title'] ?? '') ?>
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            <?= htmlspecialchars($service['short_desc'] ?? '') ?>
        </p>

    </div>

    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- CONTENT -->
<section class="py-16">
    <div class="max-w-4xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100">

            <!-- IMAGE -->
            <div class="h-64 md:h-96 relative">
                <img src="<?= htmlspecialchars($imageUrl) ?>"
                     class="w-full h-full object-cover"
                     alt="<?= htmlspecialchars($service['title'] ?? '') ?>">
            </div>

            <!-- BODY -->
            <div class="p-8 md:p-12">

                <!-- 🔥 FULL SMART CONTENT -->
                <div class="prose max-w-none">
                    <?= parseServiceContent($service['content']) ?>
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

                    <a href="randevu.php"
                       class="inline-block bg-teal-600 hover:bg-teal-700 text-white px-10 py-4 rounded-xl font-bold transition-all">
                        Randevu Al
                    </a>

                </div>

            </div>

        </div>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>