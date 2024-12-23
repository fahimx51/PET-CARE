<?php
include_once 'config.php';

$sql = "SELECT COUNT(*) AS approved_found_pets_count FROM approved_foundpet";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $approvedFoundPetsCount = $row['approved_found_pets_count'];
    echo "<h1 class='count'>$approvedFoundPetsCount</h1>";
} else {
    echo "<h1 class='error'>0</h1>";
}

mysqli_close($conn);
?>
