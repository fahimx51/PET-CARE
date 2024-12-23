<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../profile/login.html");
    exit();
}

// Get logged-in user's email from session
$userEmail = $_SESSION['email'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $petName = $_POST['petName'];
    $petType = $_POST['petType'];
    $breed = $_POST['breed'];
    $vaccinated = $_POST['vaccinated'];
    $neutered = $_POST['neutered'];
    $age = $_POST['age'];
    $color = $_POST['color'];
    $location = $_POST['location'];
    $photo = $_FILES['photo'];

    // Handle file upload
    $photoName = $_FILES['photo']['name'];
    $photoTmpName = $_FILES['photo']['tmp_name'];
    $photoSize = $_FILES['photo']['size'];
    $photoError = $_FILES['photo']['error'];
    $photoType = $_FILES['photo']['type'];

    $photoExt = explode('.', $photoName);
    $photoActualExt = strtolower(end($photoExt));
    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if (in_array($photoActualExt, $allowed)) {
        if ($photoError === 0) {
            if ($photoSize < 5000000) {
                $photoNewName = uniqid('', true) . "." . $photoActualExt;
                $photoDestination = 'uploads/' . $photoNewName;
                move_uploaded_file($photoTmpName, $photoDestination);

                // Insert data into database with user email
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "petcare";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Example SQL query (adjust as per your database schema)
                $sql = "INSERT INTO petadopt (petName, petType, breed, vaccinated, neutered, age, color, location, photo, userEmail) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssssss", $petName, $petType, $breed, $vaccinated, $neutered, $age, $color, $location, $photoNewName, $userEmail);

                if ($stmt->execute()) {
                    echo "Pet adoption data inserted successfully!";
                } else {
                    echo "Error: " . $stmt->error;
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "Your file is too big!";
            }
        } else {
            echo "There was an error uploading your file!";
        }
    } else {
        echo "You cannot upload files of this type!";
    }
}
?>
