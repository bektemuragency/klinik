<?php
require_once __DIR__ . '/includes/config.php';

$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "Ana Sayfa";

/*
====================================
MOCKDATA FALLBACK
====================================
*/
$json = @file_get_contents(__DIR__ . '/mockdata.json');
$data = $json ? json_decode($json, true) : [];

$settings     = $data['settings'] ?? [];
$hero         = $data['hero'] ?? [];
$stats        = $data['statistics'] ?? [];
$doctors      = $data['doctors'] ?? [];
$testimonials = $data['testimonials'] ?? [];
$why_us       = $data['why_us'] ?? [];
$services     = $data['services'] ?? [];

$isFromApi = false;
$isDoctorsApi = false;

/*
====================================
CANLI API'DEN HİZMETLERİ ÇEK
====================================
*/
$apiUrl = api_url('services.php');
$response = @file_get_contents($apiUrl);
$apiData = json_decode($response, true);

if (
    is_array($apiData) &&
    isset($apiData['success']) &&
    $apiData['success'] === true &&
    !empty($apiData['data']) &&
    is_array($apiData['data'])
) {
    $services = $apiData['data'];
    $isFromApi = true;
}

/*
====================================
CANLI API'DEN DOKTORLARI ÇEK
====================================
*/
$doctorApiUrl = api_url('doctors.php');
$doctorResponse = @file_get_contents($doctorApiUrl);
$doctorApiData = json_decode($doctorResponse, true);

if (
    is_array($doctorApiData) &&
    isset($doctorApiData['success']) &&
    $doctorApiData['success'] === true &&
    !empty($doctorApiData['data']) &&
    is_array($doctorApiData['data'])
) {
    $doctors = $doctorApiData['data'];
    $isDoctorsApi = true;
}
?>

<?php include __DIR__ . '/header.php'; ?>

<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 data-aos="fade-up" class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight leading-tight">
            <?= htmlspecialchars($hero['title'] ?? 'Sağlıklı Gülüşler İçin Yanınızdayız', ENT_QUOTES, 'UTF-8') ?>
        </h1>

        <p data-aos="fade-up" data-aos-delay="100" class="text-lg md:text-xl text-teal-100 max-w-3xl mx-auto mb-10 font-light">
            <?= htmlspecialchars($hero['subtitle'] ?? 'Modern teknoloji ve uzman hekim kadromuz ile ağız ve diş sağlığınız için güvenilir çözümler sunuyoruz.', ENT_QUOTES, 'UTF-8') ?>
        </p>

        <div data-aos="fade-up" data-aos-delay="200">
            <a href="<?= htmlspecialchars(site_url('randevu.php'), ENT_QUOTES, 'UTF-8') ?>"
               class="inline-block bg-white text-teal-800 px-8 py-4 rounded-xl font-bold shadow-lg shadow-teal-900/20 hover:bg-teal-50 hover:scale-105 transition-all duration-300">
                Randevu Al
            </a>
        </div>

    </div>

    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<section class="relative z-20 -mt-10 max-w-6xl mx-auto px-6">
    <div data-aos="zoom-in" class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100 p-8 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">

        <div class="p-2">
            <h2 class="text-3xl md:text-4xl font-black text-slate-800 mb-1">
                <?= htmlspecialchars($stats['happy_patients'] ?? '500', ENT_QUOTES, 'UTF-8') ?>+
            </h2>
            <p class="text-teal-600 font-semibold tracking-wider text-xs uppercase">Mutlu Hasta</p>
        </div>

        <div class="p-2 border-l border-slate-100">
            <h2 class="text-3xl md:text-4xl font-black text-slate-800 mb-1">
                <?= htmlspecialchars($stats['years_experience'] ?? '10', ENT_QUOTES, 'UTF-8') ?>+
            </h2>
            <p class="text-teal-600 font-semibold tracking-wider text-xs uppercase">Yıllık Deneyim</p>
        </div>

        <div class="p-2 border-l border-slate-100 md:border-l">
            <h2 class="text-3xl md:text-4xl font-black text-slate-800 mb-1">
                <?= htmlspecialchars($stats['successful_implants'] ?? '300', ENT_QUOTES, 'UTF-8') ?>+
            </h2>
            <p class="text-teal-600 font-semibold tracking-wider text-xs uppercase">Başarılı İmplant</p>
        </div>

        <div class="p-2 border-l border-slate-100">
            <h2 class="text-3xl md:text-4xl font-black text-slate-800 mb-1">
                <?= htmlspecialchars($stats['expert_doctors'] ?? '5', ENT_QUOTES, 'UTF-8') ?>+
            </h2>
            <p class="text-teal-600 font-semibold tracking-wider text-xs uppercase">Uzman Hekim</p>
        </div>

    </div>
</section>

<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-xs bg-teal-50 px-3 py-1.5 rounded-lg">
                Ayrıcalıklarımız
            </span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-4">
                Neden <?= htmlspecialchars($settings['clinic_name'] ?? 'Nova Dent', ENT_QUOTES, 'UTF-8') ?>?
            </h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php $delay = 0; ?>
            <?php foreach ($why_us as $item): ?>
                <?php $delay += 100; ?>

                <div data-aos="fade-up"
                     data-aos-delay="<?= (int)$delay ?>"
                     class="p-8 bg-white rounded-3xl shadow-xl shadow-slate-200/30 border border-slate-100/80 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-teal-50 rounded-xl flex items-center justify-center text-teal-600 font-bold text-lg mb-5">
                            ✓
                        </div>

                        <h3 class="text-lg font-bold text-slate-800 mb-3 tracking-tight">
                            <?= htmlspecialchars($item['title'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p class="text-slate-600 text-sm leading-relaxed">
                            <?= htmlspecialchars($item['description'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-20" data-aos="fade-up">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-xs bg-teal-50 px-4 py-2 rounded-full border border-teal-100">
                Tedavilerimiz
            </span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-slate-900 mt-4 tracking-tight">
                Klinik Hizmetlerimiz
            </h2>
            <div class="w-12 h-1 bg-teal-600 mx-auto mt-4 rounded-full"></div>
        </div>

        <?php
        $activeServices = array_filter($services, function ($service) use ($isFromApi) {
            if ($isFromApi && isset($service['is_active']) && (int)$service['is_active'] !== 1) {
                return false;
            }

            if (isset($service['is_active']) && (int)$service['is_active'] !== 1) {
                return false;
            }

            return true;
        });
        ?>

        <?php if (!empty($activeServices)): ?>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php $delay = 0; ?>
                <?php foreach ($activeServices as $service): ?>
                    <?php
                    $delay += 100;

                    $serviceTitle = $service['title'] ?? '';
                    $serviceDesc  = $service['short_desc'] ?? '';
                    $serviceSlug  = $service['slug'] ?? '';

                    if ($isFromApi) {
                        $imagePath = !empty($service['image_path'])
                            ? asset_url($service['image_path'])
                            : '';
                    } else {
                        $imagePath = $service['image_url'] ?? '';
                    }

                    $detailUrl = site_url('hizmet-detay.php?slug=' . urlencode($serviceSlug));
                    ?>

                    <div data-aos="fade-up"
                         data-aos-delay="<?= (int)$delay ?>"
                         class="group bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-10px_rgba(15,118,110,0.12)] hover:border-teal-100 transition-all duration-500 flex flex-col justify-between">

                        <div>
                            <div class="h-64 w-full overflow-hidden relative bg-slate-100">
                                <div class="absolute inset-0 bg-teal-900/10 z-10 group-hover:opacity-0 transition-opacity duration-500"></div>

                                <?php if (!empty($imagePath)): ?>
                                    <img src="<?= htmlspecialchars($imagePath, ENT_QUOTES, 'UTF-8') ?>"
                                         class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out"
                                         alt="<?= htmlspecialchars($serviceTitle, ENT_QUOTES, 'UTF-8') ?>">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-slate-400 text-sm">
                                        Görsel yok
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="p-8">
                                <h3 class="font-bold text-2xl text-slate-800 mb-3 tracking-tight group-hover:text-teal-700 transition-colors duration-300">
                                    <?= htmlspecialchars($serviceTitle, ENT_QUOTES, 'UTF-8') ?>
                                </h3>

                                <p class="text-slate-500 text-sm leading-relaxed mb-4 font-light">
                                    <?= htmlspecialchars($serviceDesc, ENT_QUOTES, 'UTF-8') ?>
                                </p>
                            </div>
                        </div>

                        <div class="px-8 pb-8">
                            <a href="<?= htmlspecialchars($detailUrl, ENT_QUOTES, 'UTF-8') ?>"
                               class="inline-flex items-center text-teal-600 font-bold text-sm tracking-wide transition-all duration-300 group-hover:text-teal-800">
                                <span>Detaylı İncele</span>
                                <span class="ml-2 transform group-hover:translate-x-2 transition-transform duration-300">→</span>
                            </a>
                        </div>

                    </div>

                <?php endforeach; ?>
            </div>

        <?php else: ?>

            <div class="text-center py-12">
                <p class="text-slate-500 text-lg">
                    Şu anda görüntülenecek aktif bir hizmet bulunmamaktadır.
                </p>
            </div>

        <?php endif; ?>

    </div>
</section>

<section class="py-24 bg-slate-900 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid lg:grid-cols-2 gap-16 items-center">

        <div data-aos="fade-right" class="space-y-6">
            <span class="text-teal-400 font-bold uppercase tracking-widest text-xs bg-teal-500/10 px-3 py-1.5 rounded-lg border border-teal-500/20">
                Dijital Diş Hekimliği
            </span>

            <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight leading-tight">
                En Modern Teknoloji İle <br>
                <span class="text-teal-400">Kusursuz Sonuçlar</span>
            </h2>

            <p class="text-slate-400 text-sm md:text-base leading-relaxed font-light">
                <?= htmlspecialchars($settings['clinic_name'] ?? 'Nova Dent', ENT_QUOTES, 'UTF-8') ?> polikliniklerinde, ağız içi tarayıcılardan üç boyutlu çene tomografisine kadar en son nesil dental teknolojileri kullanıyoruz. Bu sayede tedavi süreçlerinizi sıfır hata payı ile planlıyor, konforunuzu en üst düzeyde tutuyoruz.
            </p>

            <div class="grid grid-cols-2 gap-6 pt-4 text-sm font-medium text-slate-300">
                <div class="flex items-center space-x-3">
                    <span class="text-teal-400 text-lg">✦</span>
                    <span>3D Ağız İçi Tarama</span>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="text-teal-400 text-lg">✦</span>
                    <span>Ağrısız Lokal Anestezi</span>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="text-teal-400 text-lg">✦</span>
                    <span>%100 Steril Ortam</span>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="text-teal-400 text-lg">✦</span>
                    <span>Dijital Gülüş Tasarımı</span>
                </div>
            </div>
        </div>

        <div data-aos="fade-left" class="relative">
            <div class="absolute inset-0 bg-gradient-to-tr from-teal-500 to-transparent opacity-20 rounded-3xl blur-2xl"></div>
            <img src="https://images.unsplash.com/photo-1629909613654-28e377c37b09?auto=format&fit=crop&w=800&q=80"
                 alt="Klinik Teknoloji"
                 class="rounded-3xl shadow-2xl border border-slate-800 object-cover w-full h-[450px]">
        </div>

    </div>
</section>

<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 text-center">

        <div class="mb-16" data-aos="fade-up">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-xs bg-teal-50 px-3 py-1.5 rounded-lg">
                Kadromuz
            </span>

            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-4">
                Uzman Hekimlerimiz
            </h2>
        </div>

        <?php if (!empty($doctors)): ?>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                <?php $delay = 0; ?>
                <?php foreach ($doctors as $doc): ?>
                    <?php
                    $delay += 100;

                    $doctorName = $doc['name'] ?? '';
                    $doctorTitle = $doc['title'] ?? '';

                    if ($isDoctorsApi) {
                        $doctorImage = !empty($doc['image'])
                            ? asset_url($doc['image'])
                            : '';
                    } else {
                        $doctorImage = $doc['image'] ?? '';
                    }
                    ?>

                    <div data-aos="fade-up"
                         data-aos-delay="<?= (int)$delay ?>"
                         class="bg-white rounded-3xl p-8 shadow-xl shadow-slate-200/30 border border-slate-100 hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300">

                        <div class="w-28 h-28 mx-auto rounded-full ring-4 ring-teal-50 overflow-hidden mb-5 shadow-inner bg-slate-100">
                            <?php if (!empty($doctorImage)): ?>
                                <img src="<?= htmlspecialchars($doctorImage, ENT_QUOTES, 'UTF-8') ?>"
                                     class="w-full h-full object-cover"
                                     alt="<?= htmlspecialchars($doctorName, ENT_QUOTES, 'UTF-8') ?>">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">
                                    Görsel yok
                                </div>
                            <?php endif; ?>
                        </div>

                        <h3 class="font-bold text-slate-800 text-lg tracking-tight">
                            <?= htmlspecialchars($doctorName, ENT_QUOTES, 'UTF-8') ?>
                        </h3>

                        <p class="text-teal-600 text-sm font-semibold mt-1 uppercase tracking-wide">
                            <?= htmlspecialchars($doctorTitle, ENT_QUOTES, 'UTF-8') ?>
                        </p>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php else: ?>

            <div class="text-center py-12">
                <p class="text-slate-500 text-lg">
                    Şu anda görüntülenecek doktor bilgisi bulunmamaktadır.
                </p>
            </div>

        <?php endif; ?>

    </div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center">

        <div class="mb-16" data-aos="fade-up">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-xs bg-teal-50 px-3 py-1.5 rounded-lg">
                Sizden Gelenler
            </span>

            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-4">
                Hasta Yorumları
            </h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php $delay = 0; ?>
            <?php foreach ($testimonials as $t): ?>
                <?php $delay += 100; ?>

                <div data-aos="fade-up"
                     data-aos-delay="<?= (int)$delay ?>"
                     class="bg-slate-50 p-8 rounded-3xl border border-slate-100 shadow-xl shadow-slate-100/30 text-left relative flex flex-col justify-between hover:bg-slate-100/50 transition duration-300">

                    <p class="text-slate-600 text-sm italic leading-relaxed mb-6">
                        "<?= htmlspecialchars($t['comment'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    </p>

                    <h4 class="font-bold text-slate-800 border-t border-slate-200/60 pt-4 text-sm tracking-wide">
                        — <?= htmlspecialchars($t['name'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                    </h4>

                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>

<section class="py-24 bg-gradient-to-br from-teal-800 to-slate-900 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-6 relative z-10" data-aos="zoom-in">
        <h2 class="text-3xl md:text-5xl font-extrabold mb-6 leading-tight tracking-tight">
            Sağlıklı Bir Gülüş İçin Hemen Randevu Alın
        </h2>

        <p class="text-teal-100 max-w-xl mx-auto mb-10 font-light text-base md:text-lg">
            Ekiplerimiz en kısa sürede sizinle iletişime geçerek en uygun tarihi planlayacaktır.
        </p>

        <a href="<?= htmlspecialchars(site_url('randevu.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="inline-block bg-white text-teal-950 px-10 py-4 rounded-xl font-bold shadow-xl shadow-slate-950/40 hover:bg-teal-50 hover:scale-105 transition-all duration-300">
            Randevu Al
        </a>
    </div>

    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-700/30 rounded-full blur-3xl"></div>
</section>

<?php include __DIR__ . '/footer.php'; ?>