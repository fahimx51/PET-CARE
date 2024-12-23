<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product</title>
</head>
<body>
<h2>Add Product</h2>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label><br>
    <input type="text" id="name" name="name"><br><br>
    
    <label for="price">Price:</label><br>
    <input type="number" id="price" name="price" min="0" step="0.01"><br><br>
    
    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image"><br><br>

    <label for="description">Product Description:</label><br>
    <input type="text" id="description" name="description"><br><br>
    
    <input type="submit" value="Submit">
</form>

<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petcare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}











if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    
    // Check if image file is selected
    if(isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $target_dir = "img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $image = $target_file;
        
        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
        } else {
            // Try to upload file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No image selected.";
    }
    
    // Inserting product into the database
    $sql = "INSERT INTO products (name, price, image, description) VALUES ('$name', '$price', '$image', '$description')";
    if ($conn->query($sql) === TRUE) {
        echo "New product added successfully";
        
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    header("petshop.php");
    exit;
}

// Close the database connection
$conn->close();
?>
</body>
</html>
