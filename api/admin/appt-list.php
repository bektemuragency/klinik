<?php

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';

$pdo = getDB();

/*
========================
STATS MODE
========================
*/
if (isset($_GET['stats'])) {

    $total = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
    $pending = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='pending'")->fetchColumn();
    $confirmed = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='confirmed'")->fetchColumn();
    $cancelled = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status='cancelled'")->fetchColumn();

    jsonSuccess([
        "total" => (int)$total,
        "pending" => (int)$pending,
        "confirmed" => (int)$confirmed,
        "cancelled" => (int)$cancelled
    ]);
}

/*
========================
LIST MODE
========================
*/
$stmt = $pdo->query("
    SELECT 
        id,
        full_name,
        phone,
        email,
        service_id,
        appointment_date,
        appointment_time,
        status,
        admin_note,
        created_at,
        updated_at
    FROM appointments
    ORDER BY id DESC
");

$data = $stmt->fetchAll();

jsonSuccess($data);