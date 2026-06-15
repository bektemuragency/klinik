<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
 
$pdo = getDB();
 
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
$google_maps_embed  = trim($_POST['google_maps_embed']   ?? '');  // clean kullanma, iframe bozulur
$primary_color      = clean($_POST['primary_color']      ?? '');
 
// primary_color format kontrolü (#rrggbb)
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
    $slogan       ?: null,
    $about_text   ?: null,
    $phone_primary,
    $phone_secondary  ?: null,
    $email,
    $whatsapp_number  ?: null,
    $address          ?: null,
    $working_hours    ?: null,
    $facebook_url     ?: null,
    $instagram_url    ?: null,
    $google_maps_embed ?: null,
    $primary_color    ?: null,
]);
 
jsonSuccess(null, "Ayarlar güncellendi");
 