<?php
require 'config.php';
session_start();

if (!isset($_SESSION['email'])) {
    echo "Session variable 'email' not set.";
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];

    $select_query = "SELECT password FROM `users` WHERE email = '$email'";
    $result = mysqli_query($conn, $select_query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $current_password = $row['password'];

        if ($new_password === $current_password) {
            echo "<script>alert('New password cannot be the same as the current password. Please choose a different password.')</script>";
            echo "<script>window.location.href = 'forgot_pass_3.html';</script>";
            exit();
        }

        $update_query = "UPDATE `users` SET password = '$new_password' WHERE email = '$email'";
        
        if (mysqli_query($conn, $update_query)) {
            echo "<script>alert('Password updated successfully.')</script>";
            echo "<script>window.location.href = '../../profile/login.html';</script>";
            exit();
        } else {
            echo "<script>alert('Error updating password: " . mysqli_error($conn) . "')</script>";
            echo "<script>window.location.href = 'forgot_pass_3.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found.')</script>";
        echo "<script>window.location.href = 'forgot_pass_3.html';</script>";
        exit();
    }
} else {
    header("Location: forgot_pass_3.html");
    exit();
}
?>
