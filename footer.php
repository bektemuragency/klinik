<!-- SİTE ALTI (FOOTER) -->
<footer class="bg-slate-900 text-slate-400 pt-16 pb-8 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
        
        <!-- KLİNİK HAKKINDA -->
        <div>
            <h3 class="text-white font-bold text-lg mb-4 tracking-tight">
                <span class="text-teal-400">Nova</span> Dent
            </h3>
            <p class="text-sm leading-relaxed text-slate-400 mb-6">
                Modern teknoloji ve uzman hekim kadromuz ile ağız ve diş sağlığınız için uluslararası standartlarda, konforlu ve güvenilir tedavi çözümleri sunuyoruz.
            </p>
            <div class="flex space-x-4 text-xs text-teal-400 font-semibold">
                <span>✓ Güvenilir</span>
                <span>✓ Hijyenik</span>
                <span>✓ Uzman</span>
            </div>
        </div>

        <!-- HIZLI LİNKLER -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Hızlı Menü</h4>
            <ul class="space-y-2.5 text-sm">
                <li><a href="index.php" class="hover:text-white transition">Ana Sayfa</a></li>
                <li><a href="hizmetler.php" class="hover:text-white transition">Hizmetlerimiz</a></li>
                <li><a href="doktorlarimiz.php" class="hover:text-white transition">Doktorlarımız</a></li>
                <li><a href="iletisim.php" class="hover:text-white transition">İletişim</a></li>
                <li><a href="randevu.php" class="hover:text-teal-400 font-medium transition">Online Randevu Al</a></li>
            </ul>
        </div>

        <!-- İLETİŞİM BİLGİLERİ -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">İletişim</h4>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start">
                    <span class="mr-2.5 mt-0.5 text-teal-400">📍</span>
                    <span><?= $settings['address'] ?? 'Klinik Adresi' ?></span>
                </li>
                <li class="flex items-center">
                    <span class="mr-2.5 text-teal-400">📞</span>
                    <span><?= $settings['phone_primary'] ?? 'Telefon' ?></span>
                </li>
                <li class="flex items-center">
                    <span class="mr-2.5 text-teal-400">✉️</span>
                    <span><?= $settings['email'] ?? 'E-posta' ?></span>
                </li>
            </ul>
        </div>

        <!-- ÇALIŞMA SAATLERİ ÖZET -->
        <div>
            <h4 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Çalışma Saatleri</h4>
            <div class="bg-slate-800/40 rounded-xl p-4 border border-slate-800 space-y-2 text-xs">
                <div class="flex justify-between border-b border-slate-800/60 pb-1.5">
                    <span class="text-slate-300">Pazartesi - Cuma</span>
                    <span class="text-teal-400 font-medium">09:00 - 19:00</span>
                </div>
                <div class="flex justify-between border-b border-slate-800/60 pb-1.5">
                    <span class="text-slate-300">Cumartesi</span>
                    <span class="text-teal-400 font-medium">09:00 - 15:00</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Pazar</span>
                    <span class="italic text-red-400/80">Kapalı</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ALT BİLGİ / TELİF HAKKI -->
    <div class="max-w-7xl mx-auto px-6 pt-8 border-t border-slate-800 text-xs flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500">
        <div>
            &copy; <?= date('Y') ?> <?= $settings['clinic_name'] ?>. Tüm Hakları Saklıdır.
        </div>
        <div class="flex space-x-6">
            <a href="#" class="hover:text-slate-400 transition">Aydınlatma Metni</a>
            <a href="#" class="hover:text-slate-400 transition">Çerez Politikası</a>
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