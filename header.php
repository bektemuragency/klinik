<?php
// Eğer bu dosya doğrudan çağrılırsa config ve data ayarlarını korumak için kontrol
if (!isset($settings)) {
    $json = @file_get_contents(__DIR__ . '/mockdata.json');
    $data = $json ? json_decode($json, true) : [];
    $settings = $data['settings'] ?? ['clinic_name' => 'Nova Dent', 'phone_primary' => '', 'address' => ''];
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? $pageTitle . " - " : "" ?><?= $settings['clinic_name'] ?></title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased">

<div class="bg-slate-900 text-slate-400 text-xs py-2.5 px-6 border-b border-slate-800 hidden md:block">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-6">
            <span>📞 <?= isset($settings['phone_primary']) ? $settings['phone_primary'] : '' ?></span>
            <span>📍 <?= isset($settings['address']) ? mb_strimwidth($settings['address'], 0, 50, "...") : '' ?></span>
        </div>
        <div>
            <span class="text-teal-400 font-medium">Çalışma Saatleri:</span> Hafta İçi 09:00 - 19:00
        </div>
    </div>
</div>

<header class="bg-white sticky top-0 z-50 border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
        
        <a href="index.php" class="flex items-center space-x-2 group">
            <span class="text-2xl font-black tracking-tight text-slate-800">
                <?= $settings['clinic_name'] ?>
            </span>
        </a>

        <nav class="hidden md:flex items-center space-x-8 font-medium text-sm text-slate-600">
            <a href="index.php" class="hover:text-teal-600 transition">Ana Sayfa</a>
            <a href="hizmetler.php" class="hover:text-teal-600 transition">Hizmetlerimiz</a>
            <a href="doktorlarimiz.php" class="hover:text-teal-600 transition">Doktorlarımız</a>
            <a href="iletisim.php" class="hover:text-teal-600 transition">İletişim</a>
            
            <a href="randevu.php" 
               class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all duration-300">
                Hızlı Randevu
            </a>
        </nav>

        <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-600 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

    </div>

    <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-100 absolute w-full left-0 px-6 py-4 space-y-3 shadow-xl">
        <a href="index.php" class="block py-2 font-medium text-slate-700 border-b border-slate-50">Ana Sayfa</a>
        <a href="hizmetler.php" class="block py-2 font-medium text-slate-700 border-b border-slate-50">Hizmetlerimiz</a>
        <a href="doktorlarimiz.php" class="block py-2 font-medium text-slate-700 border-b border-slate-50">Doktorlarımız</a>
        <a href="iletisim.php" class="block py-2 font-medium text-slate-700 border-b border-slate-50">İletişim</a>
        <a href="randevu.php" class="block text-center bg-teal-600 text-white py-3 rounded-xl font-bold text-sm shadow-md">Randevu Al</a>
    </div>
</header>

<script>
    // Mobil Menü Açma/Kapama Scripti
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('menu-icon');

    if (btn && menu && icon) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');
            if(menu.classList.contains('hidden')) {
                icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            } else {
                icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            }
        });
    }
</script>