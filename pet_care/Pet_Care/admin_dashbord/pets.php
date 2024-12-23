<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Pets</title>
    <link rel='stylesheet' href='styles.css'>
    <link rel='shortcut icon' href='../home/image/logo.png' type='image/x-icon'>
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

        .pet-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .no-img {
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

    $sql_pets = "SELECT * FROM pets";
    $result_pets = mysqli_query($conn, $sql_pets);

    echo "<h2>Pets</h2>";

    if (mysqli_num_rows($result_pets) > 0) {
        echo "<table class='pet-table'>
        <tr>
            <th>Pet Photo</th>
            <th>ID</th>
            <th>Pet Type</th>
            <th>Name</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>";
        while ($row = mysqli_fetch_assoc($result_pets)) {

            $profileImagePath = "../pet_database/uploads/" . basename($row['image_path']);
            echo "<tr> <td>";
            if (!empty($row['image_path']) && file_exists($profileImagePath)) {
                echo "<img src='$profileImagePath' class='pet-image' alt='Pet Image'>";
            } else {
                echo "<div class='no-img'>No Image</div>";
            }
            echo "</td>
            <td>" . $row['id'] . "</td>
            <td>" . $row['pet_type'] . "</td>
            <td>" . $row['name'] . "</td>
            <td>" . $row['breed'] . "</td>
            <td>" . $row['age'] . "</td>
            <td>" . $row['email'] . "</td>
            <td>
                <a href='delete_pet.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
            </td>
        </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No pets found.</p>";
    }

    echo "</body>
</html>";

    mysqli_close($conn);
    ?>