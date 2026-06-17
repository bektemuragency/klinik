<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/response.php';
require_once __DIR__ . '/../../includes/admin_guard.php';

$pdo = getDB();

/*
|--------------------------------------------------------------------------
| PAGINATION MODE
| page parametresi varsa sayfalı döner.
| Yoksa eski sistem gibi tüm hizmetleri döner.
|--------------------------------------------------------------------------
*/
if (isset($_GET['page'])) {
    $page = max(1, (int)($_GET['page'] ?? 1));
    $perPage = (int)($_GET['per_page'] ?? 5);

    if ($perPage < 1) {
        $perPage = 5;
    }

    if ($perPage > 50) {
        $perPage = 50;
    }

    $offset = ($page - 1) * $perPage;

    $total = (int)$pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
    $totalPages = max(1, (int)ceil($total / $perPage));

    $stmt = $pdo->prepare("
        SELECT *
        FROM services
        ORDER BY id DESC
        LIMIT :limit OFFSET :offset
    ");

    $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    $services = $stmt->fetchAll();

    jsonSuccess([
        'items' => $services,
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
| Edit sayfaları bozulmasın diye eski gibi tüm veriyi döndürür.
|--------------------------------------------------------------------------
*/
$stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
$services = $stmt->fetchAll();

jsonSuccess($services);