<?php
include_once 'config.php';

if(isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    
    // Update adoption request status to 'declined'
    $sql_update_status = "UPDATE adoption_requests SET status = 'declined' WHERE id = $request_id";
    if(mysqli_query($conn, $sql_update_status)) {
        echo "Adoption request declined successfully.";
    } else {
        echo "Error updating adoption request: " . mysqli_error($conn);
    }
} else {
    echo "Error: Request ID not provided.";
}

mysqli_close($conn);
?>
