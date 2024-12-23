<?php

include_once 'config.php';


$sql_products = "SELECT * FROM products";
$result_products = mysqli_query($conn, $sql_products);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Food</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('../admin_dashbord/admin_img/admin_background.jpg');
            background-size: cover;
            background-repeat: no-repeat;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            transition: transform 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 1px solid #ddd;
        }

        .product-card-content {
            padding: 15px;
        }

        .product-card h3 {
            font-size: 1.4em;
            margin-bottom: 10px;
            color: #333;
        }

        .product-card p {
            font-size: 1em;
            color: #666;
            margin-bottom: 8px;
        }

        .product-card-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 15px;
        }

        .product-card-buttons a {
            padding: 10px 20px;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
            font-size: 1em;
            font-weight: bold;
            margin: 10px;
        }

        .btn-edit {
            background-color: #007bff;
        }

        .btn-delete {
            background-color: #dc3545;
        }

        .btn-edit:hover, .btn-delete:hover {
            opacity: 0.8;
        }

        .success-message {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<?php

session_start();
if (isset($_SESSION['success_message'])) {
    echo '<div class="success-message">' . $_SESSION['success_message'] . '</div>';
    unset($_SESSION['success_message']);
}
?>

<h2>Products</h2>
<div class="product-grid">
    <?php
    if (mysqli_num_rows($result_products) > 0) {
        while ($row = mysqli_fetch_assoc($result_products)) {
            echo "<div class='product-card'>";
            $imagePath = "../petshop/img/" . basename($row['image']);
            if (!empty($row['image']) && file_exists($imagePath)) {
                echo "<img src='$imagePath' alt='" . htmlspecialchars($row['name']) . "'>";
            } else {
                echo "<img src='../petshop/img/cat toy.jpg' alt='Default Image'>";
            }
            echo "<div class='product-card-content'>";
            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p>Price: $" . htmlspecialchars($row['price']) . "</p>";
            echo "<p>Description: " . htmlspecialchars($row['description']) . "</p>";
            echo "<div class='product-card-buttons'>";
            echo "<a href='edit_product.php?id=" . $row['id'] . "' class='btn-edit'>Update</a>";
            echo "<a href='delete_product.php?id=" . $row['id'] . "' class='btn-delete'>Delete</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>No products found.</p>";
    }
    ?>
</div>

</body>
</html>

<?php

mysqli_close($conn);
?>
