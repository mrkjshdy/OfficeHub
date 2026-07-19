<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id'])) {
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

    <h2 class="mb-4">Office Equipment Store</h2>

    <p class="text-muted">
    Welcome,
    <strong><?= htmlspecialchars($_SESSION['fullname']); ?></strong>!
    </p>

    <div class="row">

        <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>

            <div class="col-md-4 mb-4">

                <div class="card h-100 shadow-lg border-0">

                    <img
                        src="../assets/images/products/<?= htmlspecialchars($row['image']); ?>"
                        class="card-img-top"
                        style="height:250px; object-fit:contain; padding:20px;"
                        alt="<?= htmlspecialchars($row['product_name']); ?>">

                    <div class="card-body">

                        <h5 class="fw-bold">
                            <?= htmlspecialchars($row['product_name']); ?>
                        </h5>

                        <span class="badge bg-secondary mb-2">
                            <?= htmlspecialchars($row['category_name']); ?>
                        </span> 

                        <p>
                            <?= htmlspecialchars($row['description']); ?>
                        </p>

                        <h4 class="text-primary fw-bold">
                            ₱<?= number_format($row['price'],2); ?>
                        </h4>

                        <p>
                            <strong>Stock:</strong>
                            <?= $row['stock']; ?>
                        </p>

                        <form action="cart.php" method="GET">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $row['id']; ?>">

                            <button
                                type="submit"
                                class="btn btn-primary w-100">

                                Add to Cart

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        <?php endwhile; ?>

    </div>

</div>

<?php include '../includes/footer.php'; ?>