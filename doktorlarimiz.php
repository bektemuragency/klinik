<?php
$config = require __DIR__ . '/config.php';

$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$doctors = $data['doctors'] ?? [];
$settings = $data['settings'];
$pageTitle = "Doktorlarımız";

include __DIR__ . '/header.php'; 
?>

<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">Uzman Hekim Kadromuz</h1>
        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            Deneyimli ve alanında uzman hekimlerimiz ile hizmet veriyoruz.
        </p>
    </div>
</section>

<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($doctors as $doctor): ?>
                <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden flex flex-col justify-between">
                    <div>
                        <div class="h-80 overflow-hidden">
                            <img src="<?= $doctor['image'] ?>" alt="<?= $doctor['name'] ?>" class="w-full h-full object-cover">
                        </div>
                        <div class="p-6 text-center">
                            <h3 class="text-2xl font-bold text-slate-800"><?= $doctor['name'] ?></h3>
                            <p class="text-teal-600 font-semibold text-sm uppercase mt-1"><?= $doctor['title'] ?></p>
                        </div>
                    </div>
                    <div class="px-6 pb-8 text-center">
                        <a href="randevu.php" class="bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-md inline-block">
                            Randevu Al
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>