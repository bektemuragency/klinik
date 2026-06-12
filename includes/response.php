<?php
// includes/response.php
// API JSON response helper fonksiyonlari

// BASARILI RESPONSE
function jsonSuccess($data = null, $message = null, $code = 200): void {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($code);

    $out = [
        "success" => true
    ];

    // mesaj varsa ekle
    if ($message !== null) {
        $out["message"] = $message;
    }

    // data varsa ekle
    if ($data !== null) {
        $out["data"] = $data;
    }

    echo json_encode($out, JSON_UNESCAPED_UNICODE);
    exit;
}


// HATA RESPONSE
function jsonError($message, $code = 400, $errors = null): void {
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($code);

    $out = [
        "success" => false,
        "message" => $message
    ];

    // validation hatalari varsa ekle
    if ($errors !== null) {
        $out["errors"] = $errors;
    }

    echo json_encode($out, JSON_UNESCAPED_UNICODE);
    exit;
}