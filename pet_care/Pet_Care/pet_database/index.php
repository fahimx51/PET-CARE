<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../profile/login.html");
    exit();
}

// Fetch user's email from session
$email = $_SESSION['email'];

$conn = mysqli_connect("localhost", "root", "", "petcare");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    $pet_type = mysqli_real_escape_string($conn, $_POST['pet_type']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $breed = mysqli_real_escape_string($conn, $_POST['breed']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);

    // File upload handling
    $file = $_FILES['petImage'];
    $fileName = mysqli_real_escape_string($conn, $file['name']);
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    // Check if file was uploaded without errors
    if ($fileError === 0) {
        $fileDestination = '../pet_database/uploads/' . uniqid('', true) . '_' . $fileName;

        // Move uploaded file from temp location to final destination
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            $sql = "INSERT INTO pets (email, pet_type, name, breed, age, image_path) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssss", $email, $pet_type, $name, $breed, $age, $fileDestination);
                mysqli_stmt_execute($stmt);

                // Check if insertion was successful
                if (mysqli_stmt_affected_rows($stmt) > 0) {
                    // Redirect to prevent form resubmission on refresh
                    header("Location: " . $_SERVER['PHP_SELF']);
                    exit();
                } else {
                    echo '<script>alert("Failed to add pet.");</script>';
                }
            } else {
                echo '<script>alert("Database error: ' . mysqli_error($conn) . '");</script>';
            }
        } else {
            echo '<script>alert("Error uploading file.");</script>';
        }
    } else {
        echo '<script>alert("Error uploading file.");</script>';
    }
}

// Fetch pets data for the logged-in user
$sql = "SELECT * FROM pets WHERE email = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        echo "Error fetching pets: " . mysqli_error($conn);
    }
} else {
    echo "Database error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Pets</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">

    <style>
       body {
    background-image: url('img/cute.png');
    background-size: cover;
    background-position: center;
    font-family: 'Arial', sans-serif;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
}

.header {
    background-color: black;
    color: white;
    padding: 10px;
    width: 100%;
    text-align: center;
    position: fixed;
    top: 0;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.header h2 {
    margin: 0;
    font-size: 36px;
}

.container {
    margin-top: 100px;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
}

.pet-card {
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 15px;
    padding: 10px;
    width: 310px;
    height: 310px;
    background-color: white;
    overflow: hidden;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s;
}

.pet-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
}

.pet-card img {
    width: 50%;
    height: 50%;
    object-fit: cover;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.pet-card h3 {
    margin: 10px 0;
    color: #2ecc71;
}

.pet-details p {
    margin: 5px 0;
    font-size: 14px;
}

.actions {
    margin-top: auto;
    text-align: center;
    padding: 10px;
}

.btn-update,
.btn-delete {
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s;
    margin: 5px;
}

.btn-update {
    background-color: #2ecc71;
}

.btn-update:hover {
    background-color: #27ae60;
}

.btn-delete {
    background-color: #e74c3c;
}

.btn-delete:hover {
    background-color: #c0392b;
}

.add-pet-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #2ecc71;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s;
    text-decoration: none;
    z-index: 1000;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.add-pet-button img {
    margin-right: 10px;
    height: 20px;
    width: 20px;
}

.add-pet-button:hover {
    background-color: #27ae60;
}
    </style>
</head>


<body>
<div class="header">
    <h2>Your Pets List</h2>
</div>

<div class="container">
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <div class="pet-card">
            <?php if ($row['image_path']): ?>
                <img src="<?php echo $row['image_path']; ?>" alt="Pet Image">
            <?php endif; ?>
            <h3><?php echo strtoupper($row['pet_type']); ?></h3>
            <div class="pet-details">
                <p><strong>Name:</strong> <?php echo $row['name']; ?></p>
                <p><strong>Breed:</strong> <?php echo $row['breed']; ?></p>
                <p><strong>Age:</strong> <?php echo $row['age']; ?></p>
            </div>
            <div class="actions">
                <button class="btn-update" onclick="window.location.href='update.php?id=<?php echo $row['id']; ?>'">Update</button>
                <button class="btn-delete" onclick="window.location.href='delete.php?id=<?php echo $row['id']; ?>'">Delete</button>
            </div>
        </div>
    <?php endwhile; ?>

    <a href="form.php" class="add-pet-button">
        <img src="../pet_database/img/plus-circle.svg" alt="Plus Circle Image">
        Add a Pet
    </a>
</div>

</body>
</html>
