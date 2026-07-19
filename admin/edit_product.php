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

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found.");
}

$catStmt = $pdo->query("SELECT * FROM categories ORDER BY category_name ASC");
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $category_id = $_POST["category_id"];
    $product_name = trim($_POST["product_name"]);
    $description = trim($_POST["description"]);
    $price = $_POST["price"];
    $stock = $_POST["stock"];
    $image = trim($_POST["image"]);

    $update = $pdo->prepare("
        UPDATE products
        SET
            category_id=?,
            product_name=?,
            description=?,
            price=?,
            stock=?,
            image=?
        WHERE id=?
    ");

    $update->execute([
        $category_id,
        $product_name,
        $description,
        $price,
        $stock,
        $image,
        $id
    ]);

    // Audit Log
    $activity = "Edited product: " . $product_name;

    $log = $pdo->prepare("
        INSERT INTO audit_logs(user_id,activity)
        VALUES(?,?)
    ");

    $log->execute([
        $_SESSION['user_id'],
        $activity
    ]);

    header("Location: products.php");
    exit();
}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

<div class="row justify-content-center">

<div class="col-md-8">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Edit Product</h3>

</div>

<div class="card-body">

<form method="POST">

<div class="mb-3">

<label>Category</label>

<select
name="category_id"
class="form-select">

<?php foreach($categories as $category): ?>

<option
value="<?= $category['id']; ?>"
<?= $category['id']==$product['category_id'] ? 'selected' : ''; ?>>

<?= $category['category_name']; ?>

</option>

<?php endforeach; ?>

</select>

</div>

<div class="mb-3">

<label>Product Name</label>

<input
type="text"
name="product_name"
class="form-control"
value="<?= htmlspecialchars($product['product_name']); ?>">

</div>

<div class="mb-3">

<label>Description</label>

<textarea
name="description"
class="form-control"
rows="4"><?= htmlspecialchars($product['description']); ?></textarea>

</div>

<div class="row">

<div class="col">

<label>Price</label>

<input
type="number"
step="0.01"
name="price"
class="form-control"
value="<?= $product['price']; ?>">

</div>

<div class="col">

<label>Stock</label>

<input
type="number"
name="stock"
class="form-control"
value="<?= $product['stock']; ?>">

</div>

</div>

<div class="mt-3">

<label>Image Filename</label>

<input
type="text"
name="image"
class="form-control"
value="<?= htmlspecialchars($product['image']); ?>">

</div>

<br>

<button class="btn btn-warning">

Update Product

</button>

<a
href="products.php"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

</div>

</div>

<?php include '../includes/footer.php'; ?>