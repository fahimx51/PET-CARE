<?php
include_once 'config.php';

$sql = "SELECT COUNT(*) AS total FROM users";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalRegisteredUsers = $row['total'];
    echo "<h1>$totalRegisteredUsers</h1>";
} else {
    echo "Error: Unable to fetch total registered users.";
}
?>
