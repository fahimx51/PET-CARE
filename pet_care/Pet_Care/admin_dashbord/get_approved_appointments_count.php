<?php
include_once 'config.php';

$sql = "SELECT COUNT(*) AS total FROM approved_appointments"; 
$result = mysqli_query($conn, $sql);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalApprovedAppointments = $row['total'];
    echo "<h1>$totalApprovedAppointments</h1>";
} else {
    echo "Error: Unable to fetch total approved appointments.";
}
?>
