<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';

$pdo = getDB();

$id = $_POST['id'] ?? null;

if (!$id) {
    jsonError("ID gerekli");
}

$stmt = $pdo->prepare("DELETE FROM doctors WHERE id = ?");
$stmt->execute([$id]);

jsonSuccess(null, "Silindi");