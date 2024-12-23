<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Found Pets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Search Found Pets</h2>
        <form method="GET" action="" class="mt-4">
            <div class="mb-3">
                <label for="search" class="form-label">Search by Pet Breed or Color</label>
                <input type="text" id="search" name="search" class="form-control" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="mt-5">
        <?php
session_start();
include('../profile/config.php'); // Correct path to config.php

$searchInput = isset($_GET['search']) ? $_GET['search'] : ''; // Get search input if present

// Modify the query to include the user's email
$query = "SELECT pet_breed, pet_color, found_location, found_date, phone_number, pet_photo, user_email 
          FROM approved_foundpet 
          WHERE pet_breed LIKE '%$searchInput%' OR pet_color LIKE '%$searchInput%'";

// Execute the query
$result = mysqli_query($conn, $query);

// Display the results in a table
echo "<table class='table table-bordered'>
        <thead>
            <tr>
                <th>Breed</th>
                <th>Color</th>
                <th>Found Location</th>
                <th>Found Date</th>
                <th>Phone Number</th>
                <th>Photo</th>
                <th>User Email</th>
            </tr>
        </thead>
        <tbody>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
            <td>".$row['pet_breed']."</td>
            <td>".$row['pet_color']."</td>
            <td>".$row['found_location']."</td>
            <td>".$row['found_date']."</td>
            <td>".$row['phone_number']."</td>
            <td><img src='foundpic/".$row['pet_photo']."' width='100' height='100'></td>
            <td>".$row['user_email']."</td>
          </tr>";
}

echo "</tbody>
      </table>";
?>
        </div>
    </div>
</body>
</html>
