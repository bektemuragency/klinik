<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';

$pdo = getDB();

$stmt = $pdo->query("
    SELECT
        id,
        clinic_name,
        slogan,
        about_text,
        phone_primary,
        phone_secondary,
        email,
        address,
        working_hours,
        logo_path,
        facebook_url,
        instagram_url,
        whatsapp_number,
        google_maps_embed,
        primary_color,
        updated_at
    FROM clinic_settings
    WHERE id = 1
    LIMIT 1
");

$settings = $stmt->fetch();

if (!$settings) {
    jsonError('Ayarlar bulunamadı', 404);
}

jsonSuccess($settings);