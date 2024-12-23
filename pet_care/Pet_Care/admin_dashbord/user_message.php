<?php
include_once 'config.php';

if (isset($_GET['id'])) {
    $message_id = $_GET['id'];

    $sql_delete = "DELETE FROM contact_messages WHERE id=$message_id";

    if (mysqli_query($conn, $sql_delete)) {
        echo "<script>
                alert('The message has been successfully removed.');
                window.location.href = 'user_message.php';
              </script>";
    } else {
        echo "<script>
                alert('An error occurred. Please try again later.');
                window.location.href = 'user_message.php';
              </script>";
    }

    mysqli_close($conn);
}

$sql_messages = "SELECT * FROM contact_messages";
$result_messages = mysqli_query($conn, $sql_messages);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Messages</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('../admin_dashbord/admin_img/admin_background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            color: #333;
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

        .message-container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .message-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .message-header h3 {
            margin: 0;
            color: #007bff;
        }

        .message-header span {
            font-size: 12px;
            color: #666;
        }

        .message-content {
            margin-bottom: 10px;
        }

        .message-actions {
            display: flex;
            justify-content: flex-end;
        }

        .btn-delete,
        .btn-email {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-email {
            background-color: #007bff;
            color: #fff;
            margin-right: 10px;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-email:hover {
            background-color: #0056b3;
        }

        .profile-info {
            margin-top: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 30px;
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
    </style>
</head>

<body>

    <h2>User Messages</h2>

    <?php
    if (mysqli_num_rows($result_messages) > 0) {
        while ($row = mysqli_fetch_assoc($result_messages)) {
            $email = $row['email'];

            // Fetch user profile information based on email
            $sql_user = "SELECT * FROM users WHERE email='$email'";
            $result_user = mysqli_query($conn, $sql_user);
            $user_info = mysqli_fetch_assoc($result_user);

            echo "<div class='message-container'>";

            if ($user_info) {
                echo "<div class='profile-info'>";
                $profileImagePath = "../profile/pic/" . basename($user_info['profile_picture']);
                if (!empty($profileImagePath) && file_exists($profileImagePath)) {
                    echo "<img src='$profileImagePath' class='profile-img' alt='Profile Image'>";
                } else {
                    echo "<div class='no-img'>No Image</div>";
                }
                echo "<p>Email: " . $user_info['email'] . "</p>";
                echo "<p>Address: " . $user_info['address'] . "</p>";
                echo "</div>";
            }

            echo "<div class='message-header'>";
            echo "<h3>" . $row['name'] . "</h3>";
            echo "<span>" . $row['submitted_at'] . "</span>";
            echo "</div>";

            echo "<div class='message-content'>";
            echo "<h4>Message:</h4>";
            echo "<p>" . $row['message'] . "</p>";
            echo "</div>";

            echo "<div class='message-actions'>";
            echo "<a href='mailto:" . $row['email'] . "' class='btn-email'>Email</a>";
            echo "<a href='user_message.php?id=" . $row['id'] . "' class='btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>";
            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "<p>No messages found.</p>";
    }

    mysqli_close($conn);
    ?>

</body>

</html>