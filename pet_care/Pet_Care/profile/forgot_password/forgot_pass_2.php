<?php
require 'config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $digit1 = $_POST['digit1'];
    $digit2 = $_POST['digit2'];
    $digit3 = $_POST['digit3'];
    $digit4 = $_POST['digit4'];
    $digit5 = $_POST['digit5'];
    $digit6 = $_POST['digit6'];
    
    $code = $digit1 . $digit2 . $digit3 . $digit4 . $digit5 . $digit6;

    $check_query = "SELECT * FROM `users` WHERE verification_code = '$code'";
    $result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $email = $row['email'];

       // Check if the code has expired (assuming 3 minutes expiration)
       $code_time = strtotime($row['verification_timestamp']);
       $current_time = time();
       $code_validity_duration = 3 * 60;

if (($current_time - $code_time) > $code_validity_duration) {
    
    echo "<script>alert('The verification code has expired. Please request a new one.')</script>";
    echo "<script>window.location.href = 'forgot_pass_2.html';</script>";
    exit();
}

        $_SESSION['email'] = $email;
        
        header("Location: forgot_pass_3.html");
        exit();
    } else {
        // Verification code doesn't match
        echo "<script>alert('Invalid verification code. Please try again.')</script>";
        echo "<script>window.location.href = 'forgot_pass_2.html';</script>";
        exit();
    }
} 
else 
{
    header("Location: forgot_pass_2.html");
    exit();
}
?>
