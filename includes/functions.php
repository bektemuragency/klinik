<?php
// includes/functions.php
// Ortak yardimci fonksiyonlar (slug, upload, sanitize vs.)

require_once __DIR__ . '/db.php';


// TURKCE KARAKTERLERI SLUG'A CEVIR
function toSlug(string $text): string {
    $text = mb_strtolower(trim($text), 'UTF-8');

    $tr = ['ç','ğ','ı','i','ö','ş','ü',' '];
    $en = ['c','g','i','i','o','s','u','-'];

    $text = str_replace($tr, $en, $text);

    // gereksiz karakterleri temizle
    $text = preg_replace('/[^a-z0-9\-]/', '', $text);

    // coklu tire temizle
    $text = preg_replace('/-+/', '-', $text);

    return trim($text, '-');
}


// UNIQUE SLUG OLUSTUR (DB kontrolu)
function uniqueSlug(string $base, int $excludeId = 0): string {
    $pdo = getDB();

    $slug = $base;
    $i = 2;

    while (true) {
        $sql = "SELECT id FROM services WHERE slug = ? AND id != ?";
        $st = $pdo->prepare($sql);
        $st->execute([$slug, $excludeId]);

        if (!$st->fetch()) {
            break;
        }

        $slug = $base . '-' . $i;
        $i++;
    }

    return $slug;
}


// DOSYA YUKLEME (IMAGE UPLOAD)
function uploadImage(array $file, string $folder): string|false {

    // izin verilen tipler
    $allowed = ['image/jpeg', 'image/png', 'image/webp'];

    if (!isset($file['type']) || !in_array($file['type'], $allowed)) {
        return false;
    }

    // max 3MB
    if ($file['size'] > 3 * 1024 * 1024) {
        return false;
    }

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid('img_') . '.' . strtolower($ext);

    $dir = UPLOAD_PATH . $folder . '/';

    // klasor yoksa olustur
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $path = $dir . $name;

    if (!move_uploaded_file($file['tmp_name'], $path)) {
        return false;
    }

    return 'uploads/' . $folder . '/' . $name;
}


// INPUT TEMIZLEME (XSS KORUMA)
function clean(string $value): string {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}