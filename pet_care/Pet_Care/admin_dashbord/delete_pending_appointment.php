<?php

include_once 'config.php';

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    $sql_delete_appointment = "DELETE FROM petvet1 WHERE id = $appointment_id";
    if (mysqli_query($conn, $sql_delete_appointment)) {
        echo "<script>
                alert('Appointment deleted successfully.');
                window.location.href = 'pending_appointment.php';
              </script>";
    } else {
        echo "<script>
                alert('Error deleting the appointment. Please try again.');
                window.location.href = 'pending_appointment.php';
              </script>";
    }
} else {
    header("Location: pending_appointment.php");
    exit();
}
