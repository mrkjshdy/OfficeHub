<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$message = "";

// Get categories for the dropdown
$catStmt = $pdo->query("SELECT id, category_name FROM categories ORDER BY category_name ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST["category_id"] ?? "";
    $product_name = trim($_POST["product_name"] ?? "");
    $description = trim($_POST["description"] ?? "");
    $price = $_POST["price"] ?? "";
    $stock = $_POST["stock"] ?? "";
    $image = trim($_POST["image"] ?? "");

    if (
        empty($category_id) ||
        empty($product_name) ||
        empty($description) ||
        empty($price) ||
        empty($stock) ||
        empty($image)
    ) {
        $message = '<div class="alert alert-danger">Please complete all fields.</div>';
    } else {
        $stmt = $pdo->prepare("
            INSERT INTO products (category_id, product_name, description, price, stock, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $category_id,
            $product_name,
            $description,
            $price,
            $stock,
            $image
        ]);

        // Audit log
        $activity = "Added product: " . $product_name;
        $logStmt = $pdo->prepare("INSERT INTO audit_logs (user_id, activity) VALUES (?, ?)");
        $logStmt->execute([$_SESSION['user_id'], $activity]);

        header("Location: products.php?added=1");
        exit();
    }
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Add Product</h3>
                </div>

                <div class="card-body">
                    <?= $message ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id']; ?>">
                                        <?= htmlspecialchars($category['category_name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price</label>
                                <input type="number" step="0.01" name="price" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image Filename</label>
                            <input type="text" name="image" class="form-control" placeholder="example.jpg" required>
                            <small class="text-muted">
                                Type the exact filename already saved in <code>assets/images/products</code>.
                            </small>
                        </div>

                        <button type="submit" class="btn btn-success">Save Product</button>
                        <a href="products.php" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>