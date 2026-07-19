<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include '../includes/header.php';
include '../includes/navbar.php';

$sql = "
SELECT
products.product_name,
categories.category_name,
products.price,
products.stock
FROM products
INNER JOIN categories
ON products.category_id = categories.id
ORDER BY categories.category_name, products.product_name
";

$stmt = $pdo->query($sql);
?>

<div class="container mt-4">

<h2>Inventory Report</h2>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>Product</th>
<th>Category</th>
<th>Price</th>
<th>Stock Remaining</th>

</tr>

</thead>

<tbody>

<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>

<tr>

<td><?= htmlspecialchars($row['product_name']); ?></td>

<td><?= htmlspecialchars($row['category_name']); ?></td>

<td>₱<?= number_format($row['price'],2); ?></td>

<td><?= $row['stock']; ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include '../includes/footer.php'; ?>