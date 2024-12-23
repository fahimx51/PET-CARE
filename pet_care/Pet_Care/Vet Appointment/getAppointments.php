<?php
session_start();

// Database connection
include '../profile/config.php';

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];

    // Fetch appointments from approved_appointments table
    $result_approved = $conn->query("SELECT id, username, appointmentDate, appointmentTime, numberOfPets, phoneNumber, petType FROM approved_appointments WHERE username = '$user_email'");
    $appointments = array();

    if ($result_approved->num_rows > 0) {
        // If appointments found in approved_appointments table
        while ($row = $result_approved->fetch_assoc()) {
            $row['status'] = 'Approved';
            $appointments[] = $row;
        }
    }

    // Fetch appointments from petvet1 table
    $result_pending = $conn->query("SELECT id, username, appointmentDate, appointmentTime, numberOfPets, phoneNumber, petType FROM petvet1 WHERE username = '$user_email'");
    if ($result_pending->num_rows > 0) {
        // If appointments found in petvet1 table
        while ($row = $result_pending->fetch_assoc()) {
            $row['status'] = 'Pending';
            $appointments[] = $row;
        }
    }

    if (!empty($appointments)) {
        // Send the appointments as JSON response
        header('Content-Type: application/json');
        echo json_encode($appointments);
    } else {
        // If no appointments found
        echo json_encode(array('message' => 'No appointments found for the logged-in user.'));
    }
} else {
    // If user is not logged in, redirect to login page
    header("Location: ../profile/login.html");
    exit();
}

// Closing the database connection
$conn->close();
?>
