<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/functions.php';

$pdo = getDB();

$id        = (int)($_POST['id'] ?? 0);
$name      = clean($_POST['name'] ?? '');
$title     = clean($_POST['title'] ?? '');
$specialty = clean($_POST['specialty'] ?? '');
$bio       = clean($_POST['bio'] ?? '');
$phone     = clean($_POST['phone'] ?? '');
$email     = clean($_POST['email'] ?? '');

/*
====================
VALIDATION
====================
*/
if (!$id || !$name) {
    jsonError("Eksik veri");
}

/*
====================
IMAGE (optional update)
====================
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
====================
BUILD QUERY
====================
*/
$sql = "
    UPDATE doctors
    SET name = :name,
        title = :title,
        specialty = :specialty,
        bio = :bio,
        phone = :phone,
        email = :email
";

$params = [
    ':name'      => $name,
    ':title'     => $title,
    ':specialty' => $specialty,
    ':bio'       => $bio,
    ':phone'     => $phone,
    ':email'     => $email,
    ':id'        => $id
];

if ($image_path) {
    $sql .= ", image = :image";
    $params[':image'] = $image_path;
}

$sql .= " WHERE id = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);

jsonSuccess(null, "Doktor güncellendi");