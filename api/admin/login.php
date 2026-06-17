<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/activity_log.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

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
    logActivity(
        $pdo,
        'login_failed',
        'user',
        null,
        null,
        [
            'email' => $email,
            'reason' => 'user_not_found'
        ],
        null
    );

    jsonError("Email veya şifre yanlış.", 401);
}

if (!password_verify($password, $user['password'])) {
    logActivity(
        $pdo,
        'login_failed',
        'user',
        (int)$user['id'],
        null,
        [
            'email' => $email,
            'reason' => 'invalid_password'
        ],
        null
    );

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

logActivity(
    $pdo,
    'login_success',
    'user',
    (int)$user['id'],
    null,
    [
        'email' => $user['email'],
        'name' => $user['name'],
        'role' => $user['role']
    ],
    (int)$user['id']
);

jsonSuccess([
    'id'    => (int)$user['id'],
    'name'  => $user['name'],
    'email' => $user['email'],
    'role'  => $user['role']
], 'Giriş başarılı.');