<?php

include_once 'config.php';

// Check if pet_id is provided in the URL
if(isset($_GET['pet_id'])) {
    $pet_id = $_GET['pet_id'];

    // Check if there's already an approved request for this pet
    $sql_check_approved = "SELECT * FROM approved_requests WHERE pet_id = $pet_id";
    $result_check_approved = mysqli_query($conn, $sql_check_approved);

    if(mysqli_num_rows($result_check_approved) > 0) {
        // If an approved request exists, notify the user
        $message = "You cannot send an adoption request for this pet as it has already been adopted.";
    } else {
        // Proceed with inserting a new adoption request
        $requester_email = "user@example.com"; // Replace with actual user email or session data
        
        // Insert new adoption request into adoption_requests table
        $sql_insert_request = "INSERT INTO adoption_requests (pet_id, requester_email, status) VALUES ($pet_id, '$requester_email', 'pending')";
        
        if(mysqli_query($conn, $sql_insert_request)) {
            $message = "Adoption request sent successfully.";
        } else {
            $message = "Error sending adoption request: " . mysqli_error($conn);
        }
    }
} else {
   
    $message = "Error: Pet ID not provided.";
}


mysqli_close($conn);


echo "<script>alert('$message'); window.location.href = 'adoption_requests.php';</script>";
?>
