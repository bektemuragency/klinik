<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/config.php';

session_start();

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    jsonError("Email ve şifre zorunlu.");
}

$pdo = getDB();

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    jsonError("Email veya şifre yanlış.", 401);
}

if (!password_verify($password, $user['password'])) {
    jsonError("Email veya şifre yanlış.", 401);
}

// SESSION BAS
$_SESSION[ADMIN_SESSION_NAME] = [
    "id" => $user['id'],
    "name" => $user['name'],
    "role" => $user['role']
];

jsonSuccess([
    "id" => $user['id'],
    "name" => $user['name'],
    "email" => $user['email'],
    "role" => $user['role']
], "Giriş başarılı.");