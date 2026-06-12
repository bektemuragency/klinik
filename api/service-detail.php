<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';

$pdo = getDB();

$slug = $_GET['slug'] ?? null;

if (!$slug) {
    jsonError("Slug gerekli");
}

$stmt = $pdo->prepare("SELECT * FROM services WHERE slug = ?");
$stmt->execute([$slug]);

$service = $stmt->fetch();

if (!$service) {
    jsonError("Hizmet bulunamadı", 404);
}

jsonSuccess($service);