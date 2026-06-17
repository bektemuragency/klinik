<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';

$pdo = getDB();

$stmt = $pdo->query("
    SELECT *
    FROM services
    WHERE is_active = 1
    ORDER BY sort_order ASC, id DESC
");

$services = $stmt->fetchAll();

jsonSuccess($services);