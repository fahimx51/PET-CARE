<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adoption Requests</title>
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
            width: 90%;
            margin: 0 auto;
            overflow-x: auto; 
            background-color: rgba(255, 255, 255, 0.9); 
            border-radius: 8px; 
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 50px;
        }

        .adoption-table {
            width: 100%;
            border-collapse: collapse;
        }

        .adoption-table th, .adoption-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .adoption-table th {
            background-color: #f7f7f7;
            color: #333;
            font-weight: bold;
        }

        .adoption-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .adoption-table tr:hover {
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

        .btn-approve {
            background-color: #4CAF50;
            color: white;
        }

        .btn-delete {
            background-color: #f44336;
            color: white;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .btn-approve:hover {
            background-color: #388e3c;
        }

        .btn-delete:hover {
            background-color: #d32f2f;
        }

        
        body {
            margin-bottom: 50px;
        }
    </style>
</head>
<body>

<?php
include_once 'config.php';

// Fetch pending adoption requests
$sql_requests = "SELECT * FROM adoption_requests WHERE status = 'pending'";
$result_requests = mysqli_query($conn, $sql_requests);

echo "<h2>Pending Adoption Requests</h2>";
echo "<div class='table-container'>";
echo "<table class='adoption-table'>";
echo "<tr><th>ID</th><th>Pet ID</th><th>Requester Email</th><th>Status</th><th>Actions</th></tr>";

while ($row = mysqli_fetch_assoc($result_requests)) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['pet_id']."</td>";
    echo "<td>".$row['requester_email']."</td>";
    echo "<td>".$row['status']."</td>";
    echo "<td>";
    echo "<a href='approveAdoptionRequest.php?request_id=".$row['id']."' class='btn btn-approve'>Approve</a>";
    echo "<a href='declineAdoptionRequest.php?request_id=".$row['id']."' class='btn btn-delete'>Decline</a>";
    echo "</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

// Fetch approved adoption requests
$sql_approved = "SELECT * FROM adoption_requests WHERE status = 'approved'";
$result_approved = mysqli_query($conn, $sql_approved);

echo "<h2>Approved Adoptions</h2>";
echo "<div class='table-container'>";
echo "<table class='adoption-table'>";
echo "<tr><th>ID</th><th>Pet ID</th><th>Requester Email</th><th>Status</th></tr>";

while ($row = mysqli_fetch_assoc($result_approved)) {
    echo "<tr>";
    echo "<td>".$row['id']."</td>";
    echo "<td>".$row['pet_id']."</td>";
    echo "<td>".$row['requester_email']."</td>";
    echo "<td>".$row['status']."</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

mysqli_close($conn);
?>




</body>
</html>
