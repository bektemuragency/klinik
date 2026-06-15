<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "Randevu Al";

$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$settings = $data['settings'];
$services = $data['services'];
?>

<?php include __DIR__ . '/header.php'; ?>

<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            Online Randevu
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            <?= $settings['clinic_name'] ?> üzerinden kolayca randevu oluşturabilirsiniz.
        </p>

    </div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<section class="py-16">
    <div class="max-w-4xl mx-auto px-6">

        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 p-8 md:p-12 border border-slate-100/80">

            <h2 class="text-2xl md:text-3xl font-bold mb-8 text-center text-slate-800">
                Randevu Talep Formu
            </h2>

            <form class="grid md:grid-cols-2 gap-6">

                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Ad Soyad</label>
                    <input type="text"
                           placeholder="Örn: Ahmet Yılmaz"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-teal-600 focus:border-teal-600 text-slate-800 transition">
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Telefon</label>
                    <input type="text"
                           placeholder="0 (5XX) XXX XX XX"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-teal-600 focus:border-teal-600 text-slate-800 transition">
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Hizmet Seçin</label>
                    <select class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-teal-600 focus:border-teal-600 text-slate-800 transition">
                        <option value="" disabled selected>Tedavi veya Hizmet Seçiniz</option>
                        <?php foreach($services as $service): ?>
                            <option value="<?= $service['id'] ?>">
                                <?= $service['title'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-slate-700 font-medium mb-2 text-sm">Tercih Edilen Tarih</label>
                    <input type="date"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3.5 focus:outline-none focus:bg-white focus:ring-2 focus:ring-teal-600 focus:border-teal-600 text-slate-800 transition">
                </div>

                <div class="md:col-span-2">
                    <?php include __DIR__ . '/footer.php'; ?>