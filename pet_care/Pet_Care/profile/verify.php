<?php
require 'config.php';

if (isset($_GET['code'])) {
    $verificationCode = $_GET['code'];

    $check_code_query = "SELECT * FROM `temp_users` WHERE verification_code = '$verificationCode'";
    $result = mysqli_query($conn, $check_code_query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Insert user data into the users table
        $insert_user_query = "INSERT INTO `users`(`name`, `email`, `password`, `confirm_pass`, `address`, `profile_picture`, `verification_code`, `status`) 
                              VALUES ('{$user['name']}', '{$user['email']}', '{$user['password']}', '{$user['confirm_pass']}', '{$user['address']}', '{$user['profile_picture']}', '$verificationCode', 1)";
        mysqli_query($conn, $insert_user_query);

        // Delete user data from the temp_users table
        $delete_temp_user_query = "DELETE FROM `temp_users` WHERE verification_code = '$verificationCode'";
        mysqli_query($conn, $delete_temp_user_query);

        echo "<script> alert('Email verified successfully! You can now log in.') </script>";
        echo "<script> location.href='login.html' </script>";
        exit();
    } else {
        echo "<script> alert('Invalid verification code.') </script>";
        echo "<script> location.href='index.html' </script>";
        exit();
    }
} else {
    echo "<script> alert('Invalid verification code.') </script>";
    echo "<script> location.href='index.html' </script>";
    exit();
}
?>
