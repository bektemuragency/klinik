<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

verifyCsrf();

$pdo = getDB();

/*
========================
INPUTS
========================
*/
$title = clean($_POST['title'] ?? '');
$short_desc = clean($_POST['short_desc'] ?? '');
$content = clean($_POST['content'] ?? '');
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

/*
========================
VALIDATION
========================
*/
if (!$title) {
    jsonError("Başlık zorunlu");
}

/*
========================
SLUG (cakisma kontrollu)
========================
*/
$slug = uniqueSlug(toSlug($title));

/*
========================
AUTO SORT ORDER
========================
*/
$stmt = $pdo->query("SELECT MAX(sort_order) FROM services");
$sort_order = (int)$stmt->fetchColumn() + 1;

/*
========================
IMAGE UPLOAD
========================
*/
$image_path = null;

if (!empty($_FILES['image']['name'])) {
    $upload = uploadImage($_FILES['image'], 'services');

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
    INSERT INTO services
    (title, short_desc, content, slug, image_path, is_active, sort_order, created_at)
    VALUES
    (?, ?, ?, ?, ?, ?, ?, NOW())
");

$stmt->execute([
    $title,
    $short_desc,
    $content,
    $slug,
    $image_path,
    $is_active,
    $sort_order
]);

jsonSuccess(null, "Hizmet başarıyla eklendi");