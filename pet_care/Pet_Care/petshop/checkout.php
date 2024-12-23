<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: ../profile/login.html");
    exit();
}

$email = $_SESSION['email'];

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['total_price'])) {
    $total_price = $_POST['total_price'];
} else {
    header("Location: cart.php");
    exit();
}

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

// Handle form submission for placing order
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $total_price = $_POST['total_price'];

    // Insert order into database
    $order_sql = "INSERT INTO orders (user_email, name, address, total_price) VALUES ('$email', '$name', '$address', '$total_price')";
    if ($conn->query($order_sql) === TRUE) {
        // Clear the cart after placing the order
        $clear_cart_sql = "DELETE FROM cart WHERE user_email = '$email'";
        $conn->query($clear_cart_sql);

        echo "<script>alert('Order placed successfully!'); window.location.href='petshop.php';</script>";
    } else {
        echo "Error: " . $order_sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1>Checkout</h1>
  <nav>
    <ul>
      <li><a href="petshop.php">Shop</a></li>
      <li><a href="cart.php">Cart</a></li>
    </ul>
  </nav>
</header>
<main>
  <h2>Billing Information</h2>
  <form method="post" action="checkout.php">
    <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="address">Address:</label>
    <textarea id="address" name="address" required></textarea>
    <p>Total Price: $<?php echo number_format($total_price, 2); ?></p>
    <input type="submit" name="place_order" value="Place Order">
  </form>
</main>
<footer>
  <p>&copy; 2024 Pet Supply Shop. All rights reserved.</p>
</footer>
</body>
</html>
