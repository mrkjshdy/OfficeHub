<?php
require_once '../config/database.php';
require_once '../config/session.php';

$message = "";

if (!isset($_GET['token'])) {

    $message = '<div class="alert alert-danger">
                    Invalid verification link.
                </div>';

} else {

    $token = $_GET['token'];

    $stmt = $pdo->prepare("
        SELECT *
        FROM verification_tokens
        WHERE token = ?
    ");

    $stmt->execute([$token]);

    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$record) {

        $message = '<div class="alert alert-danger">
                        Invalid verification token.
                    </div>';

    } else {

        if (strtotime($record['expires_at']) < time()) {

            $message = '<div class="alert alert-danger">
                            Verification link has expired.
                        </div>';

        } else {

            /* Verify User */

            $update = $pdo->prepare("
                UPDATE users
                SET is_verified = 1
                WHERE id = ?
            ");

            $update->execute([
                $record['user_id']
            ]);

            /* Remove Token */

            $delete = $pdo->prepare("
                DELETE FROM verification_tokens
                WHERE token = ?
            ");

            $delete->execute([$token]);

            /* Audit Log */

            $activity = "Verified email address";

            $log = $pdo->prepare("
                INSERT INTO audit_logs
                (user_id, activity)
                VALUES (?, ?)
            ");

            $log->execute([
                $record['user_id'],
                $activity
            ]);

            $message = '<div class="alert alert-success">

                            <h4>Email Verified!</h4>

                            <p>

                                Your account has been successfully verified.

                            </p>

                            <a href="login.php"
                               class="btn btn-primary">

                               Login Now

                            </a>

                        </div>';
        }

    }

}

include '../includes/header.php';
include '../includes/navbar.php';
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <?= $message ?>

        </div>

    </div>

</div>

<?php include '../includes/footer.php'; ?>