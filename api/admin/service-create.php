<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/functions.php';

$pdo = getDB();

$title = clean($_POST['title'] ?? '');
$description = clean($_POST['description'] ?? '');

if (!$title) {
    jsonError("Başlık zorunlu");
}

$slug = toSlug($title);

$stmt = $pdo->prepare("
    INSERT INTO services (title, description, slug, created_at)
    VALUES (?, ?, ?, NOW())
");

$stmt->execute([$title, $description, $slug]);

jsonSuccess(null, "Hizmet eklendi");