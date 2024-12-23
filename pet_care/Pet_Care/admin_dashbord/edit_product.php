<?php
// Include database connection file
include_once 'config.php';

// Initialize variables
$row = null;
$message = "";

// Check if form is submitted for product update
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $existing_image = $_POST['existing_image'];

    // Handle image update if a new image is uploaded
    $image = $existing_image; // Default to existing image
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../petshop/img/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check file size and type if needed

        // Move uploaded file to target directory
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file; // Update image path
        } else {
            $message = "Error uploading image.";
        }
    }

    // Update product details in the database
    $sql = "UPDATE products SET name='$name', price='$price', description='$description', image='$image' WHERE id='$id'";

    if (mysqli_query($conn, $sql)) {
        $message = "Product updated successfully.";
    } else {
        $message = "Error updating product: " . mysqli_error($conn);
    }
}

// Check if product ID is set and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    // Check if a product with the given ID exists
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $message = "Product not found or invalid ID provided.";
        $row = null; // Ensure $row is null if no product is found
    }
} else {
    $message = "Invalid product ID.";
    $row = null; // Ensure $row is null for invalid product ID
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to external stylesheet if available -->
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('../home/image/pet1.jpg'); /* Replace with your image path */
            background-size: cover; /* Ensure the background image covers the entire viewport */
            background-position: center; /* Center the background image */
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 500px;
            margin: 20px;
        }

        .card img {
            width: 30%; /* Adjust the width of the image as needed */
            height: auto;
            border-bottom: 1px solid #ddd;
            display: block;
            margin: 0 auto; /* Center the image horizontally */
            padding: 10px;
            border-radius: 10px 10px 0 0; /* Rounded corners for top */
        }

        .card-content {
            padding: 20px;
        }

        .card-content h2 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }

        .card-content label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .card-content input[type="text"],
        .card-content input[type="number"],
        .card-content textarea,
        .card-content input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .card-content textarea {
            resize: vertical;
        }

        .card-content input[type="submit"] {
            width: 100%;
            background-color: #007bff;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
        }

        .card-content input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .current-image {
            text-align: center;
            margin-bottom: 20px;
        }

        .current-image p {
            font-style: italic;
            color: #666;
        }
    </style>
</head>
<body>
    <?php if (!empty($message)): ?>
        <div id="success-message" style="display: none; background-color: #4CAF50; color: white; text-align: center; padding: 10px; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 999;">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <?php if ($row): ?>
        <div class="card">
            <?php if (!empty($row['image'])): ?>
                <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Current Image">
            <?php else: ?>
                <img src="path/to/default/image.jpg" alt="Default Image"> <!-- Placeholder image path -->
            <?php endif; ?>

            <div class="card-content">
                <h2>Edit Product</h2>
                <form id="edit-form" action="edit_product.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    
                    <label for="name">Product Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                    
                    <label for="price">Price:</label>
                    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" min="0" step="0.01" required>
                    
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="4" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                    
                    <label for="image">New Image (optional):</label>
                    <input type="file" id="image" name="image">
                    <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($row['image']); ?>">

                    <div class="current-image">
                        <?php if (empty($row['image'])): ?>
                            <p>No image available.</p>
                        <?php endif; ?>
                    </div>

                    <input type="submit" name="update" value="Update Product">
                </form>
            </div>
        </div>
    <?php else: ?>
        <div class="card">
            <div class="card-content">
                <h2>Error</h2>
                <p>Product not found or invalid ID provided.</p>
            </div>
        </div>
    <?php endif; ?>

    <script>
        // Display success message as popup and redirect after a delay
        <?php if (!empty($message)): ?>
            document.addEventListener('DOMContentLoaded', function() {
                var successMessage = document.getElementById('success-message');
                if (successMessage) {
                    successMessage.style.display = 'block';
                    setTimeout(function() {
                        successMessage.style.display = 'none';
                        window.location.href = 'pet_food_list.php'; // Redirect to product list page
                    }, 0); // Delay in milliseconds (3 seconds)
                }
            });
        <?php endif; ?>
    </script>
</body>
</html>
