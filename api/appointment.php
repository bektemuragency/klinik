<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Sadece POST desteklenir", 405);
}

// INPUTS
$full_name  = clean($_POST['full_name'] ?? '');
$phone      = clean($_POST['phone'] ?? '');
$email      = clean($_POST['email'] ?? '');
$service_id = $_POST['service_id'] ?? null;

$appointment_date = $_POST['date'] ?? null;
$appointment_time = $_POST['time'] ?? null;

$message = clean($_POST['message'] ?? '');

// VALIDATION
if (!$full_name || !$phone || !$service_id || !$appointment_date || !$appointment_time) {
    jsonError("Zorunlu alanlar eksik");
}

if (strlen($phone) < 10) {
    jsonError("Telefon geçersiz");
}

if (strtotime($appointment_date) < strtotime(date("Y-m-d"))) {
    jsonError("Geçmiş tarih seçilemez");
}

try {

    $stmt = $pdo->prepare("
        INSERT INTO appointments
        (
            full_name,
            phone,
            email,
            service_id,
            appointment_date,
            appointment_time,
            message,
            status,
            ip_address,
            created_at
        )
        VALUES
        (
            :full_name,
            :phone,
            :email,
            :service_id,
            :appointment_date,
            :appointment_time,
            :message,
            'pending',
            :ip_address,
            NOW()
        )
    ");

    $stmt->execute([
        ':full_name' => $full_name,
        ':phone' => $phone,
        ':email' => $email,
        ':service_id' => $service_id,
        ':appointment_date' => $appointment_date,
        ':appointment_time' => $appointment_time,
        ':message' => $message,
        ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null
    ]);

    jsonSuccess(null, "Randevu oluşturuldu");

} catch (Exception $e) {
    jsonError("DB hatası: " . $e->getMessage(), 500);
}