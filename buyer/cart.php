<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ---------- REMOVE FROM CART ---------- */

if (isset($_GET['remove'])) {

    $cart_id = $_GET['remove'];

    $delete = $pdo->prepare("
        DELETE FROM cart
        WHERE id = ?
        AND user_id = ?
    ");

    $delete->execute([$cart_id, $user_id]);

    header("Location: cart.php");
    exit();
}

/* ---------- ADD TO CART ---------- */

if (isset($_GET['id'])) {

    $product_id = $_GET['id'];

    $check = $pdo->prepare("
        SELECT *
        FROM cart
        WHERE user_id = ?
        AND product_id = ?
    ");

    $check->execute([$user_id, $product_id]);

    if ($check->rowCount() > 0) {

        $update = $pdo->prepare("
            UPDATE cart
            SET quantity = quantity + 1
            WHERE user_id = ?
            AND product_id = ?
        ");

        $update->execute([$user_id, $product_id]);

    } else {

        $insert = $pdo->prepare("
            INSERT INTO cart(user_id, product_id, quantity)
            VALUES(?,?,1)
        ");

        $insert->execute([$user_id, $product_id]);
    }

    header("Location: cart.php");
    exit();
}

/* ---------- SHOW CART ---------- */

$sql = "
SELECT
cart.id,
cart.quantity,
products.product_name,
products.price,
products.image
FROM cart
INNER JOIN products
ON cart.product_id = products.id
WHERE cart.user_id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

<h2>Your Cart</h2>

<?php if($stmt->rowCount() == 0): ?>

<div class="alert alert-info">

<h4>Your cart is empty.</h4>

<a href="store.php" class="btn btn-primary">

Continue Shopping

</a>

</div>

<?php else: ?>

<table class="table table-bordered">

<tr>

<th>Image</th>
<th>Product</th>
<th>Price</th>
<th>Quantity</th>
<th>Subtotal</th>
<th>Action</th>

</tr>

<?php

$total = 0;

while($row = $stmt->fetch(PDO::FETCH_ASSOC)):

$subtotal = $row['price'] * $row['quantity'];

$total += $subtotal;

?>

<tr>

<td>

<img
src="../assets/images/products/<?= htmlspecialchars($row['image']); ?>"
width="70">

</td>

<td><?= htmlspecialchars($row['product_name']); ?></td>

<td>₱<?= number_format($row['price'],2); ?></td>

<td><?= $row['quantity']; ?></td>

<td>₱<?= number_format($subtotal,2); ?></td>

<td>

<a
href="cart.php?remove=<?= $row['id']; ?>"
class="btn btn-danger btn-sm">

Remove

</a>

</td>

</tr>

<?php endwhile; ?>

<tr>

<th colspan="5">

Total

</th>

<th>

₱<?= number_format($total,2); ?>

</th>

</tr>

</table>

<a
href="checkout.php"
class="btn btn-success">

Proceed to Checkout

</a>

<?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>