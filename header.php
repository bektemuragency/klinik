<?php
require_once __DIR__ . '/includes/config.php';

/*
========================================
SETTINGS API'DEN ÇEK
========================================
*/
$settings = [];

$settingsApi = api_url('settings.php');
$settingsResponse = @file_get_contents($settingsApi);

if ($settingsResponse !== false) {
    $settingsJson = json_decode($settingsResponse, true);

    if (
        is_array($settingsJson) &&
        isset($settingsJson['success']) &&
        $settingsJson['success'] === true &&
        isset($settingsJson['data']) &&
        is_array($settingsJson['data'])
    ) {
        $settings = $settingsJson['data'];
    }
}

/*
========================================
API ÇALIŞMAZSA MOCKDATA'YA DÜŞ
========================================
*/
if (empty($settings)) {
    $json = @file_get_contents(__DIR__ . '/mockdata.json');
    $data = $json ? json_decode($json, true) : [];

    $settings = $data['settings'] ?? [
        'clinic_name'    => 'Nova Dent',
        'phone_primary'  => '',
        'address'        => '',
        'email'          => '',
        'slogan'         => '',
        'working_hours'  => '',
        'logo_path'      => ''
    ];
}

$clinicName = $settings['clinic_name'] ?? 'Nova Dent';
$phone      = $settings['phone_primary'] ?? '';
$address    = $settings['address'] ?? '';
$hours      = $settings['working_hours'] ?? 'Hafta İçi 09:00 - 19:00';
$logoPath   = $settings['logo_path'] ?? '';

$shortAddress = $address;

if (function_exists('mb_strimwidth')) {
    $shortAddress = mb_strimwidth($address, 0, 50, '...', 'UTF-8');
} else {
    $shortAddress = strlen($address) > 50 ? substr($address, 0, 50) . '...' : $address;
}

$logoUrl = !empty($logoPath) ? asset_url($logoPath) : '';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= isset($pageTitle) ? htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') . " - " : "" ?>
        <?= htmlspecialchars($clinicName, ENT_QUOTES, 'UTF-8') ?>
    </title>

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

            <?php if (!empty($phone)): ?>
                <span>
                    📞 <?= htmlspecialchars($phone, ENT_QUOTES, 'UTF-8') ?>
                </span>
            <?php endif; ?>

            <?php if (!empty($shortAddress)): ?>
                <span>
                    📍 <?= htmlspecialchars($shortAddress, ENT_QUOTES, 'UTF-8') ?>
                </span>
            <?php endif; ?>

        </div>

        <div>
            <span class="text-teal-400 font-medium">Çalışma Saatleri:</span>
            <?= htmlspecialchars($hours, ENT_QUOTES, 'UTF-8') ?>
        </div>

    </div>
</div>

<header class="bg-white sticky top-0 z-50 border-b border-slate-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">

        <a href="<?= htmlspecialchars(site_url('index.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="flex items-center space-x-3 group">

            <?php if (!empty($logoUrl)): ?>
                <img src="<?= htmlspecialchars($logoUrl, ENT_QUOTES, 'UTF-8') ?>"
                     alt="<?= htmlspecialchars($clinicName, ENT_QUOTES, 'UTF-8') ?>"
                     class="h-11 w-auto object-contain">
            <?php endif; ?>

            <span class="text-2xl font-black tracking-tight text-slate-800">
                <?= htmlspecialchars($clinicName, ENT_QUOTES, 'UTF-8') ?>
            </span>

        </a>

        <nav class="hidden md:flex items-center space-x-8 font-medium text-sm text-slate-600">
            <a href="<?= htmlspecialchars(site_url('index.php'), ENT_QUOTES, 'UTF-8') ?>"
               class="hover:text-teal-600 transition">
                Ana Sayfa
            </a>

            <a href="<?= htmlspecialchars(site_url('hizmetler.php'), ENT_QUOTES, 'UTF-8') ?>"
               class="hover:text-teal-600 transition">
                Hizmetlerimiz
            </a>

            <a href="<?= htmlspecialchars(site_url('doktorlarimiz.php'), ENT_QUOTES, 'UTF-8') ?>"
               class="hover:text-teal-600 transition">
                Doktorlarımız
            </a>

            <a href="<?= htmlspecialchars(site_url('iletisim.php'), ENT_QUOTES, 'UTF-8') ?>"
               class="hover:text-teal-600 transition">
                İletişim
            </a>

            <a href="<?= htmlspecialchars(site_url('randevu.php'), ENT_QUOTES, 'UTF-8') ?>"
               class="bg-teal-600 hover:bg-teal-700 text-white px-5 py-2.5 rounded-xl font-bold text-xs shadow-md transition-all duration-300">
                Hızlı Randevu
            </a>
        </nav>

        <button id="mobile-menu-btn" class="md:hidden p-2 text-slate-600 focus:outline-none" type="button">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path id="menu-icon"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

    </div>

    <div id="mobile-menu"
         class="hidden md:hidden bg-white border-b border-slate-100 absolute w-full left-0 px-6 py-4 space-y-3 shadow-xl">

        <a href="<?= htmlspecialchars(site_url('index.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="block py-2 font-medium text-slate-700 border-b border-slate-50">
            Ana Sayfa
        </a>

        <a href="<?= htmlspecialchars(site_url('hizmetler.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="block py-2 font-medium text-slate-700 border-b border-slate-50">
            Hizmetlerimiz
        </a>

        <a href="<?= htmlspecialchars(site_url('doktorlarimiz.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="block py-2 font-medium text-slate-700 border-b border-slate-50">
            Doktorlarımız
        </a>

        <a href="<?= htmlspecialchars(site_url('iletisim.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="block py-2 font-medium text-slate-700 border-b border-slate-50">
            İletişim
        </a>

        <a href="<?= htmlspecialchars(site_url('randevu.php'), ENT_QUOTES, 'UTF-8') ?>"
           class="block text-center bg-teal-600 text-white py-3 rounded-xl font-bold text-sm shadow-md">
            Randevu Al
        </a>

    </div>
</header>

<script>
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    const icon = document.getElementById('menu-icon');

    if (btn && menu && icon) {
        btn.addEventListener('click', () => {
            menu.classList.toggle('hidden');

            if (menu.classList.contains('hidden')) {
                icon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
            } else {
                icon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
            }
        });
    }
</script>