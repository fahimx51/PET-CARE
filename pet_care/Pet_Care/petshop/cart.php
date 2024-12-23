<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../profile/login.html");
    exit();
}

$email = $_SESSION['email'];

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

// Function to fetch products from the cart for the logged-in user
function fetch_cart_items($conn, $email) {
    $cart_items = [];
    $sql = "SELECT products.id, products.name, products.price, products.image, cart.quantity 
            FROM cart 
            JOIN products ON cart.product_id = products.id 
            WHERE cart.user_email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cart_items[] = $row;
        }
    }
    return $cart_items;
}

// Remove product from cart if requested
if (isset($_POST['remove_from_cart']) && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Delete product from cart in the database
    $delete_sql = "DELETE FROM cart WHERE product_id = $product_id AND user_email = '$email'";
    if ($conn->query($delete_sql) === TRUE) {
        // Product successfully removed from the cart
        header("Location: cart.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Fetch cart items
$cart_items = fetch_cart_items($conn, $email);

// Calculate total price
$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Shopping Cart</title>
<link rel="stylesheet" href="styles.css">
<style>
.product-card {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 20px;
    text-align: center;
}
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    grid-gap: 20px;
}
.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}
.remove-btn {
    background-color: #ff3333;
    color: white;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
}
.total-section {
    text-align: center;
    margin-top: 20px;
}
</style>
</head>
<body>
<header>
  <h1>Your Shopping Cart</h1>
  <nav>
    <ul>
      <li><a href="petshop.php">Shop</a></li>
      <li><a href="cart.php">Cart</a></li>
    </ul>
  </nav>
</header>
<main>
  <div class="product-grid">
    <?php
    if (!empty($cart_items)) {
        foreach ($cart_items as $item) {
            echo "<div class='product-card'>";
            echo "<img src='" . $item['image'] . "' alt='" . $item['name'] . "'>";
            echo "<h2>" . $item['name'] . "</h2>";
            echo "<p>Price: $" . $item['price'] . "</p>";
            echo "<p>Quantity: " . $item['quantity'] . "</p>";
            // Form to remove product from cart
            echo "<form method='post'>";
            echo "<input type='hidden' name='product_id' value='" . $item['id'] . "'>";
            echo "<input type='submit' name='remove_from_cart' value='Remove' class='remove-btn'>";
            echo "</form>";
            echo "</div>";
        }
        // Display total price and proceed to checkout button
        echo "<div class='total-section'>";
        echo "<h2>Total Price: $" . number_format($total_price, 2) . "</h2>";
        echo "<form method='post' action='checkout.php'>";
        echo "<input type='hidden' name='total_price' value='" . $total_price . "'>";
        echo "<input type='submit' value='Proceed to Checkout'>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<p>Your cart is empty.</p>";
    }
    ?>
  </div>
</main>
<footer>
  <p>&copy; 2024 Pet Supply Shop. All rights reserved.</p>
</footer>
</body>
</html>
