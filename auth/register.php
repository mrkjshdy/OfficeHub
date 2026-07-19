<?php
require_once '../config/database.php';
require_once '../config/session.php';
require_once '../config/mail.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["address"]);
    $contact = trim($_POST["contact_number"]);
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    if ($password !== $confirmPassword) {

        $message = '<div class="alert alert-danger">
                        Passwords do not match.
                    </div>';

    } else {

        $check = $pdo->prepare("
            SELECT id
            FROM users
            WHERE email=?
        ");

        $check->execute([$email]);

        if($check->rowCount()>0){

            $message = '<div class="alert alert-danger">
                            Email already exists.
                        </div>';

        }else{

            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $pdo->prepare("
                INSERT INTO users
                (fullname,email,password,address,contact_number,is_verified)
                VALUES
                (?,?,?,?,?,0)
            ");

            $stmt->execute([
                $fullname,
                $email,
                $hashedPassword,
                $address,
                $contact
            ]);

            $userId = $pdo->lastInsertId();

            /* Generate Token */

            $token = bin2hex(random_bytes(32));

            $expiresAt = date(
                'Y-m-d H:i:s',
                strtotime('+1 day')
            );

            $verify = $pdo->prepare("
                INSERT INTO verification_tokens
                (user_id,token,expires_at)
                VALUES(?,?,?)
            ");

            $verify->execute([
                $userId,
                $token,
                $expiresAt
            ]);

            $verificationLink =
            "https://officehub-mark.infinityfreeapp.com/auth/verify.php?token=" .
            urlencode($token);

            /* Send Email */

            $emailSent = sendVerificationEmail(
                $email,
                $fullname,
                $verificationLink
            );

            /* Audit Log */

            $activity = "Registered a new account";

            $log = $pdo->prepare("
                INSERT INTO audit_logs
                (user_id,activity)
                VALUES(?,?)
            ");

            $log->execute([
                $userId,
                $activity
            ]);

            if($emailSent){

                $message = '
                <div class="alert alert-success">

                    Registration successful!

                    <br><br>

                    Please check your email
                    to verify your account.

                </div>';

            }else{

                $message = '
                <div class="alert alert-warning">

                    Registration successful.

                    However, the verification
                    email could not be sent.

                </div>';

            }

            $_POST = [];
        }

    }

}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h3>Create an Account</h3>

                </div>

                <div class="card-body">

                    <?= $message ?>

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">

                                Complete Name

                            </label>

                            <input
                            type="text"
                            name="fullname"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Email Address

                            </label>

                            <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Complete Address

                            </label>

                            <textarea
                            name="address"
                            class="form-control"
                            rows="3"
                            required></textarea>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Contact Number

                            </label>

                            <input
                            type="text"
                            name="contact_number"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Confirm Password

                            </label>

                            <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            required>

                        </div>

                        <button
                        class="btn btn-primary w-100">

                            Register

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