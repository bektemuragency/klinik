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

/*
====================
OLD LOGO
====================
*/
$stmt = $pdo->prepare("
    SELECT logo_path
    FROM clinic_settings
    WHERE id = 1
    LIMIT 1
");
$stmt->execute();
$oldSettings = $stmt->fetch(PDO::FETCH_ASSOC);

if (empty($_FILES['logo']['name'])) {
    jsonError("Logo gerekli");
}

$upload = uploadImage($_FILES['logo'], 'logo');

if (!$upload) {
    jsonError("Yükleme başarısız");
}

$stmt = $pdo->prepare("
    UPDATE clinic_settings
    SET logo_path = ?
    WHERE id = 1
");
$stmt->execute([$upload]);

/*
====================
LOG
====================
*/
logActivity(
    $pdo,
    'logo_updated',
    'clinic_settings',
    1,
    [
        'logo_path' => $oldSettings['logo_path'] ?? null
    ],
    [
        'logo_path' => $upload
    ]
);

jsonSuccess($upload, "Logo güncellendi");