<?php
require_once __DIR__ . '/../config/session.php';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">

    <div class="container">

        <a class="navbar-brand fw-bold" href="/index.php">
            OfficeHub
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <?php if (!isset($_SESSION['user_id'])): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/about.php">About</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/auth/login.php">Login</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/auth/register.php">Register</a>
                    </li>

                <?php elseif ($_SESSION['role'] == 'admin'): ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/dashboard.php">Dashboard</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/products.php">Products</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/users.php">Users</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/inventory.php">Inventory</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/admin/audit_logs.php">Audit Logs</a>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link fw-bold text-info">
                            👤 <?= htmlspecialchars($_SESSION['fullname']); ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/auth/logout.php">Logout</a>
                    </li>

                <?php else: ?>

                    <li class="nav-item">
                        <a class="nav-link" href="/index.php">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/buyer/store.php">Store</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/buyer/cart.php">Cart</a>
                    </li>

                    <li class="nav-item">
                        <span class="nav-link fw-bold text-info">
                        👤 <?= htmlspecialchars($_SESSION['fullname']); ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/auth/logout.php">Logout</a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>