<?php

include_once 'config.php';

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    $sql_delete_appointment = "DELETE FROM approved_appointments WHERE id = $appointment_id";
    if (mysqli_query($conn, $sql_delete_appointment)) {
    } else {

        echo "Error: " . mysqli_error($conn);
    }
} else {

    echo "Error: Appointment ID not provided.";
}

mysqli_close($conn);
?>
<meta http-equiv="refresh" content="0;URL='approved_appointments.php'">