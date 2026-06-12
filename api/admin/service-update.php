<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/functions.php';

$pdo = getDB();

$id = $_POST['id'] ?? null;
$title = clean($_POST['title'] ?? '');
$description = clean($_POST['description'] ?? '');

if (!$id || !$title) {
    jsonError("Eksik veri");
}

$slug = toSlug($title);

$stmt = $pdo->prepare("
    UPDATE services
    SET title=?, description=?, slug=?
    WHERE id=?
");

$stmt->execute([$title, $description, $slug, $id]);

jsonSuccess(null, "Güncellendi");