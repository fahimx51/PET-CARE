<?php
include_once 'config.php';

if(isset($_GET['request_id'])) {
    $request_id = $_GET['request_id'];
    
    // Fetch pet ID associated with this request
    $sql_fetch_pet_id = "SELECT pet_id FROM adoption_requests WHERE id = $request_id";
    $result_fetch_pet_id = mysqli_query($conn, $sql_fetch_pet_id);
    if(mysqli_num_rows($result_fetch_pet_id) > 0) {
        $row = mysqli_fetch_assoc($result_fetch_pet_id);
        $pet_id = $row['pet_id'];

        // Update adoption request status to 'approved'
        $sql_update_status = "UPDATE adoption_requests SET status = 'approved' WHERE id = $request_id";
        if(mysqli_query($conn, $sql_update_status)) {
            // Remove the pet from the adoption list in index.php
            $sql_remove_pet = "DELETE FROM petadopt WHERE id = $pet_id";
            if(mysqli_query($conn, $sql_remove_pet)) {
                echo "Adoption request approved and pet removed successfully.";
            } else {
                echo "Error removing pet: " . mysqli_error($conn);
            }
        } else {
            echo "Error updating adoption request: " . mysqli_error($conn);
        }
    } else {
        echo "Error: Pet ID not found for this request.";
    }
} else {
    echo "Error: Request ID not provided.";
}

mysqli_close($conn);
?>
