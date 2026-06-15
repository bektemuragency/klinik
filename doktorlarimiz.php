<?php
$config = require __DIR__ . '/config.php';

$json = file_get_contents(__DIR__ . '/mockdata.json');
$data = json_decode($json, true);

$doctors = $data['doctors'] ?? [];
$settings = $data['settings'];
$pageTitle = "Doktorlarımız";

include __DIR__ . '/header.php'; 
?>

<!-- HERO SECTION -->
<section class="relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center relative z-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 tracking-tight">Uzman Hekim Kadromuz</h1>
        <p class="text-lg text-teal-100 max-w-3xl mx-auto font-light">
            Deneyimli ve alanında uzman hekimlerimiz ile hizmet veriyoruz.
        </p>
    </div>
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-teal-600/20 rounded-full blur-3xl"></div>
</section>

<!-- DOCTORS LIST SECTION -->
<section class="py-20 bg-slate-50">
    <div class="max-w-7xl mx-auto px-6">
        
        <!-- Sıkışıklığı önleyen akıllı grid yapısı: Mobilde 1, Tablette 2, Masaüstünde 3, Geniş Ekranlarda 4 kol -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            
            <?php $delay = 0; foreach($doctors as $doctor): $delay += 100; ?>
                <div data-aos="fade-up" data-aos-delay="<?= $delay ?>" class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden hover:shadow-2xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between">
                    
                    <div>
                        <!-- FOTOĞRAF ALANI -->
                        <div class="h-72 overflow-hidden relative">
                            <img src="<?= $doctor['image'] ?>" alt="<?= $doctor['name'] ?>" class="w-full h-full object-cover">
                        </div>
                        
                        <!-- BİLGİ ALANI -->
                        <div class="p-6 text-center">
                            <h3 class="text-xl font-bold text-slate-800 tracking-tight"><?= $doctor['name'] ?></h3>
                            <p class="text-teal-600 font-semibold text-xs uppercase tracking-wider mt-1.5"><?= $doctor['title'] ?></p>
                        </div>
                    </div>
                    
                    <!-- BUTON ALANI -->
                    <div class="px-6 pb-6 text-center">
                        <a href="randevu.php" class="w-full bg-teal-600 hover:bg-teal-700 text-white py-3 rounded-xl text-xs font-bold shadow-md hover:shadow-lg hover:shadow-teal-600/20 transition-all duration-300 inline-block">
                            Randevu Al
                        </a>
                    </div>
                    
                </div>
            <?php endforeach; ?>
            
        </div>
        
    </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>