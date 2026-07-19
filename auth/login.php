<?php
require_once '../config/database.php';
require_once '../config/session.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $pdo->prepare("
        SELECT *
        FROM users
        WHERE email = ?
    ");

    $stmt->execute([$email]);

    if ($stmt->rowCount() == 1) {

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($password, $user['password'])) {

            /* Check Email Verification */

            if ($user['is_verified'] == 0) {

                $message = '
                <div class="alert alert-warning">

                    Your email has not yet been verified.

                    <br><br>

                    Please check your inbox and verify your account
                    before logging in.

                </div>';

            } else {

                /* Login */

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];

                /* Audit Log */

                $activity = "Logged into the system";

                $log = $pdo->prepare("
                    INSERT INTO audit_logs
                    (user_id, activity)
                    VALUES (?, ?)
                ");

                $log->execute([
                    $user['id'],
                    $activity
                ]);

                if ($user['role'] == 'admin') {

                    header("Location: ../admin/dashboard.php");
                    exit();

                } else {

                    header("Location: ../buyer/store.php");
                    exit();

                }

            }

        } else {

            $message = '
            <div class="alert alert-danger">

                Incorrect password.

            </div>';

        }

    } else {

        $message = '
        <div class="alert alert-danger">

            Email not found.

        </div>';

    }

}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h3 class="mb-0">Login</h3>

                </div>

                <div class="card-body">

                    <?= $message ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label>Email Address</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                required>

                        </div>

                        <div class="mb-3">

                            <label>Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>

                        </div>

                        <button
                            class="btn btn-primary w-100">

                            Login

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
include '../includes/footer.php';
?>