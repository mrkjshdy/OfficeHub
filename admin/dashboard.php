<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$categoryCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();
$orderCount = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

    <h2 class="mb-2">Admin Dashboard</h2>

    <p class="text-muted mb-4">
        Welcome back,
        <strong><?= htmlspecialchars($_SESSION['fullname']); ?></strong>
    </p>

    <div class="row">

        <div class="col-md-3 mb-4">

            <div class="card text-white bg-primary shadow-lg border-0 h-100">

                <div class="card-body text-center">

                    <h1 class="display-4 fw-bold"><?= $productCount; ?></h1>

                    <h5 class="mb-0">Products</h5>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card text-white bg-success shadow-lg border-0 h-100">

                <div class="card-body text-center">

                    <h1 class="display-4 fw-bold"><?= $userCount; ?></h1>

                    <h5 class="mb-0">Users</h5>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card text-white bg-warning shadow-lg border-0 h-100">

                <div class="card-body text-center">

                    <h1 class="display-4 fw-bold"><?= $categoryCount; ?></h1>

                    <h5 class="mb-0">Categories</h5>

                </div>

            </div>

        </div>

        <div class="col-md-3 mb-4">

            <div class="card text-white bg-danger shadow-lg border-0 h-100">

                <div class="card-body text-center">

                    <h1 class="display-4 fw-bold"><?= $orderCount; ?></h1>

                    <h5 class="mb-0">Orders</h5>

                </div>

            </div>

        </div>

    </div>

    <hr>

    <div class="row mt-4">

        <div class="col-md-3 d-grid mb-3">

            <a href="products.php" class="btn btn-primary">
                Manage Products
            </a>

        </div>

        <div class="col-md-3 d-grid mb-3">

            <a href="users.php" class="btn btn-success">
                Manage Users
            </a>

        </div>

        <div class="col-md-3 d-grid mb-3">

            <a href="inventory.php" class="btn btn-warning">
                Inventory Report
            </a>

        </div>

        <div class="col-md-3 d-grid mb-3">

            <a href="audit_logs.php" class="btn btn-dark">
                Audit Logs
            </a>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>