<?php

include_once 'config.php';


$sql = "SELECT COUNT(*) AS lost_pets_count FROM lostpet";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $lostPetsCount = $row['lost_pets_count'];
    echo "<h1 class='count'>$lostPetsCount</h1>";
} else {
    echo "<h1 class='error'>0</h1>";
}


mysqli_close($conn);
