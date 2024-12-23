<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pet_shop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle image upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["image"])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $image = $target_file;

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
    } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            
            // Insert image path into database
            $sql = "INSERT INTO images (image_path) VALUES ('$image')";
            if ($conn->query($sql) === TRUE) {
                echo "Image path inserted into database successfully";
            } else {
                echo "Error inserting image path: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the database connection
$conn->close();
?>
