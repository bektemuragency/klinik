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
DELETE
====================
*/
$stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ?");
$stmt->execute([$id]);

logActivity(
    $pdo,
    'doctor_deleted',
    'doctor',
    $id,
    $oldDoctor,
    null
);

jsonSuccess(null, "Silindi");