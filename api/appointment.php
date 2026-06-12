<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDB();

// sadece POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Sadece POST desteklenir", 405);
}

// inputlar
$full_name = clean($_POST['full_name'] ?? '');
$phone     = clean($_POST['phone'] ?? '');
$email     = clean($_POST['email'] ?? '');
$service_id = $_POST['service_id'] ?? null;
$date      = $_POST['date'] ?? null;
$time      = $_POST['time'] ?? null;
$message   = clean($_POST['message'] ?? '');

// validation
if (!$full_name || !$phone || !$service_id || !$date || !$time) {
    jsonError("Zorunlu alanlar eksik");
}

// telefon basic kontrol
if (strlen($phone) < 10) {
    jsonError("Telefon geçersiz");
}

// tarih geçmiş mi kontrol (basit)
if (strtotime($date) < strtotime(date("Y-m-d"))) {
    jsonError("Geçmiş tarih seçilemez");
}

try {

    $stmt = $pdo->prepare("
        INSERT INTO appointments
        (full_name, phone, email, service_id, date, time, message, status, created_at)
        VALUES
        (:full_name, :phone, :email, :service_id, :date, :time, :message, 'pending', NOW())
    ");

    $stmt->execute([
        ':full_name' => $full_name,
        ':phone' => $phone,
        ':email' => $email,
        ':service_id' => $service_id,
        ':date' => $date,
        ':time' => $time,
        ':message' => $message
    ]);

    jsonSuccess(null, "Randevu oluşturuldu");

} catch (Exception $e) {
    jsonError("DB hatası: " . $e->getMessage(), 500);
}