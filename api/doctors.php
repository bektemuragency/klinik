<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';

$pdo = getDB();

$stmt = $pdo->query("SELECT id, name, title, specialty, bio, image, phone, email FROM doctors ORDER BY id DESC");
$doctors = $stmt->fetchAll();

jsonSuccess($doctors);