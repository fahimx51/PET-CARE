<?php

include_once 'config.php';


$sql = "SELECT COUNT(*) AS approved_adoptions_count FROM adoption_requests WHERE status = 'approved'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $approvedAdoptionsCount = $row['approved_adoptions_count'];
    echo "<h1 class='count'>$approvedAdoptionsCount</h1>";
} else {
    echo "<h1 class='error'>0</h1>";
}

mysqli_close($conn);
?>
