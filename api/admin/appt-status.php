<?php
 
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';
 
$pdo = getDB();
 
$id         = (int)($_POST['id']         ?? 0);
$status     = $_POST['status']           ?? '';
$admin_note = trim($_POST['admin_note']  ?? '');
 
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
 
if ($stmt->rowCount() === 0) {
    jsonError('Randevu bulunamadı veya değişiklik yapılmadı', 404);
}
 
jsonSuccess([
    'id'         => $id,
    'status'     => $status,
    'admin_note' => $admin_note
], 'Durum güncellendi');
 