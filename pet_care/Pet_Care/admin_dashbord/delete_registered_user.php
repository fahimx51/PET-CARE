<?php
include_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM users WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('User deleted successfully.');
                window.location.href = 'reg_users.php';
              </script>";
    } else {
        echo "<script>
                alert('Oops! Something went wrong. Please try again later.');
                window.location.href = 'reg_users.php';
              </script>";
    }

    mysqli_close($conn);
} else {
    header("Location: error.php");
    exit();
}
?>
