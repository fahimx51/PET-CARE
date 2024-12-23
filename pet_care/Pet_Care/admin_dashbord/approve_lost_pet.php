<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Retrieve the lost pet's data
    $sql_get_pet = "SELECT * FROM lostpet WHERE id = $id";
    $result_pet = mysqli_query($conn, $sql_get_pet);
    $pet_data = mysqli_fetch_assoc($result_pet);

    if ($pet_data) {
        // Insert the data into the approved_lostpet table, including the email
        $sql_approve = "INSERT INTO approved_lostpet (pet_type, pet_breed, pet_name, pet_color, last_seen_location, lost_date, phone_number, pet_photo, user_email)
                        VALUES ('" . $pet_data['pet_type'] . "', '" . $pet_data['pet_breed'] . "', '" . $pet_data['pet_name'] . "', '" . $pet_data['pet_color'] . "', '" . $pet_data['last_seen_location'] . "', '" . $pet_data['lost_date'] . "', '" . $pet_data['phone_number'] . "', '" . $pet_data['pet_photo'] . "', '" . $pet_data['user_email'] . "')";
        mysqli_query($conn, $sql_approve);

        // Delete the pet from the lostpet table
        $sql_delete = "DELETE FROM lostpet WHERE id = $id";
        mysqli_query($conn, $sql_delete);

        echo "<script>alert('Pet approved successfully!'); window.location.href='approved_lost_pets.php';</script>";
    } else {
        echo "<script>alert('Pet not found!'); window.location.href='lost_pets.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request!'); window.location.href='lost_pets.php';</script>";
}

mysqli_close($conn);
?>
