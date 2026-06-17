<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/activity_log.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

verifyCsrf();

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
OLD DATA
====================
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM doctors
    WHERE id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$oldDoctor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$oldDoctor) {
    jsonError("Doktor bulunamadı", 404);
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

/*
====================
NEW DATA
====================
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM doctors
    WHERE id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$newDoctor = $stmt->fetch(PDO::FETCH_ASSOC);

logActivity(
    $pdo,
    'doctor_updated',
    'doctor',
    $id,
    $oldDoctor,
    $newDoctor
);

jsonSuccess(null, "Doktor güncellendi");