<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin || Pending registration</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <style>
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

        .user-table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-table th,
        .user-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .user-table th {
            background-color: blanchedalmond;
            color: #333;
            font-weight: bold;
        }



        .user-table tr:hover {
            background-color: #ddd;
        }

        .user-table img {
            max-width: 50px;
            max-height: 50px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .no-img {
            font-style: italic;
        }


        .btn {
            padding: 6px 12px;
            margin-right: 5px;
            margin-bottom: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }


        .btn:hover {
            background-color: #4CAF50;
            color: black;
        }
    </style>
</head>

<body>
    <?php

    include_once 'config.php';

    $sql_temp_users = "SELECT * FROM temp_users";
    $result_temp_users = mysqli_query($conn, $sql_temp_users);

    echo "<h2>Pending Registration</h2>";
    if (mysqli_num_rows($result_temp_users) > 0) {
        echo "<div class='table-container'>";
        echo "<table class='user-table'>";
        echo "<tr><th>Profile Picture</th><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Confirm Password</th><th>Address</th><th>Verification Code</th><th>Created At</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result_temp_users)) {
            echo "<tr>";
            echo "<td>";

            $profileImagePath = "../profile/pic/" . basename($row['profile_picture']);
            if (!empty($row['profile_picture']) && file_exists($profileImagePath)) {
                echo "<img src='$profileImagePath' class='profile-img' alt='Profile Image'>";
            } else {
                echo "<div class='no-img'>No Image</div>";
            }
            echo "</td>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['password'] . "</td>";
            echo "<td>" . $row['confirm_pass'] . "</td>";
            echo "<td>" . $row['address'] . "</td>";
            echo "<td>" . $row['verification_code'] . "</td>";
            echo "<td>" . $row['created_at'] . "</td>";
            echo "<td>";

            echo "<a href='delete_pending_registration.php?id=" . $row['id'] . "' class='btn btn-delete'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p style='color: #777; font-style: italic;'>No temporary users found.</p>";
    }
    ?>
</body>

</html>