<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../profile/login.html");
    exit();
}

include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = htmlspecialchars($_POST['name']);
    $email = $_SESSION['email'];
    $message = htmlspecialchars($_POST['message']);

    $sql = "INSERT INTO contact_messages (name, email, message) VALUES ('$name', '$email', '$message')";
    mysqli_query($conn, $sql);

    mysqli_close($conn);

    header("Location: contact.php?message=success");
    exit();
} 
else {
    header("Location: contact.php");
    exit();
}
?>
