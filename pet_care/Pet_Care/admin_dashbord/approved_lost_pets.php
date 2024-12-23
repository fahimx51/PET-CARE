<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Lost Pets</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        h2 {
            color: black;
            background-color: #FFA07A;
            padding: 10px 20px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }

        .pet-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        .pet-table th,
        .pet-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #dee2e6;
        }

        .pet-table th {
            background-color: blanchedalmond;
            color: #333;
            font-weight: bold;
        }

        .pet-photo {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .no-photo {
            font-style: italic;
            color: #999;
        }

        .contact-phone,
        .contact-email {
            color: #007bff;
            text-decoration: none;
        }

        .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

    <?php

    include_once 'config.php';

    // Fetch all details from the approved_lostpet table
    $sql_approved_lost_pets = "SELECT id, pet_type, pet_breed, last_seen_location, lost_date, pet_color, phone_number, pet_photo, user_email FROM approved_lostpet";
    $result_approved_lost_pets = mysqli_query($conn, $sql_approved_lost_pets);

    echo "<h2>Approved Lost Pets</h2>";
    if (mysqli_num_rows($result_approved_lost_pets) > 0) {
        echo "<table class='pet-table'>";
        echo "<tr><th>Pet Photo</th><th>ID</th><th>Pet Type</th><th>Breed</th><th>Last Seen Location</th><th>Lost Date</th><th>Color/Markings</th><th>Phone No</th><th>User Email</th><th>Actions</th></tr>";

        while ($row = mysqli_fetch_assoc($result_approved_lost_pets)) {
            echo "<tr>";
            echo "<td>";

            $profileImagePath = "../lostfound/lostpic/" . basename($row['pet_photo']);
            if (!empty($row['pet_photo']) && file_exists($profileImagePath)) {
                echo "<img src='$profileImagePath' class='pet-photo' alt='Profile Image'>";
            } else {
                echo "<div class='no-photo'>No Image</div>";
            }

            echo "</td>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['pet_type'] . "</td>";
            echo "<td>" . $row['pet_breed'] . "</td>";
            echo "<td>" . $row['last_seen_location'] . "</td>";
            echo "<td>" . $row['lost_date'] . "</td>";
            echo "<td>" . $row['pet_color'] . "</td>";
            echo "<td><a href='tel:" . $row['phone_number'] . "' class='contact-phone'>" . $row['phone_number'] . "</a></td>";
            echo "<td><a href='mailto:" . $row['user_email'] . "' class='contact-email'>" . $row['user_email'] . "</a></td>";
            echo "<td>";
            echo "<a href='delete_approved_lost_pet.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
            echo "</td>";

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No approved lost pets found.";
    }

    mysqli_close($conn);
    ?>

</body>

</html>
