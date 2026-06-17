<?php

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';
require_once __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

verifyCsrf();

$pdo = getDB();

$full_name = clean($_POST['full_name'] ?? '');
$phone = clean($_POST['phone'] ?? '');
$email = clean($_POST['email'] ?? '');
$service_id = (int)($_POST['service_id'] ?? 0);
$appointment_date = trim($_POST['appointment_date'] ?? '');
$appointment_time = trim($_POST['appointment_time'] ?? '');
$message = clean($_POST['message'] ?? '');
$status = trim($_POST['status'] ?? 'confirmed');

$allowedStatuses = ['pending', 'confirmed', 'cancelled'];

if (!$full_name || !$phone || !$service_id || !$appointment_date || !$appointment_time) {
    jsonError("Zorunlu alanlar eksik");
}

if (mb_strlen($full_name, 'UTF-8') < 3 || mb_strlen($full_name, 'UTF-8') > 100) {
    jsonError("Ad Soyad geçersiz");
}

if (!preg_match('/^[0-9+\s()-]{10,20}$/', $phone)) {
    jsonError("Telefon geçersiz");
}

if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    jsonError("Email geçersiz");
}

if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $appointment_date)) {
    jsonError("Tarih formatı geçersiz");
}

if (!preg_match('/^\d{2}:\d{2}$/', $appointment_time)) {
    jsonError("Saat formatı geçersiz");
}

if (!in_array($status, $allowedStatuses, true)) {
    jsonError("Geçersiz durum");
}

if (mb_strlen($message, 'UTF-8') > 1000) {
    jsonError("Not alanı en fazla 1000 karakter olabilir");
}

$stmt = $pdo->prepare("
    SELECT id
    FROM services
    WHERE id = ?
      AND is_active = 1
    LIMIT 1
");

$stmt->execute([$service_id]);

if (!$stmt->fetch()) {
    jsonError("Geçersiz hizmet seçimi");
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
            admin_note,
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
            :admin_note,
            :status,
            :ip_address,
            NOW()
        )
    ");

    $stmt->execute([
        ':full_name' => $full_name,
        ':phone' => $phone,
        ':email' => $email ?: null,
        ':service_id' => $service_id,
        ':appointment_date' => $appointment_date,
        ':appointment_time' => $appointment_time,
        ':message' => $message ?: null,
        ':admin_note' => 'Admin tarafından manuel oluşturuldu.',
        ':status' => $status,
        ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? null
    ]);

    jsonSuccess([
        'id' => (int)$pdo->lastInsertId()
    ], "Randevu başarıyla oluşturuldu");

} catch (Exception $e) {
    jsonError("Randevu oluşturulurken hata oluştu", 500);
}