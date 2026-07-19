<?php
require_once '../config/database.php';
require_once '../config/session.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

/* Change Role */
if (isset($_GET['promote'])) {

    $id = $_GET['promote'];

    $stmt = $pdo->prepare("
        UPDATE users
        SET role='admin'
        WHERE id=?
    ");

    $stmt->execute([$id]);

    // Audit Log
    $activity = "Promoted user ID $id to Admin";
    $log = $pdo->prepare("
        INSERT INTO audit_logs(user_id,activity)
        VALUES(?,?)
    ");
    $log->execute([$_SESSION['user_id'],$activity]);

    header("Location: users.php");
    exit();
}

if (isset($_GET['demote'])) {

    $id = $_GET['demote'];

    /* Prevent admin from demoting themselves */
    if ($id != $_SESSION['user_id']) {

        $stmt = $pdo->prepare("
            UPDATE users
            SET role='buyer'
            WHERE id=?
        ");

        $stmt->execute([$id]);

        // Audit Log
        $activity = "Changed user ID $id to Buyer";
        $log = $pdo->prepare("
            INSERT INTO audit_logs(user_id,activity)
            VALUES(?,?)
        ");
        $log->execute([$_SESSION['user_id'],$activity]);
    }

    header("Location: users.php");
    exit();
}

$users = $pdo->query("
    SELECT *
    FROM users
    ORDER BY id ASC
");

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-4">

<h2>User Management</h2>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($user = $users->fetch(PDO::FETCH_ASSOC)): ?>

<tr>

<td><?= $user['id']; ?></td>

<td><?= htmlspecialchars($user['fullname']); ?></td>

<td><?= htmlspecialchars($user['email']); ?></td>

<td>

<?php if($user['role']=="admin"): ?>

<span class="badge bg-success">

Admin

</span>

<?php else: ?>

<span class="badge bg-secondary">

Buyer

</span>

<?php endif; ?>

</td>

<td>

<?php if($user['role']=="buyer"): ?>

<a
href="users.php?promote=<?= $user['id']; ?>"
class="btn btn-success btn-sm">

Make Admin

</a>

<?php elseif($user['id'] != $_SESSION['user_id']): ?>

<a
href="users.php?demote=<?= $user['id']; ?>"
class="btn btn-warning btn-sm">

Make Buyer

</a>

<?php else: ?>

<span class="text-muted">

Current User

</span>

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include '../includes/footer.php'; ?>