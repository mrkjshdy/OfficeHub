<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Get user information */
$userStmt = $pdo->prepare("SELECT fullname, address FROM users WHERE id = ?");
$userStmt->execute([$user_id]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

/* Compute cart total */
$totalStmt = $pdo->prepare("
SELECT SUM(products.price * cart.quantity) AS total
FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.user_id = ?
");
$totalStmt->execute([$user_id]);
$total = $totalStmt->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Create Order
    $insertOrder = $pdo->prepare("
    INSERT INTO orders(user_id,total,status,payment_method)
    VALUES(?,?,?,?)
    ");

    $insertOrder->execute([
        $user_id,
        $total,
        'Pending',
        'Cash on Delivery'
    ]);

    $order_id = $pdo->lastInsertId();

    // Copy cart items into order_items
    $cartStmt = $pdo->prepare("
    SELECT cart.*, products.price
    FROM cart
    INNER JOIN products
    ON cart.product_id = products.id
    WHERE cart.user_id = ?
    ");
    $cartStmt->execute([$user_id]);

    while($item = $cartStmt->fetch(PDO::FETCH_ASSOC)){

        $subtotal = $item['price'] * $item['quantity'];

        $insertItem = $pdo->prepare("
        INSERT INTO order_items
        (order_id,product_id,quantity,price,subtotal)
        VALUES(?,?,?,?,?)
        ");

        $insertItem->execute([
            $order_id,
            $item['product_id'],
            $item['quantity'],
            $item['price'],
            $subtotal
        ]);
    }

    // Clear cart
    $clear = $pdo->prepare("DELETE FROM cart WHERE user_id=?");
    $clear->execute([$user_id]);

    header("Location: payment.php");
    exit();
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

<h2>Checkout</h2>

<div class="card p-4">

<p><strong>Name:</strong> <?= htmlspecialchars($user['fullname']); ?></p>

<p><strong>Shipping Address:</strong> <?= htmlspecialchars($user['address']); ?></p>

<p><strong>Payment Method:</strong> Cash on Delivery</p>

<h4>Total: ₱<?= number_format($total,2); ?></h4>

<form method="POST">

<button class="btn btn-success">

Place Order

</button>

</form>

</div>

</div>

<?php include '../includes/footer.php'; ?>