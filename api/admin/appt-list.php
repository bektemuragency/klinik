<?php

require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$pdo = getDB();

/*
========================
STATS MODE
========================
*/
if (isset($_GET['stats'])) {
    $total = $pdo->query("SELECT COUNT(*) FROM appointments")->fetchColumn();
    $pending = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'pending'")->fetchColumn();
    $confirmed = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'confirmed'")->fetchColumn();
    $cancelled = $pdo->query("SELECT COUNT(*) FROM appointments WHERE status = 'cancelled'")->fetchColumn();

    jsonSuccess([
        "total" => (int)$total,
        "pending" => (int)$pending,
        "confirmed" => (int)$confirmed,
        "cancelled" => (int)$cancelled
    ]);
}

/*
========================
PAGINATION
========================
*/
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = (int)($_GET['per_page'] ?? 10);

if ($perPage < 1) {
    $perPage = 10;
}

if ($perPage > 50) {
    $perPage = 50;
}

$offset = ($page - 1) * $perPage;

/*
========================
FILTERS
========================
*/
$q = trim($_GET['q'] ?? '');
$status = trim($_GET['status'] ?? '');
$dateFrom = trim($_GET['date_from'] ?? '');
$dateTo = trim($_GET['date_to'] ?? '');

$where = [];
$params = [];

if ($q !== '') {
    $where[] = "(
        a.full_name LIKE :q_full_name
        OR a.phone LIKE :q_phone
        OR a.email LIKE :q_email
        OR a.message LIKE :q_message
        OR a.admin_note LIKE :q_admin_note
        OR s.title LIKE :q_service
    )";

    $likeQ = '%' . $q . '%';

    $params[':q_full_name'] = $likeQ;
    $params[':q_phone'] = $likeQ;
    $params[':q_email'] = $likeQ;
    $params[':q_message'] = $likeQ;
    $params[':q_admin_note'] = $likeQ;
    $params[':q_service'] = $likeQ;
}

if ($status !== '') {
    $allowedStatuses = ['pending', 'confirmed', 'cancelled'];

    if (in_array($status, $allowedStatuses, true)) {
        $where[] = "a.status = :status";
        $params[':status'] = $status;
    }
}

if ($dateFrom !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateFrom)) {
    $where[] = "a.appointment_date >= :date_from";
    $params[':date_from'] = $dateFrom;
}

if ($dateTo !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $dateTo)) {
    $where[] = "a.appointment_date <= :date_to";
    $params[':date_to'] = $dateTo;
}

$whereSql = '';

if (!empty($where)) {
    $whereSql = 'WHERE ' . implode(' AND ', $where);
}

/*
========================
COUNT
========================
*/
try {
    $countSql = "
        SELECT COUNT(*)
        FROM appointments a
        LEFT JOIN services s
            ON s.id = a.service_id
        $whereSql
    ";

    $countStmt = $pdo->prepare($countSql);

    foreach ($params as $key => $value) {
        $countStmt->bindValue($key, $value);
    }

    $countStmt->execute();

    $total = (int)$countStmt->fetchColumn();
    $totalPages = max(1, (int)ceil($total / $perPage));

    /*
    ========================
    LIST
    ========================
    */
    $listSql = "
        SELECT
            a.id,
            a.full_name,
            a.phone,
            a.email,
            a.service_id,
            s.title AS service_title,
            a.appointment_date,
            a.appointment_time,
            a.message,
            a.admin_note,
            a.status,
            a.ip_address,
            a.created_at,
            a.updated_at
        FROM appointments a
        LEFT JOIN services s
            ON s.id = a.service_id
        $whereSql
        ORDER BY a.id DESC
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($listSql);

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

    $stmt->execute();

    $data = $stmt->fetchAll();

    jsonSuccess([
        'items' => $data,
        'pagination' => [
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages
        ]
    ]);

} catch (Exception $e) {
    jsonError("Randevular listelenirken hata oluştu", 500);
}