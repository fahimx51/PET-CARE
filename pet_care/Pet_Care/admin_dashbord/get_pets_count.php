<?php

include_once 'config.php';


$sql = "SELECT COUNT(*) AS total FROM pets";


$result = mysqli_query($conn, $sql);

if ($result) {

    $row = mysqli_fetch_assoc($result);

    $totalPets = $row['total'];

    echo "<h1>$totalPets</h1>";
} else {

    echo "Error: Unable to fetch total pets.";
}


mysqli_close($conn);
?>