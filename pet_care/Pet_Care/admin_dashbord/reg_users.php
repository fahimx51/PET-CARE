<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin || Registered Users</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="../../home/image/logo.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('../admin_dashbord/admin_img/admin_background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        h2 {
            color: black;
            background-color: #FFA07A;
            padding: 10px 20px;
            margin-bottom: 20px;
            text-align: center;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }


        .user-table th,
        .user-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .user-table th {
            background-color: blanchedalmond;
            color: #333;
            font-weight: bold;
        }


        .profile-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }

        .no-img {
            font-style: italic;
            color: #999;
        }

        .btn-delete {
            padding: 6px 12px;
            margin-right: 5px;
            border: none;
            border-radius: 4px;
            background-color: red;
            color: #fff;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: green;
        }
    </style>
</head>

<body>

    <?php

    include_once 'config.php';


    $sql_users = "SELECT * FROM users";
    $result_users = mysqli_query($conn, $sql_users);


    echo "<h2>Registered Users</h2>";
    echo "<hr>";
    if (mysqli_num_rows($result_users) > 0) {
        echo "<table class='user-table'>";
        echo "<tr><th>Profile Picture</th><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Confirm Password</th><th>Address</th><th>Status</th><th>Verification Code</th><th>Verification Timestamp</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result_users)) {
            echo "<tr>";
            echo "<td>";

            $profileImagePath = "../profile/pic/" . basename($row['profile_picture']);
            if (!empty($profileImagePath) && file_exists($profileImagePath)) {
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
            echo "<td>" . $row['status'] . "</td>";
            echo "<td>" . $row['verification_code'] . "</td>";
            echo "<td>" . $row['verification_timestamp'] . "</td>";
            echo "<td>";

            echo "<a href='delete_registered_user.php?id=" . $row['id'] . "' class='btn-delete'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No users found.";
    }
    ?>

</body>

</html>