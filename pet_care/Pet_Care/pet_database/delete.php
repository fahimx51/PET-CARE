<?php

include 'config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get pet ID from URL parameter
$id = $_GET['id'];

$sql = "DELETE FROM pets WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php?deleted=true");
    exit();
} 
else 
{
    echo "Error deleting pet: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
