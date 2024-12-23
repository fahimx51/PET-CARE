<?php
include 'config.php';

$id = $_GET['id'];

$delete_query = "DELETE FROM users WHERE id = '$id'";

if (mysqli_query($conn, $delete_query)) {
    echo "<script>alert('Deleted Successfully!!')</script>";
    header("Location: index.html");
    exit();
} else {
    echo "<script>alert('Failed to Delete!!')</script>";
    header("Location: index.html");
    exit();
}

mysqli_close($conn);
?>
