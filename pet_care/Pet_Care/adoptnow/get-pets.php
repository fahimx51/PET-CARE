<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petcare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch all pets and their request status from the database
$sql = " SELECT p.id, p.petName, p.petType, p.breed, p.vaccinated, p.neutered, p.age, p.photo, p.color, p.location, p.userEmail, COALESCE(r.status, 'none') as requestStatus
FROM petadopt p LEFT JOIN adoption_requests r ON p.id = r.pet_id AND r.status = 'pending'";

// Execute the query
$result = $conn->query($sql);

$pets = array();

if ($result->num_rows > 0) {
    // Fetch each row and add it to the $pets array
    while ($row = $result->fetch_assoc()) {
        $pets[] = array(
            'id' => $row['id'],
            'petName' => $row['petName'],
            'petType' => $row['petType'],
            'breed' => $row['breed'],
            'vaccinated' => $row['vaccinated'],
            'neutered' => $row['neutered'],
            'age' => $row['age'],
            'photo' => $row['photo'],
            'color' => $row['color'],
            'location' => $row['location'],
            'userEmail' => $row['userEmail'],
            'requestStatus' => $row['requestStatus']
        );
    }
}


$conn->close();

// Return the pets data as JSON
header('Content-Type: application/json');
echo json_encode($pets);
?>
