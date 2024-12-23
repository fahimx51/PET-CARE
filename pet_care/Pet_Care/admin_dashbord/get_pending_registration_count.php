<?php
include_once 'config.php';

$sql = "SELECT COUNT(*) AS total FROM temp_users";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalOtherUsers = $row['total'];
    echo "<h1>$totalOtherUsers</h1>";
} else {
    echo "Error: Unable to fetch total other users.";
}
?>
