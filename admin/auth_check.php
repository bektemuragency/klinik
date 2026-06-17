<?php

require_once __DIR__ . '/../includes/config.php';

/*
|--------------------------------------------------------------------------
| Session Security
|--------------------------------------------------------------------------
*/
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

/*
|--------------------------------------------------------------------------
| Login Kontrolü
|--------------------------------------------------------------------------
*/
if (empty($_SESSION[ADMIN_SESSION_NAME])) {
    header("Location: index.php");
    exit;
}

$admin = $_SESSION[ADMIN_SESSION_NAME];

/*
|--------------------------------------------------------------------------
| Session Timeout (2 Saat)
|--------------------------------------------------------------------------
*/
if (
    !isset($admin['last_activity']) ||
    (time() - $admin['last_activity']) > 7200
) {
    session_unset();
    session_destroy();

    header("Location: index.php?timeout=1");
    exit;
}

/*
|--------------------------------------------------------------------------
| IP Kontrolü
|--------------------------------------------------------------------------
*/
if (
    isset($admin['ip']) &&
    $admin['ip'] !== ($_SERVER['REMOTE_ADDR'] ?? '')
) {
    session_unset();
    session_destroy();

    header("Location: index.php?session_invalid=1");
    exit;
}

/*
|--------------------------------------------------------------------------
| User Agent Kontrolü
|--------------------------------------------------------------------------
*/
if (
    isset($admin['user_agent']) &&
    $admin['user_agent'] !== ($_SERVER['HTTP_USER_AGENT'] ?? '')
) {
    session_unset();
    session_destroy();

    header("Location: index.php?session_invalid=1");
    exit;
}

/*
|--------------------------------------------------------------------------
| Aktivite Süresini Güncelle
|--------------------------------------------------------------------------
*/
$_SESSION[ADMIN_SESSION_NAME]['last_activity'] = time();