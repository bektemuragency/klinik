<?php

require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/response.php';
require_once __DIR__ . '/../includes/functions.php';

$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Sadece POST desteklenir", 405);
}

/*
========================
SPAM HONEYPOT
========================
Formda gizli website alanı olursa bot doldurur.
Normal kullanıcı boş gönderir.
========================
*/
$honeypot = trim($_POST['website'] ?? '');

if ($honeypot !== '') {
    jsonError("İşlem reddedildi", 400);
}

/*
========================
KVKK ONAY KONTROLÜ
========================
Public randevu formunda kullanıcı açıkça onay vermeli.
========================
*/
$kvkk_consent = $_POST['kvkk_consent'] ?? '';

if ($kvkk_consent !== '1') {
    jsonError("KVKK aydınlatma metnini onaylamalısınız.");
}

/*
========================
IP / RATE LIMIT
========================
Aynı IP 10 dakikada en fazla 5 randevu oluşturabilir.
========================
*/
$ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;

if ($ipAddress) {
    $stmt = $pdo->prepare("
        SELECT COUNT(*)
        FROM appointments
        WHERE ip_address = ?
          AND created_at >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)
    ");
    $stmt->execute([$ipAddress]);

    $recentCount = (int)$stmt->fetchColumn();

    if ($recentCount >= 5) {
        jsonError("Çok fazla deneme yaptınız. Lütfen daha sonra tekrar deneyin.", 429);
    }
}

/*
========================
INPUTS
========================
*/
$full_name  = clean($_POST['full_name'] ?? '');
$phone      = clean($_POST['phone'] ?? '');
$email      = clean($_POST['email'] ?? '');
$service_id = (int)($_POST['service_id'] ?? 0);

/*
|--------------------------------------------------------------------------
| TARİH / SAAT UYUMLULUK
|--------------------------------------------------------------------------
| Eski form: date / time
| Yeni form: appointment_date / appointment_time
| İkisini de destekliyoruz.
|--------------------------------------------------------------------------
*/
$appointment_date = trim($_POST['appointment_date'] ?? ($_POST['date'] ?? ''));
$appointment_time = trim($_POST['appointment_time'] ?? ($_POST['time'] ?? ''));

/*
|--------------------------------------------------------------------------
| KULLANICI NOTU UYUMLULUK
|--------------------------------------------------------------------------
| Eski form: note
| Yeni form: message
| İkisini de destekliyoruz.
|--------------------------------------------------------------------------
*/
$message = clean($_POST['message'] ?? ($_POST['note'] ?? ''));

/*
========================
VALIDATION
========================
*/
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

if (mb_strlen($message, 'UTF-8') > 1000) {
    jsonError("Not alanı en fazla 1000 karakter olabilir");
}

$selectedDate = DateTime::createFromFormat('Y-m-d', $appointment_date);
$today = new DateTime(date('Y-m-d'));

if (!$selectedDate || $selectedDate->format('Y-m-d') !== $appointment_date) {
    jsonError("Tarih geçersiz");
}

if ($selectedDate < $today) {
    jsonError("Geçmiş tarih seçilemez");
}

/*
========================
SERVICE CHECK
Sadece aktif hizmete randevu alınabilir.
========================
*/
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

/*
========================
DUPLICATE CHECK
Aynı telefon, aynı hizmet, aynı tarih ve aynı saat için tekrar kayıt engellenir.
========================
*/
$stmt = $pdo->prepare("
    SELECT COUNT(*)
    FROM appointments
    WHERE phone = ?
      AND service_id = ?
      AND appointment_date = ?
      AND appointment_time = ?
      AND status != 'cancelled'
");
$stmt->execute([
    $phone,
    $service_id,
    $appointment_date,
    $appointment_time
]);

if ((int)$stmt->fetchColumn() > 0) {
    jsonError("Bu randevu talebi zaten oluşturulmuş görünüyor.");
}

/*
========================
INSERT
========================
*/
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
            kvkk_consent,
            kvkk_consent_at,
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
            1,
            NOW(),
            NOW()
        )
    ");

    $stmt->execute([
        ':full_name'        => $full_name,
        ':phone'            => $phone,
        ':email'            => $email ?: null,
        ':service_id'       => $service_id,
        ':appointment_date' => $appointment_date,
        ':appointment_time' => $appointment_time,
        ':message'          => $message ?: null,
        ':ip_address'       => $ipAddress
    ]);

    jsonSuccess([
        'id' => (int)$pdo->lastInsertId()
    ], "Randevu oluşturuldu");

} catch (Exception $e) {
    jsonError("Randevu oluşturulurken bir hata oluştu", 500);
}