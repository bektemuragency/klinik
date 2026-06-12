<?php
require_once __DIR__ . '/config.php';

session_start();

if (empty($_SESSION[ADMIN_SESSION_NAME])) {
    http_response_code(401);
    echo json_encode([
        "success" => false,
        "message" => "Yetkisiz erişim"
    ]);
    exit;
}