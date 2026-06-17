<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/config.php';

session_start();

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    jsonError("Email ve şifre zorunlu.");
}

$pdo = getDB();

$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    jsonError("Email veya şifre yanlış.", 401);
}

if (!password_verify($password, $user['password'])) {
    jsonError("Email veya şifre yanlış.", 401);
}

/*
|--------------------------------------------------------------------------
| Session Fixation Koruması
|--------------------------------------------------------------------------
*/
session_regenerate_id(true);

/*
|--------------------------------------------------------------------------
| Admin Session
|--------------------------------------------------------------------------
*/
$_SESSION[ADMIN_SESSION_NAME] = [
    'id'            => (int)$user['id'],
    'name'          => $user['name'],
    'role'          => $user['role'],
    'login_time'    => time(),
    'last_activity' => time(),
    'ip'            => $_SERVER['REMOTE_ADDR'] ?? '',
    'user_agent'    => $_SERVER['HTTP_USER_AGENT'] ?? ''
];

jsonSuccess([
    'id'    => (int)$user['id'],
    'name'  => $user['name'],
    'email' => $user['email'],
    'role'  => $user['role']
], 'Giriş başarılı.');