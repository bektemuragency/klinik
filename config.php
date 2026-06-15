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
        "subtitle" => "text-lg md:text-xl font-light text-teal-100",                   // Hero alt başlıklar
        "section_title" => "text-3xl md:text-4xl font-bold text-slate-800 mt-2",       // Bölüm başlıkları
        "card_title" => "text-xl font-bold text-slate-800 tracking-tight",             // Kart başlıkları
        "body" => "text-slate-600 leading-relaxed"                                     // Genel gövde metni
    ],

    // Bölümler arası nefes alma mesafeleri (Padding ve Marginler)
    "spacing" => [
        "section" => "py-20 md:py-24",        // Bölümler arası dikey genişlik (Ferahlık hissi)
        "container" => "max-w-7xl mx-auto px-6",
        "card" => "p-6 md:p-8"
    ],

    // Sitede tekrar tekrar kullanılan ortak arayüz elemanları
    "components" => [
        // Yumuşak gölgeli, mikroborderlı modern kart yapısı
        "card" => "bg-white rounded-3xl shadow-xl shadow-slate-200/40 border border-slate-100/80 overflow-hidden hover:shadow-2xl hover:-translate-y-1 transition-all duration-300",
        
        // Gölgeli, hover animasyonlu ana buton
        "button_primary" => "bg-teal-600 hover:bg-teal-700 text-white px-8 py-3.5 rounded-xl font-bold shadow-lg shadow-teal-600/20 hover:scale-[1.02] transition-all duration-300 inline-flex items-center justify-center",
        
        // Daha soft duran, üzerine gelindiğinde parlayan ikincil/detay butonu
        "button_outline" => "bg-slate-50 hover:bg-teal-600 text-teal-700 hover:text-white border border-slate-200 hover:border-teal-600 px-6 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:shadow-lg hover:shadow-teal-600/20 transition-all duration-300 inline-flex items-center justify-center"
    ],

    // Sayfa iskeleti (Layout) düzenleri
    "layout" => [
        "hero" => "relative bg-gradient-to-br from-teal-700 to-teal-900 text-white py-24 overflow-hidden", // Derinlikli degrade arka plan
        "section" => "py-20 bg-slate-50",
        "container" => "max-w-7xl mx-auto px-6"
    ]
];