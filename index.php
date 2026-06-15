<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "Ana Sayfa";

$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$settings = $data['settings'];
$hero = $data['hero'];
$stats = $data['statistics'];
$services = $data['services'];
$doctors = $data['doctors'];
$testimonials = $data['testimonials'];
$why_us = $data['why_us'] ?? [];
?>

<?php include __DIR__ . '/header.php'; ?>

<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight leading-tight">
            <?= $hero['title'] ?>
        </h1>

        <p class="text-lg md:text-xl text-teal-100 max-w-3xl mx-auto mb-10 font-light">
            <?= $hero['subtitle'] ?>
        </p>

        <a href="randevu.php"
           class="inline-block bg-white text-teal-800 px-8 py-4 rounded-xl font-bold shadow-lg shadow-teal-900/20 hover:bg-teal-50 hover:scale-105 transition-all duration-350">
            Randevu Al
        </a>

    </div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<section class="py-16 bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">

        <div class="p-4 transform hover:-translate-y-1 transition duration-300">
            <h2 class="text-4xl md:text-5xl font-black text-slate-800 mb-2"><?= $stats['happy_patients'] ?>+</h2>
            <p class="text-teal-600 font-medium tracking-wide text-sm uppercase">Mutlu Hasta</p>
        </div>

        <div class="p-4 transform hover:-translate-y-1 transition duration-300">
            <h2 class="text-4xl md:text-5xl font-black text-slate-800 mb-2"><?= $stats['years_experience'] ?>+</h2>
            <p class="text-teal-600 font-medium tracking-wide text-sm uppercase">Yıllık Deneyim</p>
        </div>

        <div class="p-4 transform hover:-translate-y-1 transition duration-300">
            <h2 class="text-4xl md:text-5xl font-black text-slate-800 mb-2"><?= $stats['successful_implants'] ?>+</h2>
            <p class="text-teal-600 font-medium tracking-wide text-sm uppercase">Başarılı İmplant</p>
        </div>

        <div class="p-4 transform hover:-translate-y-1 transition duration-300">
            <h2 class="text-4xl md:text-5xl font-black text-slate-800 mb-2"><?= $stats['expert_doctors'] ?>+</h2>
            <p class="text-teal-600 font-medium tracking-wide text-sm uppercase">Uzman Hekim</p>
        </div>

    </div>
</section>

<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-sm">Ayrıcalıklarımız</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Neden Nova Dent?</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php foreach($why_us as $item): ?>
                <div class="p-6 bg-white rounded-2xl shadow-sm border-t-4 border-teal-600 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <h3 class="text-lg font-bold text-slate-800 mb-3">
                        <?= $item['title'] ?>
                    </h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        <?= $item['description'] ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-14">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-sm">Tedaviler</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Hizmetlerimiz</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($services as $service): ?>
                <div class="bg-slate-50 rounded-3xl shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col justify-between">
                    <div>
                        <img src="<?= $service['image_url'] ?>" class="h-56 w-full object-cover">
                        <div class="p-6">
                            <h3 class="font-bold text-xl text-slate-800 mb-2">
                                <?= $service['title'] ?>
                            </h3>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                <?= $service['short_desc'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="px-6 pb-6">
                        <a href="hizmet-detay.php?slug=<?= $service['slug'] ?>"
                           class="inline-flex items-center text-teal-600 font-bold text-sm hover:text-teal-700 transition">
                            Detaylı Bilgi <span class="ml-1 transform hover:translate-x-1 transition duration-200">→</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6 text-center">

        <div class="mb-14">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-sm">Kadromuz</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Uzman Hekimlerimiz</h2>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($doctors as $doc): ?>
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition duration-300">
                    <div class="w-24 h-24 mx-auto rounded-full ring-4 ring-teal-50 overflow-hidden mb-4">
                        <img src="<?= $doc['image'] ?>" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-slate-800 text-lg"><?= $doc['name'] ?></h3>
                    <p class="text-teal-600 text-sm font-medium mt-1"><?= $doc['title'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6 text-center">

        <div class="mb-14">
            <span class="text-teal-600 font-bold uppercase tracking-widest text-sm">Sizden Gelenler</span>
            <h2 class="text-3xl md:text-4xl font-bold text-slate-800 mt-2">Hasta Yorumları</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <?php foreach($testimonials as $t): ?>
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 shadow-sm text-left relative flex flex-col justify-between">
                    <p class="text-slate-600 text-sm italic leading-relaxed mb-6">
                        "<?= $t['comment'] ?>"
                    </p>
                    <h4 class="font-bold text-slate-800 border-t border-slate-200/60 pt-4 text-sm tracking-wide">
                        — <?= $t['name'] ?>
                    </h4>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<section class="py-24 bg-gradient-to-br from-teal-800 to-slate-900 text-white text-center relative overflow-hidden">
    <div class="max-w-4xl mx-auto px-6 relative z-10">
        <h2 class="text-3xl md:text-5xl font-extrabold mb-6 leading-tight">
            Sağlıklı Bir Gülüş İçin Hemen Randevu Alın
        </h2>
        <p class="text-teal-100 max-w-xl mx-auto mb-10 font-light">
            Ekiplerimiz en kısa sürede sizinle iletişime geçerek en uygun tarihi planlayacaktır.
        </p>
        <a href="randevu.php"
           class="inline-block bg-white text-teal-950 px-10 py-4 rounded-xl font-bold shadow-xl shadow-slate-950/40 hover:bg-teal-50 hover:scale-105 transition-all duration-300">
            Randevu Al
        </a>
    </div>
    <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-700/30 rounded-full blur-3xl"></div>
</section>

<?php include __DIR__ . '/footer.php'; ?>