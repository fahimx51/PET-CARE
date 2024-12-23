<?php
include 'config.php';

if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    // Fetch the appointment details
    $sql_fetch = "SELECT * FROM appointments WHERE id = $appointmentId";
    $result_fetch = mysqli_query($conn, $sql_fetch);

    if ($result_fetch && mysqli_num_rows($result_fetch) > 0) {
        $appointment = mysqli_fetch_assoc($result_fetch);

        // Insert the appointment into the approved_appointments table
        $sql_insert = "INSERT INTO approved_appointments (username, appointmentDate, appointmentTime, numberOfPets, phoneNumber, petType)
                       VALUES ('".$appointment['username']."', '".$appointment['appointmentDate']."', '".$appointment['appointmentTime']."', '".$appointment['numberOfPets']."', '".$appointment['phoneNumber']."', '".$appointment['petType']."')";

        if (mysqli_query($conn, $sql_insert)) {
            // Delete the appointment from the appointments table
            $sql_delete = "DELETE FROM appointments WHERE id = $appointmentId";
            mysqli_query($conn, $sql_delete);

            echo "Appointment approved and moved to approved_appointments.";
        } else {
            echo "Error inserting into approved_appointments: " . mysqli_error($conn);
        }
    } else {
        echo "Appointment not found.";
    }
} else {
    echo "Invalid request.";
}

// Close the connection
mysqli_close($conn);
?>
