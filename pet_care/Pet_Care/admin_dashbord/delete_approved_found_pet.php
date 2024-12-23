<?php
include_once 'config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // SQL query to delete the record from the approved_foundpet table
    $sql = "DELETE FROM approved_foundpet WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<script>
                    alert('Found pet record deleted successfully.');
                    window.location.href = 'approved_found_pets.php';
                  </script>";
    } else {
        echo "<script>
                    alert('Oops! Something went wrong. Please try again later.');
                    window.location.href = 'approved_found_pets.php';
                  </script>";
    }

    mysqli_close($conn);
} else {
    echo "<script>
                alert('Error: No pet ID provided.');
                window.location.href = 'approved_found_pets.php';
              </script>";
}
?>
