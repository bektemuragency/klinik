<?php
$config = require __DIR__ . '/config.php';

$colors = $config['colors'];
$components = $config['components'];
$font = $config['font'];
$spacing = $config['spacing'];
?>

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