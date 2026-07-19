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
    products.*,
    categories.category_name
FROM products
INNER JOIN categories
ON products.category_id = categories.id
ORDER BY products.id ASC
";

$stmt = $pdo->query($sql);
?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h2>Manage Products</h2>

        <a href="add_product.php" class="btn btn-success">
            + Add Product
        </a>

    </div>

    <table class="table table-hover table-bordered align-middle shadow-sm">

        <thead class="table-dark">

        <tr>

            <th>ID</th>
            <th>Image</th>
            <th>Product</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th width="170">Actions</th>

        </tr>

        </thead>

        <tbody>

        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>

            <tr>

                <td><?= $row['id']; ?></td>

                <td>

                    <img
                        src="../assets/images/products/<?= $row['image']; ?>"
                        width="80">

                </td>

                <td><?= htmlspecialchars($row['product_name']); ?></td>

                <td><?= htmlspecialchars($row['category_name']); ?></td>

                <td>₱<?= number_format($row['price'],2); ?></td>

                <td><?= $row['stock']; ?></td>

                <td>

                    <a
                        href="edit_product.php?id=<?= $row['id']; ?>"
                        class="btn btn-warning btn-sm">

                        Edit

                    </a>

                    <a
                        href="delete_product.php?id=<?= $row['id']; ?>"
                        class="btn btn-danger btn-sm">

                        Delete

                    </a>

                </td>

            </tr>

        <?php endwhile; ?>

        </tbody>

    </table>

</div>

<?php include '../includes/footer.php'; ?>