<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$pdo = getDB();

/*
|--------------------------------------------------------------------------
| PAGINATION MODE
|--------------------------------------------------------------------------
*/
if (isset($_GET['page'])) {
    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = (int)($_GET['per_page'] ?? 4);

    if ($perPage < 1) {
        $perPage = 4;
    }

    if ($perPage > 50) {
        $perPage = 50;
    }

    $offset = ($page - 1) * $perPage;

    $total = (int)$pdo->query("SELECT COUNT(*) FROM doctors")->fetchColumn();
    $totalPages = max(1, (int)ceil($total / $perPage));

    $stmt = $pdo->prepare("
        SELECT *
        FROM doctors
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset
    ");

    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $doctors = $stmt->fetchAll();

    jsonSuccess([
        'items' => $doctors,
        'pagination' => [
            'page' => $page,
            'per_page' => $perPage,
            'total' => $total,
            'total_pages' => $totalPages
        ]
    ]);
}

/*
|--------------------------------------------------------------------------
| DEFAULT MODE
|--------------------------------------------------------------------------
*/
$stmt = $pdo->query("SELECT * FROM doctors ORDER BY id DESC");
$doctors = $stmt->fetchAll();

jsonSuccess($doctors);