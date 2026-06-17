<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

verifyCsrf();

$pdo = getDB();

$id = (int)($_POST['id'] ?? 0);

if (!$id) {
    jsonError("ID gerekli");
}

$stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
$stmt->execute([$id]);

jsonSuccess(null, "Silindi");