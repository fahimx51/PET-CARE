<?php
include_once 'config.php';

$sql = "SELECT COUNT(*) AS total FROM contact_messages";
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalUserMessages = $row['total'];
    echo "<h1>$totalUserMessages</h1>";
} else {
    echo "Error: Unable to fetch total user messages.";
}

mysqli_close($conn);
?>
