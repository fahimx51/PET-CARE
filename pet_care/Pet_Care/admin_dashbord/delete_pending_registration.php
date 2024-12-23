<?php
include_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM temp_users WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('The temporary user has been successfully removed.');
                window.location.href = 'temp_users.php';
              </script>";
    } else {
        echo "<script>
                alert('An error occurred. Please try again later.');
                window.location.href = 'temp_users.php';
              </script>";
    }

    mysqli_close($conn);
} else {
    header("Location: error.php");
    exit();
}
?>
