<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('../admin_dashbord/admin_img/admin_background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center;
            color: #444;
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

        .table-container {
            /* width: 90%; */
            margin: 0 auto;
            overflow-x: auto;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }

        .appointment-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .appointment-table th,
        .appointment-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .appointment-table th {
            background-color: blanchedalmond;
            color: #333;
            font-weight: bold;

        }

        .appointment-table tr:hover {
            background-color: #e0e0e0;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 5px;
            margin-bottom: 5px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn-approve {
            background-color: #4CAF50;
            color: white;
        }

        .btn:hover {
            background-color: #FFA07A;
            color: black;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        .btn-approve:hover {
            background-color: #388e3c;
        }

        body {
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
    <?php

    include_once '../admin_dashbord/config.php';

    $sql_appointments = "SELECT * FROM petvet1";
    $result_appointments = mysqli_query($conn, $sql_appointments);


    echo "<h2>Pending Appointments</h2>";
    if (mysqli_num_rows($result_appointments) > 0) {
        echo "<div class='table-container'>";
        echo "<table class='appointment-table'>";
        echo "<tr><th>ID</th><th>Username</th><th>Appointment Date</th><th>Appointment Time</th><th>Number of Pets</th><th>Phone Number</th><th>Pet Type</th><th>Actions</th></tr>";
        while ($row = mysqli_fetch_assoc($result_appointments)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['appointmentDate'] . "</td>";
            echo "<td>" . $row['appointmentTime'] . "</td>";
            echo "<td>" . $row['numberOfPets'] . "</td>";
            echo "<td>" . $row['phoneNumber'] . "</td>";
            echo "<td>" . $row['petType'] . "</td>";
            echo "<td>";
            //delete and approve appointments
            echo "<a href='approve_pending_appointment.php?id=" . $row['id'] . "' class='btn btn-approve'>Approve</a>";
            echo "<a href='delete_pending_appointment.php?id=" . $row['id'] . "' class='btn btn-delete'>Delete</a>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p style='text-align: center; color: #777; font-style: italic;'>No appointments found.</p>";
    }
    ?>
</body>

</html>