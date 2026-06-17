<?php

require_once __DIR__ . '/config.php';

session_start();

header('Content-Type: application/json; charset=UTF-8');

if (empty($_SESSION[ADMIN_SESSION_NAME])) {
    http_response_code(401);

    echo json_encode([
        'success' => false,
        'message' => 'Yetkisiz erişim'
    ]);

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

    http_response_code(401);

    echo json_encode([
        'success' => false,
        'message' => 'Oturum süresi doldu'
    ]);

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

    http_response_code(401);

    echo json_encode([
        'success' => false,
        'message' => 'Oturum doğrulanamadı'
    ]);

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

    http_response_code(401);

    echo json_encode([
        'success' => false,
        'message' => 'Oturum doğrulanamadı'
    ]);

    exit;
}

/*
|--------------------------------------------------------------------------
| Aktivite Süresini Güncelle
|--------------------------------------------------------------------------
*/
$_SESSION[ADMIN_SESSION_NAME]['last_activity'] = time();