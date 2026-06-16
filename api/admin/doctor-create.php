<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/functions.php';

$pdo = getDB();

/*
========================
INPUTS
========================
*/
$name      = clean($_POST['name'] ?? '');
$title     = clean($_POST['title'] ?? '');
$specialty = clean($_POST['specialty'] ?? '');
$bio       = clean($_POST['bio'] ?? '');
$phone     = clean($_POST['phone'] ?? '');
$email     = clean($_POST['email'] ?? '');

/*
========================
VALIDATION
========================
*/
if (!$name) {
    jsonError("Ad Soyad zorunlu");
}

/*
========================
IMAGE UPLOAD
========================
*/
$image_path = null;

if (!empty($_FILES['image']['name'])) {
    $upload = uploadImage($_FILES['image'], 'doctors');

    if (!$upload) {
        jsonError("Görsel yüklenemedi");
    }

    $image_path = $upload;
}

/*
========================
INSERT
========================
*/
$stmt = $pdo->prepare("
    INSERT INTO doctors
    (name, title, specialty, bio, image, phone, email, created_at)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, NOW())
");

$stmt->execute([
    $name,
    $title,
    $specialty,
    $bio,
    $image_path,
    $phone,
    $email
]);

jsonSuccess(null, "Doktor başarıyla eklendi");