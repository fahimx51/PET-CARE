<?php
include_once 'config.php';

$sql = "SELECT COUNT(*) AS approved_lost_pets_count FROM approved_lostpet";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $approvedLostPetsCount = $row['approved_lost_pets_count'];
    echo "<h1 class='count'>$approvedLostPetsCount</h1>";
} else {
    echo "<h1 class='error'>0</h1>";
}

mysqli_close($conn);
?>
