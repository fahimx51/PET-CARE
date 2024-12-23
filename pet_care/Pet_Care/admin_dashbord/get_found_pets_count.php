<?php

include_once 'config.php';


$sql = "SELECT COUNT(*) AS found_pets_count FROM foundpet";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $foundPetsCount = $row['found_pets_count'];
    echo "<h1 class='count'>$foundPetsCount</h1>";
} else {
    echo "<h1 class='error'>0</h1>";
}


mysqli_close($conn);
