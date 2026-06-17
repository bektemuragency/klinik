<?php
// includes/functions.php
// Ortak yardimci fonksiyonlar (slug, upload, sanitize, csrf vs.)

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


// DOSYA YUKLEME (IMAGE UPLOAD) - guvenlik sertlestirilmis versiyon
function uploadImage(array $file, string $folder): string|false {

    // upload hatasi kontrolu (PHP tarafinda bir sorun olduysa)
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) {
        return false;
    }

    // max 3MB
    if (!isset($file['size']) || $file['size'] > 3 * 1024 * 1024) {
        return false;
    }

    // izin verilen uzantilar (dosya adindan degil, whitelist'ten kontrol)
    $allowedExt = ['jpg', 'jpeg', 'png', 'webp'];
    $ext = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExt, true)) {
        return false;
    }

    // GERCEK dosya icerigine bakarak MIME tespiti (Content-Type header'ina guvenme)
    $allowedMime = [
        'image/jpeg' => ['jpg', 'jpeg'],
        'image/png'  => ['png'],
        'image/webp' => ['webp'],
    ];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $realMime = $finfo ? finfo_file($finfo, $file['tmp_name']) : false;
    if ($finfo) {
        finfo_close($finfo);
    }

    if (!$realMime || !isset($allowedMime[$realMime])) {
        return false;
    }

    // gercek MIME ile uzantinin tutarli olmasini zorunlu kil
    if (!in_array($ext, $allowedMime[$realMime], true)) {
        return false;
    }

    // ek guvence: gercekten bir resim mi (getimagesize bos donerse resim degildir)
    if (@getimagesize($file['tmp_name']) === false) {
        return false;
    }

    // dosya adini TAMAMEN biz uretiyoruz, kullanicidan gelen isim asla kullanilmiyor
    $name = uniqid('img_', true) . '.' . $ext;
    $name = preg_replace('/[^a-zA-Z0-9_\.\-]/', '', $name); // ekstra guvenlik

    $dir = UPLOAD_PATH . $folder . '/';

    // klasor yoksa olustur
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $path = $dir . $name;

    if (!move_uploaded_file($file['tmp_name'], $path)) {
        return false;
    }

    // yuklenen dosyanin calistirilabilir olmamasini garanti et
    @chmod($path, 0644);

    return 'uploads/' . $folder . '/' . $name;
}


// CSRF TOKEN OLUSTUR / GETIR
function csrfToken(): string {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (
        empty($_SESSION['csrf_token']) ||
        !is_string($_SESSION['csrf_token'])
    ) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}


// FORM ICIN HIDDEN CSRF INPUT
function csrfInput(): string {
    return '<input type="hidden" name="csrf_token" value="' .
        htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') .
    '">';
}


// CSRF TOKEN DOGRULA
function verifyCsrf(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $sessionToken = $_SESSION['csrf_token'] ?? '';
    $postedToken  = $_POST['csrf_token'] ?? '';

    if (
        !is_string($sessionToken) ||
        !is_string($postedToken) ||
        $sessionToken === '' ||
        $postedToken === '' ||
        !hash_equals($sessionToken, $postedToken)
    ) {
        jsonError('Güvenlik doğrulaması başarısız.', 403);
    }
}


// INPUT TEMIZLEME (DB/STORAGE icin - SADECE trim, HTML escape YOK)
// XSS korumasi artik OUTPUT katmaninda (ekrana basarken htmlspecialchars ile) yapilmali.
// Bu sayede veri DB'de "temiz" / orijinal haliyle saklanir, cift encode olmaz.
function clean(string $value): string {
    return trim($value);
}


// OUTPUT ESCAPE (ekrana basarken kullan, DB'ye yazmadan once degil)
function escapeOutput(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}