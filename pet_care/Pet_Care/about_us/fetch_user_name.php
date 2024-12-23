<?php

if (isset($_SESSION['email'])) {
    
    include_once "config.php";

    $email = $_SESSION['email'];
    $sql = "SELECT name FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['name'] = $row['name'] ?? "";
    } else {
        $_SESSION['name'] = "";
    }

    mysqli_close($conn);
}
?>
