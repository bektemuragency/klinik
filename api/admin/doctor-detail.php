<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';

$pdo = getDB();

$id = $_GET['id'] ?? null;

if (!$id) {
    jsonError("ID gerekli");
}

$stmt = $pdo->prepare("SELECT id, name, title, specialty, bio, image, phone, email FROM doctors WHERE id = ?");
$stmt->execute([$id]);

$doctor = $stmt->fetch();

if (!$doctor) {
    jsonError("Doktor bulunamadı", 404);
}

jsonSuccess($doctor);