<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';
 
$pdo = getDB();
 
if (empty($_FILES['logo']['name'])) {
    jsonError("Logo gerekli");
}
 
$upload = uploadImage($_FILES['logo'], 'logo');
 
if (!$upload) {
    jsonError("Yükleme başarısız");
}
 
$stmt = $pdo->prepare("UPDATE clinic_settings SET logo_path = ? WHERE id = 1");
$stmt->execute([$upload]);
 
jsonSuccess($upload, "Logo güncellendi");