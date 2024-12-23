<?php
include 'config.php';

$id = $_GET['id'];

$query = "SELECT email, profile_picture FROM users WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$email = $row['email'];
$currentProfilePicture = $row['profile_picture'];

if (isset($_POST['update'])) {
    
    $imageLocalLocation = $currentProfilePicture;

    // Check if a new file has been uploaded
    if (!empty($_FILES['profile_picture']['name'])) {
        $imageTempLocation = $_FILES['profile_picture']['tmp_name'];
        
        $imageName = $_FILES['profile_picture']['name'];
        $imageLocalLocation = "pic/" . $imageName;

        $allowedFormats = ['jpeg', 'jpg', 'png', 'gif'];
        $fileFormat = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($fileFormat, $allowedFormats)) {
            echo "Invalid file format. Please upload an image with formats: JPEG, JPG, PNG, GIF.";
            exit();
        }

        $maxFileSize = 10 * 1024 * 1024; // 10MB in bytes
        
        if ($_FILES["profile_picture"]["size"] > $maxFileSize) {
            echo "<script>alert('File size exceeds the limit (10MB). Please choose a smaller file.');</script>";
            echo "<script>location.href='update.php?id=$id';</script>";
            exit();
        }

        // Move the uploaded file to the desired location
        move_uploaded_file($imageTempLocation, $imageLocalLocation);
    }

    $name = $_POST['name'];
    $address = $_POST['address'];

    $query = "UPDATE users SET profile_picture = '$imageLocalLocation', name = '$name', address = '$address' WHERE id = '$id'";

    if (mysqli_query($conn, $query)) {
        header("Location: profile.php?email=" . urlencode($email));
        exit();
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
