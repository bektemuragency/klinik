<?php
require_once __DIR__ . '/includes/config.php';

/*
========================================
SETTINGS API
========================================
*/
$settings = [];

$settingsApi = api_url('settings.php');
$settingsResponse = @file_get_contents($settingsApi);

if ($settingsResponse !== false) {
    $settingsJson = json_decode($settingsResponse, true);

    if (
        isset($settingsJson['success']) &&
        $settingsJson['success'] === true &&
        isset($settingsJson['data']) &&
        is_array($settingsJson['data'])
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
                <?= htmlspecialchars($settings['clinic_name'] ?? 'Nova Dent', ENT_QUOTES, 'UTF-8') ?>
            </h3>

            <p class="text-sm leading-relaxed text-slate-400 mb-6">
                <?= nl2br(htmlspecialchars($settings['about_text'] ?? 'Modern teknoloji ve uzman hekim kadromuz ile ağız ve diş sağlığınız için uluslararası standartlarda, konforlu ve güvenilir tedavi çözümleri sunuyoruz.', ENT_QUOTES, 'UTF-8')) ?>
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
                <li><a href="<?= site_url('index.php') ?>" class="hover:text-white transition">Ana Sayfa</a></li>
                <li><a href="<?= site_url('hizmetler.php') ?>" class="hover:text-white transition">Hizmetlerimiz</a></li>
                <li><a href="<?= site_url('doktorlarimiz.php') ?>" class="hover:text-white transition">Doktorlarımız</a></li>
                <li><a href="<?= site_url('iletisim.php') ?>" class="hover:text-white transition">İletişim</a></li>
                <li><a href="<?= site_url('randevu.php') ?>" class="hover:text-teal-400 font-medium transition">Online Randevu Al</a></li>
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
                        <span><?= htmlspecialchars($settings['address'], ENT_QUOTES, 'UTF-8') ?></span>
                    </li>
                <?php endif; ?>

                <?php if (!empty($settings['phone_primary'])): ?>
                    <li class="flex items-center">
                        <span class="mr-2.5 text-teal-400">📞</span>
                        <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', $settings['phone_primary']), ENT_QUOTES, 'UTF-8') ?>"
                           class="hover:text-white transition">
                            <?= htmlspecialchars($settings['phone_primary'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (!empty($settings['phone_secondary'])): ?>
                    <li class="flex items-center">
                        <span class="mr-2.5 text-teal-400">☎️</span>
                        <a href="tel:<?= htmlspecialchars(preg_replace('/\s+/', '', $settings['phone_secondary']), ENT_QUOTES, 'UTF-8') ?>"
                           class="hover:text-white transition">
                            <?= htmlspecialchars($settings['phone_secondary'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if (!empty($settings['email'])): ?>
                    <li class="flex items-center">
                        <span class="mr-2.5 text-teal-400">✉️</span>
                        <a href="mailto:<?= htmlspecialchars($settings['email'], ENT_QUOTES, 'UTF-8') ?>"
                           class="hover:text-white transition">
                            <?= htmlspecialchars($settings['email'], ENT_QUOTES, 'UTF-8') ?>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>

        <!-- ÇALIŞMA SAATLERİ -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">
                Çalışma Saatleri
            </h4>

            <div class="bg-slate-800/40 rounded-xl p-4 border border-slate-800 text-xs leading-relaxed">

                <?php if (!empty($settings['working_hours'])): ?>
                    <p class="text-teal-400 font-medium">
                        <?= nl2br(htmlspecialchars($settings['working_hours'], ENT_QUOTES, 'UTF-8')) ?>
                    </p>
                <?php else: ?>
                    <div class="space-y-2">
                        <div class="flex justify-between border-b border-slate-800/60 pb-1.5">
                            <span class="text-slate-300">Pazartesi - Cuma</span>
                            <span class="text-teal-400 font-medium">09:00 - 19:00</span>
                        </div>

                        <div class="flex justify-between border-b border-slate-800/60 pb-1.5">
                            <span class="text-slate-300">Cumartesi</span>
                            <span class="text-teal-400 font-medium">09:00 - 15:00</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-slate-300">Pazar</span>
                            <span class="italic text-red-400/80">Kapalı</span>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <?php if (!empty($settings['whatsapp_number'])): ?>
                <a href="https://wa.me/<?= htmlspecialchars(preg_replace('/\D+/', '', $settings['whatsapp_number']), ENT_QUOTES, 'UTF-8') ?>"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="inline-block mt-4 text-sm text-teal-400 hover:text-white transition">
                    WhatsApp ile iletişime geç →
                </a>
            <?php endif; ?>
        </div>

    </div>

    <!-- ALT BAR -->
    <div class="max-w-7xl mx-auto px-6 border-t border-slate-800 pt-6">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 text-xs text-slate-500">

            <p>
                © <?= date('Y') ?>
                <?= htmlspecialchars($settings['clinic_name'] ?? 'Nova Dent', ENT_QUOTES, 'UTF-8') ?>
                - Tüm hakları saklıdır.
            </p>

            <p>
                <?= htmlspecialchars($settings['slogan'] ?? 'Herkes İçin Sağlık', ENT_QUOTES, 'UTF-8') ?>
            </p>

        </div>
    </div>

</footer>

<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    if (typeof AOS !== "undefined") {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    }
</script>

</body>
</html>