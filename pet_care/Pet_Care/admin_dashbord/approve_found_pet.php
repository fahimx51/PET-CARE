<?php
include_once 'config.php';

if (isset($_GET['id'])) {
    $id =$_GET['id'];

    // Fetch the record from the foundpet table
    $sql_fetch = "SELECT * FROM foundpet WHERE id = $id";
    $result = mysqli_query($conn, $sql_fetch);

    if ($row = mysqli_fetch_assoc($result)) {
        // Insert the record into the approved_foundpet table, including user_email
        $sql_insert = "INSERT INTO approved_foundpet (pet_type, pet_breed, found_location, found_date, pet_color, phone_number, pet_photo, user_email)
                       VALUES ('" . $row['pet_type'] . "', '" . $row['pet_breed'] . "', '" . $row['found_location'] . "', '" . $row['found_date'] . "', '" . $row['pet_color'] . "', '" . $row['phone_number'] . "', '" . $row['pet_photo'] . "', '" . $row['user_email'] . "')";

        if (mysqli_query($conn, $sql_insert)) {
            // Delete the record from the foundpet table
            $sql_delete = "DELETE FROM foundpet WHERE id = $id";
            mysqli_query($conn, $sql_delete);

            // Redirect back to the found_pet.php page
            header("Location: approved_found_pets.php");
            exit();
        } else {
            echo "Error: Could not approve the record.";
        }
    } else {
        echo "Record not found.";
    }
} else {
    echo "Invalid ID.";
}

mysqli_close($conn);
?>
