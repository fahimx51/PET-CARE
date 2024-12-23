<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['email'])) {
    $username = $_SESSION['email'];
    
    // Check if appointment ID is provided
    if (isset($_GET['id'])) {
        $appointmentId = $_GET['id'];

        // Database connection
        include '../profile/config.php';

        if ($conn->connect_error) {
            die("Connection Failed: " . $conn->connect_error);
        } else {
            // Check if the appointment belongs to the logged-in user
            $stmt = $conn->prepare("SELECT * FROM petvet1 WHERE id = ? AND username = ?");
            $stmt->bind_param("is", $appointmentId, $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                // Appointment found, delete it
                $stmt = $conn->prepare("DELETE FROM petvet1 WHERE id = ?");
                $stmt->bind_param("i", $appointmentId);
                $stmt->execute();
                $stmt->close();
                $conn->close();
                
                // Send success response
                echo json_encode(array('success' => true));
                exit();
            } else {
                // Appointment not found or doesn't belong to the user
                echo json_encode(array('success' => false, 'message' => 'Appointment not found or unauthorized.'));
                exit();
            }
        }
    } else {
        // If appointment ID is not provided
        echo json_encode(array('success' => false, 'message' => 'Appointment ID not provided.'));
        exit();
    }
} else {
    // If user is not logged in
    echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
    exit();
}
?>
