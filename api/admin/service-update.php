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

$id = (int)($_POST['id'] ?? 0);
$title = clean($_POST['title'] ?? '');
$short_desc = clean($_POST['short_desc'] ?? '');
$content = clean($_POST['content'] ?? '');
$is_active = isset($_POST['is_active']) ? (int)$_POST['is_active'] : 1;

/*
====================
VALIDATION
====================
*/
if (!$id || !$title) {
    jsonError("Eksik veri");
}

/*
====================
OLD DATA
====================
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM services
    WHERE id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$oldService = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$oldService) {
    jsonError("Hizmet bulunamadı", 404);
}

// cakisma kontrollu slug, kendisi haric digerleriyle kiyaslanir
$slug = uniqueSlug(toSlug($title), $id);

/*
====================
IMAGE (optional update)
====================
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
====================
BUILD QUERY
====================
*/
$sql = "
    UPDATE services
    SET title = :title,
        short_desc = :short_desc,
        content = :content,
        slug = :slug,
        is_active = :is_active
";

$params = [
    ':title' => $title,
    ':short_desc' => $short_desc,
    ':content' => $content,
    ':slug' => $slug,
    ':is_active' => $is_active,
    ':id' => $id
];

if ($image_path) {
    $sql .= ", image_path = :image_path";
    $params[':image_path'] = $image_path;
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
    FROM services
    WHERE id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$newService = $stmt->fetch(PDO::FETCH_ASSOC);

logActivity(
    $pdo,
    'service_updated',
    'service',
    $id,
    $oldService,
    $newService
);

jsonSuccess(null, "Hizmet güncellendi");