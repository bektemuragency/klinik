<?php

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$pdo = getDB();

$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    jsonError('ID gerekli');
}

$stmt = $pdo->prepare("
    SELECT
        a.*,
        s.title AS service_title
    FROM appointments a
    LEFT JOIN services s
        ON s.id = a.service_id
    WHERE a.id = ?
    LIMIT 1
");

$stmt->execute([$id]);

$appointment = $stmt->fetch();

if (!$appointment) {
    jsonError('Randevu bulunamadı', 404);
}

jsonSuccess($appointment);