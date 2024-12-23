<?php
session_start();

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

// Initialize an array to store cart products
$cart_products = [];
$total_price = 0;

// Retrieve product details for each product in the cart
if(isset($_SESSION["cart"])) {
    foreach($_SESSION["cart"] as $product_id) {
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $cart_products[] = $product;
            $total_price += $product['price'];
        }
    }
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
/* Add border to product cards */
.product-card {
    border: 1px solid #ccc;
    padding: 10px;
    margin-bottom: 20px;
}
.cart-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    grid-gap: 20px;
}
.total-price {
    font-weight: bold;
    font-size: 1.2em;
    margin-top: 20px;
}
</style>
</head>
<body>
<header>
  <h1>Shopping Cart</h1>
  <nav>
    <ul>
      <li><a href="petshop.php">Shop</a></li>
      <li><a href="checkout.php">Checkout</a></li>
    </ul>
  </nav>
</header>
<main class="cart-grid">
  <?php
  // Displaying cart products
  if (!empty($cart_products)) {
      foreach ($cart_products as $product) {
          echo "<div class='product-card'>";
          echo "<img src='" . $product['image'] . "' alt='" . $product['name'] . "'>";
          echo "<h2>" . $product['name'] . "</h2>";
          echo "<p>Price: $" . $product['price'] . "</p>";
          echo "</div>";
      }
      echo "<div class='total-price'>Total Price: $" . $total_price . "</div>";
      echo "<form method='post' action='checkout.php'>";
      echo "<input type='submit' name='buy_now' value='Buy Now'>";
      echo "</form>";
  } else {
      echo "Your cart is empty.";
  }
  ?>
</main>
<footer>
  <p>&copy; 2024 Pet Supply Shop. All rights reserved.</p>
</footer>
</body>
</html>
