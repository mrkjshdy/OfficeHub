<?php

require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: products.php");
    exit();
}

$id = $_GET['id'];

/* Get product first (for audit log) */
$stmt = $pdo->prepare("SELECT product_name FROM products WHERE id=?");
$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product) {

    // Audit Log
    $activity = "Deleted product: " . $product['product_name'];

    $log = $pdo->prepare("
        INSERT INTO audit_logs(user_id,activity)
        VALUES(?,?)
    ");

    $log->execute([
        $_SESSION['user_id'],
        $activity
    ]);

    // Delete product
    $delete = $pdo->prepare("
        DELETE FROM products
        WHERE id=?
    ");

    $delete->execute([$id]);
}

header("Location: products.php");
exit();

?>