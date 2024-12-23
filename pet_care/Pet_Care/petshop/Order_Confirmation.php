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

$total_price = 0;

// Calculate the total price if there are products in the cart
if (isset($_SESSION["cart"])) {
    foreach($_SESSION["cart"] as $product_id) {
        $sql = "SELECT * FROM products WHERE id = $product_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();
            $total_price += $product['price'];
        }
    }
}

// If the form is submitted, process the order
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $address = $_POST['address'];

    // Insert order details into the database
    $stmt = $conn->prepare("INSERT INTO orders (name, address, total_price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $name, $address, $total_price);
    
    if ($stmt->execute()) {
        // Clear the cart
        unset($_SESSION['cart']);
        echo "<p>Thank you, " . htmlspecialchars($name) . ". Your order has been placed.</p>";
        echo "<p>It will be shipped to " . htmlspecialchars($address) . ".</p>";
        echo "<p>Total Price: $" . $total_price . "</p>";
        echo "<a href='petshop.php'>Continue Shopping</a>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmation</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1>Order Confirmation</h1>
</header>
<main>
  <?php
  if ($_SERVER["REQUEST_METHOD"] != "POST") {
  ?>
  <form method="post" action="">
    <div>
      <label for="name">Name</label>
      <input type="text" id="name" name="name" required>
    </div>
    <div>
      <label for="address">Billing Address</label>
      <input type="text" id="address" name="address" required>
    </div>
    <input type="submit" value="Place Order">
  </form>
  <?php
  }
  ?>
</main>
<footer>
  <p>&copy; 2024 Pet Supply Shop. All rights reserved.</p>
</footer>
</body>
</html>
