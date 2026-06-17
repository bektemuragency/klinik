<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';

$pdo = getDB();

$stmt = $pdo->query("SELECT id, name, title, image FROM doctors ORDER BY id DESC");
$doctors = $stmt->fetchAll();

jsonSuccess($doctors);