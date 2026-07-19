<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

function sendVerificationEmail($toEmail, $toName, $verificationLink)
{
    $mail = new PHPMailer(true);

    try {

        $mail->isSMTP();

        $mail->Host = 'smtp.gmail.com';

        $mail->SMTPAuth = true;

        $mail->Username = 'joshrk3456@gmail.com';

        $mail->Password = 'wezhutspxmetdjdc';

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $mail->Port = 587;

        $mail->setFrom('joshrk3456@gmail.com', 'OfficeHub');

        $mail->addAddress($toEmail, $toName);

        $mail->isHTML(true);

        $mail->Subject = 'Verify your OfficeHub Account';

        $mail->Body = "
            <h2>Welcome to OfficeHub!</h2>

            <p>Thank you for registering.</p>

            <p>Please click the button below to verify your account.</p>

            <p>
                <a href='$verificationLink'
                style='background:#0d6efd;color:white;padding:12px 20px;
                text-decoration:none;border-radius:6px;'>

                Verify My Account

                </a>
            </p>

            <p>If you did not register, you may ignore this email.</p>
        ";

        $mail->send();

        return true;

    } catch (Exception $e) {

        return false;

    }
}