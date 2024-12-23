<?php

include_once 'config.php';

$message = "";

if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    $sql_select_appointment = "SELECT * FROM petvet1 WHERE id = $appointment_id";
    $result_select_appointment = mysqli_query($conn, $sql_select_appointment);

    if (mysqli_num_rows($result_select_appointment) > 0) {
        $row = mysqli_fetch_assoc($result_select_appointment);

        // Insert appointment into approved_appointments table
        $sql_insert_approved = "INSERT INTO approved_appointments (username, appointmentDate, appointmentTime, numberOfPets, phoneNumber, petType) VALUES ('" . $row['username'] . "', '" . $row['appointmentDate'] . "', '" . $row['appointmentTime'] . "', '" . $row['numberOfPets'] . "', '" . $row['phoneNumber'] . "', '" . $row['petType'] . "')";
        mysqli_query($conn, $sql_insert_approved);

        // Delete appointment from petvet1 table
        $sql_delete_appointment = "DELETE FROM petvet1 WHERE id = $appointment_id";
        mysqli_query($conn, $sql_delete_appointment);


        $message = "Appointment approved successfully.";
    } else {

        $message = "Error: Appointment not found.";
    }
} else {

    $message = "Error: Appointment ID not provided.";
}


mysqli_close($conn);


echo "<script>alert('$message'); window.location.href = 'pending_appointment.php';</script>";
?>