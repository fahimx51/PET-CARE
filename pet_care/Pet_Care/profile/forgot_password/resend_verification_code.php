<?php

require 'config.php';
require '../../profile/vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Dhaka');

session_start(); 

$email = $_SESSION['email'];

$newVerificationCode = mt_rand(100000, 999999);

$currentTime = date("g:i A");

$update_query = "UPDATE `users` SET verification_code = '$newVerificationCode', verification_timestamp = '$currentTime' WHERE email = '$email'";

if (mysqli_query($conn, $update_query)) {
    
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'mdabulkhair2001@gmail.com'; 
        $mail->Password = 'jaat jbpd tiwz saod';
        $mail->Port = 465;                  
        $mail->SMTPSecure = 'ssl'; 

        $mail->setFrom('mdabulkhair2001@gmail.com', 'Admin');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Verification Code-(Resand)';
        $mail->Body = 'Your verification code is: ' . $newVerificationCode;

        $mail->send();

        echo "Verification code has been resent to your email.";
    } catch (Exception $e) {
        echo "Email could not be sent. Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Error updating verification code.";
}
?>
