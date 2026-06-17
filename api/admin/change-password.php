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

$admin = $_SESSION[ADMIN_SESSION_NAME] ?? null;

if (!$admin || empty($admin['id'])) {
    jsonError("Yetkisiz erişim", 401);
}

$userId = (int)$admin['id'];

$currentPassword = $_POST['current_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';
$newPasswordConfirm = $_POST['new_password_confirm'] ?? '';

if (!$currentPassword || !$newPassword || !$newPasswordConfirm) {
    jsonError("Tüm alanlar zorunlu");
}

if ($newPassword !== $newPasswordConfirm) {
    jsonError("Yeni şifreler eşleşmiyor");
}

if (strlen($newPassword) < 8) {
    jsonError("Yeni şifre en az 8 karakter olmalı");
}

if ($currentPassword === $newPassword) {
    jsonError("Yeni şifre mevcut şifre ile aynı olamaz");
}

$stmt = $pdo->prepare("SELECT id, password FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$userId]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    jsonError("Kullanıcı bulunamadı", 404);
}

if (!password_verify($currentPassword, $user['password'])) {
    jsonError("Mevcut şifre yanlış", 401);
}

$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
$stmt->execute([$newHash, $userId]);

jsonSuccess(null, "Şifre başarıyla güncellendi");