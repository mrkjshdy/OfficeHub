<?php
require_once '../config/session.php';

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">

<div class="alert alert-success">

<h2>🎉 Order Successful!</h2>

<p>

Your order has been placed successfully.

</p>

<p>

Payment Method:

<strong>Cash on Delivery</strong>

</p>

<a
href="store.php"
class="btn btn-primary">

Continue Shopping

</a>

</div>

</div>

<?php include '../includes/footer.php'; ?>