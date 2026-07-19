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
audit_logs.*,
users.fullname
FROM audit_logs
INNER JOIN users
ON audit_logs.user_id = users.id
ORDER BY audit_logs.created_at DESC
";

$stmt = $pdo->query($sql);
?>

<div class="container mt-4">

<h2>Audit Logs</h2>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>User</th>
<th>Activity</th>
<th>Date</th>

</tr>

</thead>

<tbody>

<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>

<tr>

<td><?= htmlspecialchars($row['fullname']); ?></td>

<td><?= htmlspecialchars($row['activity']); ?></td>

<td><?= $row['created_at']; ?></td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<?php include '../includes/footer.php'; ?>