<?php
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

/*
|--------------------------------------------------------------------------
| CSRF Kontrolü
|--------------------------------------------------------------------------
*/
verifyCsrf();

// session içini tamamen temizle
$_SESSION = [];

// session cookie sil
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();

    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// session destroy
session_destroy();

jsonSuccess(null, "Çıkış yapıldı");