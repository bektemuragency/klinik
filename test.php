<?php

require_once __DIR__ . '/includes/db.php';

try {
    $db = getDB();

    $stmt = $db->prepare("SELECT name FROM users WHERE id = :id");
    $stmt->execute([
        'id' => 1
    ]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    echo $user['name'];

} catch (Exception $e) {
    echo $e->getMessage();
}