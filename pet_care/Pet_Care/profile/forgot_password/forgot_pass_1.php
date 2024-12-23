<?php

require 'config.php';
require '../../profile/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

date_default_timezone_set('Asia/Dhaka');

$email = $_POST['email'];

$check_query = "SELECT * FROM `users` WHERE email = '$email'";
$result = mysqli_query($conn, $check_query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $verificationCode = $row['verification_code'];
    $timestamp = $row['verification_timestamp'];


    if ($verificationCode && time() - strtotime($timestamp) <= 180) { 
        echo "<script>alert('Verification code is still valid. No need to resend.')</script>";
        echo "<script>window.location.href = 'forgot_pass_2.html';</script>";
        exit();
    } else {
       
        $newVerificationCode = mt_rand(100000, 999999);
        $currentTime = date("g:i A");

        $update_query = "UPDATE `users` SET verification_code = '$newVerificationCode', verification_timestamp = '$currentTime' WHERE email = '$email'";
        
        if (mysqli_query($conn, $update_query)) {
            
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'fahimx51@gmail.com'; 
                $mail->Password = 'xwzp xijh fchw quoa';
                $mail->Port = 465;                  
                $mail->SMTPSecure = 'ssl'; 

                // Recipients
                $mail->setFrom('fahimx51@gmail.com', 'Admin');
                $mail->addAddress($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Verification Code for Pet Care Website';
                $mail->Body = 'Your verification code is: ' . $newVerificationCode;

                $mail->send();

                echo "<script>alert('Verification code has been resent to your email.')</script>";
                echo "<script>window.location.href = 'forgot_pass_2.html';</script>";
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Email could not be sent. Error: " . $mail->ErrorInfo . "')</script>";
                echo "<script>location.href='forgot_pass.html'</script>";
                exit();
            }
        } else {
            echo "<script>alert('Error updating verification code.')</script>";
            echo "<script>location.href='forgot_pass.html'</script>";
            exit();
        }
    }
} else {
    echo "<script>alert('Email not found in the database.')</script>";
    echo "<script>location.href='forgot_pass.html'</script>";
    exit();
}

?>
