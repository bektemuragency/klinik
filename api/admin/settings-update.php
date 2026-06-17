<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/activity_log.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

verifyCsrf();

$pdo = getDB();

function normalizeGoogleMapsEmbedUrl(string $value): ?string
{
    $value = trim($value);

    if ($value === '') {
        return null;
    }

    if (stripos($value, '<iframe') !== false) {
        if (preg_match('/src=["\']([^"\']+)["\']/i', $value, $matches)) {
            $value = html_entity_decode($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        } else {
            return null;
        }
    }

    $value = trim($value);

    if (!filter_var($value, FILTER_VALIDATE_URL)) {
        return null;
    }

    $parts = parse_url($value);

    if (($parts['scheme'] ?? '') !== 'https') {
        return null;
    }

    $host = strtolower($parts['host'] ?? '');

    $allowedHosts = [
        'www.google.com',
        'google.com',
        'maps.google.com'
    ];

    if (!in_array($host, $allowedHosts, true)) {
        return null;
    }

    $path = $parts['path'] ?? '';

    if (strpos($path, '/maps/embed') !== 0) {
        return null;
    }

    return $value;
}

function normalizeUrl(?string $value): ?string
{
    $value = trim((string)$value);

    if ($value === '') {
        return null;
    }

    if (!filter_var($value, FILTER_VALIDATE_URL)) {
        return null;
    }

    $parts = parse_url($value);
    $scheme = strtolower($parts['scheme'] ?? '');

    if (!in_array($scheme, ['http', 'https'], true)) {
        return null;
    }

    return $value;
}

/*
========================
OLD SETTINGS
========================
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM clinic_settings
    WHERE id = 1
    LIMIT 1
");
$stmt->execute();
$oldSettings = $stmt->fetch(PDO::FETCH_ASSOC);

$clinic_name        = clean($_POST['clinic_name']        ?? '');
$slogan             = clean($_POST['slogan']             ?? '');
$about_text         = clean($_POST['about_text']         ?? '');
$phone_primary      = clean($_POST['phone_primary']      ?? '');
$phone_secondary    = clean($_POST['phone_secondary']    ?? '');
$email              = clean($_POST['email']              ?? '');
$whatsapp_number    = clean($_POST['whatsapp_number']    ?? '');
$address            = clean($_POST['address']            ?? '');
$working_hours      = clean($_POST['working_hours']      ?? '');
$facebook_url       = clean($_POST['facebook_url']       ?? '');
$instagram_url      = clean($_POST['instagram_url']      ?? '');
$google_maps_embed  = trim($_POST['google_maps_embed']   ?? '');
$primary_color      = clean($_POST['primary_color']      ?? '');

if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonError("Geçerli bir email adresi girin");
}

$facebook_url = normalizeUrl($facebook_url);
$instagram_url = normalizeUrl($instagram_url);

$google_maps_embed = normalizeGoogleMapsEmbedUrl($google_maps_embed);

if ($primary_color && !preg_match('/^#[0-9a-fA-F]{6}$/', $primary_color)) {
    $primary_color = '';
}

$stmt = $pdo->prepare("
    UPDATE clinic_settings SET
        clinic_name       = ?,
        slogan            = ?,
        about_text        = ?,
        phone_primary     = ?,
        phone_secondary   = ?,
        email             = ?,
        whatsapp_number   = ?,
        address           = ?,
        working_hours     = ?,
        facebook_url      = ?,
        instagram_url     = ?,
        google_maps_embed = ?,
        primary_color     = ?,
        updated_at        = NOW()
    WHERE id = 1
");

$stmt->execute([
    $clinic_name,
    $slogan          ?: null,
    $about_text      ?: null,
    $phone_primary,
    $phone_secondary ?: null,
    $email,
    $whatsapp_number ?: null,
    $address         ?: null,
    $working_hours   ?: null,
    $facebook_url,
    $instagram_url,
    $google_maps_embed,
    $primary_color   ?: null,
]);

/*
========================
NEW SETTINGS
========================
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM clinic_settings
    WHERE id = 1
    LIMIT 1
");
$stmt->execute();
$newSettings = $stmt->fetch(PDO::FETCH_ASSOC);

logActivity(
    $pdo,
    'settings_updated',
    'clinic_settings',
    1,
    $oldSettings ?: null,
    $newSettings ?: null
);

jsonSuccess(null, "Ayarlar güncellendi");