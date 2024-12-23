<?php
include_once 'config.php';

$sql = "SELECT COUNT(*) AS pending_adoption_requests_count FROM adoption_requests WHERE status = 'pending'";

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $pendingAdoptionRequestsCount = $row['pending_adoption_requests_count'];
    echo "<h1 class='count'>$pendingAdoptionRequestsCount</h1>";
} else {
    echo "<h1 class='error'>0</h1>";
}

mysqli_close($conn);
?>
