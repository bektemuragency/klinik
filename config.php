<?php

return [

    // Kliniğin kurumsal kimliğini belirleyen ana renk paleti
    "colors" => [
        "primary" => "teal-600",              // Canlı ve güven veren modern turkuaz
        "primary_hover" => "teal-700",        // Butonların üzerine gelindiğinde alacağı ton
        "primary_text" => "teal-600",         // Metin içi vurgu renkleri (Örn: Dr. unvanları)

        "background" => "slate-50",           // Gözü yormayan, ferah ve temiz arka plan
        "card" => "white",                    // Katmanları ayırmak için saf beyaz kartlar

        "text_main" => "slate-800",           // Saf siyah yerine elit duran kurumsal koyu gri
        "text_soft" => "slate-600",           // Açıklama ve gövde metinleri için yumuşak ton

        "border" => "slate-100"               // Kartların etrafındaki neredeyse görünmez ince çizgiler
    ],

    // Sayfa genelindeki yazı boyutları ve font ağırlıkları (Responsive - Mobil Uyumlu)
    "font" => [
        "title" => "text-4xl md:text-6xl font-extrabold tracking-tight leading-tight", // Hero büyük başlıklar
        "subtitle" => "text-lg md:text-xl font-light text-teal-100 max-w-3xl mx-auto mb-10", // Hero alt başlıklar
        "section_title" => "text-3xl md:text-5xl font-extrabold text-slate-900 mt-4 tracking-tight", // Bölüm başlıkları
        "card_title" => "text-xl font-bold text-slate-800 tracking-tight group-hover:text-teal-700 transition-colors duration-300", // Kart başlıkları
        "body" => "text-slate-500 text-sm leading-relaxed font-light"                 // Genel gövde metni
    ],

    // Bölümler arası nefes alma mesafeleri (Padding ve Marginler)
    "spacing" => [
        "section" => "py-24",                 // Bölümler arası dikey genişlik (Ferahlık hissi)
        "container" => "max-w-7xl mx-auto px-6",
        "card" => "p-8"
    ],

    // Sitede tekrar tekrar kullanılan ortak arayüz elemanları
    "components" => [
        // Yumuşak gölgeli, mikroborderlı premium kart yapısı (rounded-[32px] ve derinlikli hover gölgesi dahil)
        "card" => "group bg-white rounded-[32px] overflow-hidden border border-slate-100 shadow-[0_10px_30px_-15px_rgba(0,0,0,0.05)] hover:shadow-[0_20px_40px_-10px_rgba(15,118,110,0.12)] hover:border-teal-100 transition-all duration-500 flex flex-col justify-between",
        
        // Gölgeli, hover animasyonlu ana buton
        "button_primary" => "inline-block bg-white text-teal-800 px-8 py-4 rounded-xl font-bold shadow-lg shadow-teal-900/20 hover:bg-teal-50 hover:scale-105 transition-all duration-300",
        
        // Daha soft duran, üzerine gelindiğinde sağa süzülen ok efektli detay butonu/linki
        "button_outline" => "inline-flex items-center text-teal-600 font-bold text-sm tracking-wide transition-all duration-300 group-hover:text-teal-800"
    ],

    // Sayfa iskeleti (Layout) düzenleri
    "layout" => [
        "hero" => "relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-32 overflow-hidden", // Derinlikli degrade arka plan
        "section" => "py-24 bg-slate-50",
        "container" => "max-w-7xl mx-auto px-6"
    ]
];