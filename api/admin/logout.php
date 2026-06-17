<?php
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/functions.php';
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/activity_log.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonError("Geçersiz istek metodu", 405);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| CSRF Kontrolü
|--------------------------------------------------------------------------
*/
verifyCsrf();

$adminBeforeLogout = $_SESSION[ADMIN_SESSION_NAME] ?? null;

/*
|--------------------------------------------------------------------------
| Activity Log
|--------------------------------------------------------------------------
*/
if ($adminBeforeLogout && isset($adminBeforeLogout['id'])) {
    $pdo = getDB();

    logActivity(
        $pdo,
        'logout',
        'user',
        (int)$adminBeforeLogout['id'],
        null,
        [
            'id' => (int)$adminBeforeLogout['id'],
            'name' => $adminBeforeLogout['name'] ?? null,
            'role' => $adminBeforeLogout['role'] ?? null
        ],
        (int)$adminBeforeLogout['id']
    );
}

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