<?php
require_once __DIR__ . '/includes/config.php';

$config = require __DIR__ . '/config.php';

$pageTitle = "Doktorlarımız";

/*
====================================
API'DEN DOKTORLARI ÇEK
====================================
*/
$doctorApiUrl = api_url('doctors.php');
$doctorResponse = @file_get_contents($doctorApiUrl);
$doctorApiData = json_decode($doctorResponse, true);

$doctors = [];

if (
    is_array($doctorApiData) &&
    isset($doctorApiData['success']) &&
    $doctorApiData['success'] === true &&
    !empty($doctorApiData['data']) &&
    is_array($doctorApiData['data'])
) {
    $doctors = $doctorApiData['data'];
}

include __DIR__ . '/header.php';
?>

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">
            Uzman Hekim Kadromuz
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            Deneyimli ve alanında uzman hekimlerimiz ile hizmet veriyoruz.
        </p>
    </div>

    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- DOCTORS LIST SECTION -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <?php if (!empty($doctors)): ?>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">

                <?php $delay = 0; ?>
                <?php foreach ($doctors as $doctor): ?>
                    <?php
                    $delay += 100;

                    $doctorName  = $doctor['name'] ?? '';
                    $doctorTitle = $doctor['title'] ?? '';
                    $doctorImage = !empty($doctor['image'])
                        ? asset_url($doctor['image'])
                        : '';
                    ?>

                    <div data-aos="fade-up"
                         data-aos-delay="<?= (int)$delay ?>"
                         class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">

                        <div>
                            <div class="h-72 overflow-hidden relative bg-slate-100">

                                <?php if (!empty($doctorImage)): ?>
                                    <img src="<?= htmlspecialchars($doctorImage, ENT_QUOTES, 'UTF-8') ?>"
                                         alt="<?= htmlspecialchars($doctorName, ENT_QUOTES, 'UTF-8') ?>"
                                         class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                        Görsel yok
                                    </div>
                                <?php endif; ?>

                            </div>

                            <div class="p-6 text-center">
                                <h3 class="text-xl font-bold text-slate-800 tracking-tight">
                                    <?= htmlspecialchars($doctorName, ENT_QUOTES, 'UTF-8') ?>
                                </h3>

                                <?php if (!empty($doctorTitle)): ?>
                                    <p class="text-teal-600 font-semibold text-xs uppercase tracking-wider mt-1.5">
                                        <?= htmlspecialchars($doctorTitle, ENT_QUOTES, 'UTF-8') ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="px-6 pb-6 text-center">
                            <a href="<?= htmlspecialchars(site_url('randevu.php'), ENT_QUOTES, 'UTF-8') ?>"
                               class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl text-xs font-bold shadow-md hover:shadow-lg hover:shadow-teal-600/20 transition-all duration-300 inline-block">
                                Randevu Al
                            </a>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="text-center text-slate-500 py-20">
                Doktor bilgisi bulunamadı.
            </div>

        <?php endif; ?>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>