<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$pdo = getDB();

$stmt = $pdo->query("SELECT * FROM doctors ORDER BY id DESC");
$doctors = $stmt->fetchAll();

jsonSuccess($doctors);