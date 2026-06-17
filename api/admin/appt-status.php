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

$id         = (int)($_POST['id'] ?? 0);
$status     = $_POST['status'] ?? '';
$admin_note = trim($_POST['admin_note'] ?? '');

$allowed = [
    'pending',
    'confirmed',
    'cancelled'
];

if (!$id) {
    jsonError('ID gerekli');
}

if (!in_array($status, $allowed, true)) {
    jsonError('Geçersiz durum');
}

/*
====================
OLD DATA
====================
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM appointments
    WHERE id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$oldAppointment = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$oldAppointment) {
    jsonError('Randevu bulunamadı', 404);
}

/*
====================
UPDATE
====================
*/
$stmt = $pdo->prepare("
    UPDATE appointments
    SET
        status     = ?,
        admin_note = ?,
        updated_at = NOW()
    WHERE id = ?
");

$stmt->execute([
    $status,
    $admin_note,
    $id
]);

/*
====================
NEW DATA
====================
*/
$stmt = $pdo->prepare("
    SELECT *
    FROM appointments
    WHERE id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$newAppointment = $stmt->fetch(PDO::FETCH_ASSOC);

logActivity(
    $pdo,
    'appointment_status_updated',
    'appointment',
    $id,
    $oldAppointment,
    $newAppointment
);

jsonSuccess([
    'id'         => $id,
    'status'     => $status,
    'admin_note' => $admin_note
], 'Durum güncellendi');