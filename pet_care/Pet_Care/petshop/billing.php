<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['email']) && !isset($_SESSION['admin_username'])) {
    echo "<script> alert('Please log in first!')</script>";
    echo "<script> location.href='petshop.php'</script>";
    exit;
}

// Handle billing
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $total_price = $_SESSION['total_price'];
    $user_email = $_SESSION['email'];

    // Insert order into the database
    $sql = "INSERT INTO orders (user_email, name, address, total_price) VALUES ('$user_email', '$name', '$address', '$total_price')";
    if ($conn->query($sql) === TRUE) {
        // Clear cart
        $clear_cart = "DELETE FROM cart WHERE user_email = '$user_email'";
        $conn->query($clear_cart);

        echo "<script> alert('Order placed successfully!')</script>";
        echo "<script> location.href='petshop.php?username=".urlencode($user_email)."' </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch username from URL
$username = isset($_GET['username']) ? $_GET['username'] : '';

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

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Billing - Pet Supply Shop</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
  <h1>Pet Supply Shop</h1>
  <nav>
    <ul>
      <li><a href="petshop.php?username=<?php echo urlencode($username); ?>">Shop</a></li>
      <li><a href="cart.php?username=<?php echo urlencode($username); ?>">Cart</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </nav>
</header>
<main>
  <h2>Billing Information</h2>
  <form method="post" action="billing.php">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" required>
    <br>
    <h3>Total Price: $<?php echo $_SESSION['total_price']; ?></h3>
    <input type="submit" name="submit" value="Submit">
  </form>
</main>
<footer>
  <p>&copy; 2024 Pet Supply Shop. All rights reserved.</p>
</footer>
</body>
</html>
