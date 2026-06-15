<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];

$pageTitle = "Doktorlarımız";

$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$doctors = $data['doctors'];
?>
<?php include __DIR__ . '/header.php'; ?>

<!-- HERO SECTION -->
<!-- Diğer tüm sayfalarla tam senkronize premium gradient arka plan -->
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">

        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight">
            Uzman Hekim Kadromuz
        </h1>

        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            Deneyimli ve alanında uzman hekimlerimiz ile sağlıklı ve estetik gülüşler için hizmet veriyoruz.
        </p>

    </div>
    <!-- Tasarım bütünlüğü için arka plan dekorasyonu -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- DOCTORS SECTION -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach($doctors as $doctor): ?>

                <!-- Kart gölgeleri, geçiş efektleri ve borderlar kurumsal çizgiye getirildi -->
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/40 hover:shadow-2xl hover:-translate-y-1.5 border border-slate-100 overflow-hidden group transition-all duration-300 flex flex-col justify-between">

                    <div>
                        <!-- IMAGE AREA: Doktor portresine hafif odaklanma efekti veren alan -->
                        <div class="h-80 overflow-hidden relative">
                            <img
                                src="<?= $doctor['image'] ?>"
                                alt="<?= $doctor['name'] ?>"
                                class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500"
                            >
                            <!-- Alt taraftan yumuşak bir degrade geçişi ile derinlik hissi -->
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/10 to-transparent"></div>
                        </div>

                        <!-- CONTENT AREA -->
                        <div class="p-6 text-center">
                            <h3 class="text-2xl font-bold text-slate-800 tracking-tight">
                                <?= $doctor['name'] ?>
                            </h3>

                            <p class="text-teal-600 font-semibold text-sm uppercase tracking-wide mt-1.5">
                                <?= $doctor['title'] ?>
                            </p>
                        </div>
                    </div>

                    <!-- BUTTON AREA: Kartların boyutu ne olursa olsun butonları en alta hizalar -->
                    <div class="px-6 pb-8 text-center">
                        <a href="randevu.php"
                           class="inline-flex items-center justify-center w-full md:w-auto bg-teal-600 hover:bg-teal-700 text-white px-8 py-3 rounded-xl text-sm font-bold shadow-md hover:shadow-lg hover:shadow-teal-600/20 transition-all duration-300">
                            <!-- Küçük bir ikon dokunuşu takvimi anımsatır -->
                            <span class="mr-2">📅</span> Randevu Al
                        </a>
                    </div>

                </div>

            <?php endforeach; ?>
        </div>

    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>