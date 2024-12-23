<?php
include_once 'config.php';


if (isset($_GET['id'])) {
  $id = $_GET['id'];

  $sql = "DELETE FROM foundpet WHERE id = $id";

  if (mysqli_query($conn, $sql)) {
    echo "<script>
                alert('Pet record deleted successfully.');
                window.location.href = 'found_pets.php';
              </script>";
  } else {
    echo "<script>
                alert('Oops! Something went wrong. Please try again later.');
                window.location.href = 'found_pets.php';
              </script>";
  }

  mysqli_close($conn);
} else {
  echo "<script>
            alert('Error: No pet ID provided.');
            window.location.href = 'found_pets.php';
          </script>";
}
