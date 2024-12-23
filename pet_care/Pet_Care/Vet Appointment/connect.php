<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $username = $_SESSION['email'];
    $appointmentDate = $_POST['appointmentDate'];
    $appointmentTime = $_POST['appointmentTime'];
    $numberOfPets = $_POST['numberOfPets'];
    $phoneNumber = $_POST['phoneNumber'];
    $petType = $_POST['petType']; // Retrieve the selected pet type

    // Database connection
    include '../profile/config.php';

    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } else {
        // Check if the slot is available
        $stmt = $conn->prepare("SELECT * FROM petvet1 WHERE appointmentDate = ? AND appointmentTime = ?");
        $stmt->bind_param("ss", $appointmentDate, $appointmentTime);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Slot already taken
            echo "<script>alert('Slot already taken. Please choose another slot.'); window.location.href = 'index.html';</script>";
            exit(); // Terminate the script after redirection
        } else {
            // Insert the appointment
            $stmt = $conn->prepare("INSERT INTO petvet1 (username, appointmentDate, appointmentTime, numberOfPets, phoneNumber, petType) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssiss", $username, $appointmentDate, $appointmentTime, $numberOfPets, $phoneNumber, $petType); // Bind the petType parameter
            $execval = $stmt->execute();
            $stmt->close();
            $conn->close();

            // Redirect to a success page or display a success message
            echo "<script>alert('Appointment successfully booked wait for approval.'); window.location.href = 'index.html';</script>";
            exit(); // Terminate the script after redirection
        }
    }
} else {
    // If user is not logged in, redirect to login page
    header("Location: ../profile/login.html");
    exit();
}
?>
