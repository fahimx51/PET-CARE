<?php
include_once 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM pets WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                alert('The pet has been successfully removed.');
                window.location.href = 'pets.php';
              </script>";
    } else {
        echo "<script>
                alert('An error occurred. Please try again later.');
                window.location.href = 'pets.php';
              </script>";
    }

    mysqli_close($conn);
} else {
    header("Location: error.php");
    exit();
}
?>