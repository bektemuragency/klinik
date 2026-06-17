<?php
/*
========================================
SETTINGS API
========================================
*/
$settings = [];

$settingsApi = 'http://localhost/klinikcms/api/settings.php';
$settingsResponse = @file_get_contents($settingsApi);

if ($settingsResponse !== false) {
    $settingsJson = json_decode($settingsResponse, true);

    if (
        isset($settingsJson['success']) &&
        $settingsJson['success'] === true &&
        isset($settingsJson['data'])
    ) {
        $settings = $settingsJson['data'];
    }
}
?>

<!-- SİTE ALTI (FOOTER) -->
<footer class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-800">

    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">

        <!-- KLİNİK HAKKINDA -->
        <div>
            <h3 class="text-white font-bold text-lg mb-4 tracking-tight">
                <?= htmlspecialchars($settings['clinic_name'] ?? 'Nova Dent') ?>
            </h3>

            <p class="text-sm leading-relaxed text-slate-400 mb-6">
                <?= nl2br(htmlspecialchars($settings['about_text'] ?? 'Modern teknoloji ve uzman hekim kadromuz ile ağız ve diş sağlığınız için uluslararası standartlarda, konforlu ve güvenilir tedavi çözümleri sunuyoruz.')) ?>
            </p>

            <div class="flex flex-wrap gap-3 text-xs text-teal-400 font-semibold">
                <span>✓ Güvenilir</span>
                <span>✓ Hijyenik</span>
                <span>✓ Uzman</span>
            </div>
        </div>

        <!-- HIZLI MENÜ -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">
                Hızlı Menü
            </h4>

            <ul class="space-y-2.5 text-sm">
                <li><a href="index.php" class="hover:text-white transition">Ana Sayfa</a></li>
                <li><a href="hizmetler.php" class="hover:text-white transition">Hizmetlerimiz</a></li>
                <li><a href="doktorlarimiz.php" class="hover:text-white transition">Doktorlarımız</a></li>
                <li><a href="iletisim.php" class="hover:text-white transition">İletişim</a></li>
                <li><a href="randevu.php" class="hover:text-teal-400 font-medium transition">Online Randevu Al</a></li>
            </ul>
        </div>

        <!-- İLETİŞİM -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">
                İletişim
            </h4>

            <ul class="space-y-3 text-sm">

                <?php if (!empty($settings['address'])): ?>
                <li class="flex items-start">
                    <span class="mr-2.5 mt-0.5 text-teal-400">📍</span>
                    <span><?= htmlspecialchars($settings['address']) ?></span>
                </li>
                <?php endif; ?>

                <?php if (!empty($settings['phone_primary'])): ?>
                <li class="flex items-center">
                    <span class="mr-2.5 text-teal-400">📞</span>
                    <span><?= htmlspecialchars($settings['phone_primary']) ?></span>
                </li>
                <?php endif; ?>

                <?php if (!empty($settings['email'])): ?>
                <li class="flex items-center">
                    <span class="mr-2.5 text-teal-400">✉️</span>
                    <span><?= htmlspecialchars($settings['email']) ?></span>
                </li>
                <?php endif; ?>

            </ul>
        </div>

        <!-- ÇALIŞMA SAATLERİ -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">
                Çalışma Saatleri
            </h4>

            <div class="bg-slate-800/40 rounded-xl p-4 border border-slate-800 space-y-2 text-xs">

                <div class="flex justify-between border-b border-slate-800/60 pb-1.5">
                    <span class="text-slate-300">Pazartesi - Cuma</span>
                    <span class="text-teal-400 font-medium">
                        <?= htmlspecialchars($settings['weekday_hours'] ?? '09:00 - 19:00') ?>
                    </span>
                </div>

                <div class="flex justify-between border-b border-slate-800/60 pb-1.5">
                    <span class="text-slate-300">Cumartesi</span>
                    <span class="text-teal-400 font-medium">
                        <?= htmlspecialchars($settings['saturday_hours'] ?? '09:00 - 15:00') ?>
                    </span>
                </div>

                <div class="flex justify-between">
                    <span class="text-slate-300">Pazar</span>
                    <span class="italic text-red-400/80">
                        <?= htmlspecialchars($settings['sunday_hours'] ?? 'Kapalı') ?>
                    </span>
                </div>

            </div>
        </div>

    </div>

    <!-- ALT BAR -->
    <div class="max-w-7xl mx-auto px-6 border-t border-slate-800 pt-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">

            <p>
                © <?= date('Y') ?>
                <?= htmlspecialchars($settings['clinic_name'] ?? 'Nova Dent') ?>
                - Tüm hakları saklıdır.
            </p>

            <p>
                <?= htmlspecialchars($settings['slogan'] ?? 'Herkes İçin Sağlık') ?>
            </p>

        </div>
    </div>

</footer>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,   // Animasyonun süresi (800 milisaniye = 0.8 saniye)
            once: true,      // Animasyon sadece sayfa aşağı inerken bir kez çalışsın (yukarı çıkarken tekrar etmesin)
            offset: 100      // Element ekrana 100 piksel kala animasyon başlasın
        });
    </script>

</body>
</html>