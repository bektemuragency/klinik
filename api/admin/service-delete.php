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

$id = (int)($_POST['id'] ?? 0);

if (!$id) {
    jsonError("ID gerekli");
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

/*
====================
DELETE
====================
*/
$stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([$id]);

logActivity(
    $pdo,
    'service_deleted',
    'service',
    $id,
    $oldService,
    null
);

jsonSuccess(null, "Silindi");