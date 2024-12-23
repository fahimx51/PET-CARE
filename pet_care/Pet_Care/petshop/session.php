<?php
include 'config.php';

if(isset($_POST['login'])){
    $r_userEmail = $_POST['email'];
    $r_pass = $_POST['password'];

    // First, check the users table
    $query1 = "SELECT * FROM `users` WHERE email = '$r_userEmail' AND password = '$r_pass'";
    $res1 = mysqli_query($conn, $query1);

    if(mysqli_num_rows($res1) > 0){
        session_start();
        $_SESSION['email'] = $r_userEmail;
        echo "<script> location.href='profile.php?email=". $r_userEmail."' </script>";
    }
    else {
        // If not found in users, check the admin table
        $query2 = "SELECT * FROM `admin` WHERE admin_username = '$r_userEmail' AND admin_password = '$r_pass'";
        $res2 = mysqli_query($conn, $query2);

        if(mysqli_num_rows($res2) > 0){
            session_start();
            $_SESSION['admin_username'] = $r_userEmail;
            echo "<script> location.href='../admin_dashbord/admin_dashboard.php' </script>";
        }
        else {
            echo "<script> alert('Email & Password is incorrect!')</script>";
            echo "<script> location.href='login.html'</script>";
        }
    }
}
?>
