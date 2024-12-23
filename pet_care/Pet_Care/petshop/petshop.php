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

// Function to fetch products from the database
function fetch_products($conn, $search_query = "") {
    $products = [];
    $sql = "SELECT * FROM products";
    if (!empty($search_query)) {
        $sql .= " WHERE name LIKE '%" . $conn->real_escape_string($search_query) . "%'";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }
    return $products;
}

// Handle adding product to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $user_email = $email;

    // Check if product is already in cart
    $check_cart = "SELECT * FROM cart WHERE user_email = '$user_email' AND product_id = '$product_id'";
    $result = $conn->query($check_cart);

    if ($result->num_rows > 0) {
        // If product is already in cart, increase the quantity
        $update_cart = "UPDATE cart SET quantity = quantity + 1 WHERE user_email = '$user_email' AND product_id = '$product_id'";
        $conn->query($update_cart);
    } else {
        // If product is not in cart, add it to cart
        $add_to_cart = "INSERT INTO cart (user_email, product_id) VALUES ('$user_email', '$product_id')";
        $conn->query($add_to_cart);
    }

    // Redirect to avoid resubmission of form data
    header("Location: petshop.php");
    exit();
}

// Handle search query
$search_query = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}

$products = fetch_products($conn, $search_query);

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pet Supply Shop</title>
<link rel="stylesheet" href="styles.css">
<style>
/* Reset and general styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f9f9f9;
}

/* Header styles */
header {
  background-color: #333;
  color: #fff;
  padding: 10px 0;
  margin-bottom: 20px;
  text-align: center;
}

.container {
    .container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
}

header h1 {
  font-size: 2em;
  margin: 0;
}

nav ul {
    list-style-type: none;
  padding: 0;
  margin: 0;
}

nav ul li {
  display: inline;
  margin-right: 20px;
}

nav ul li a {
  color: #fff;
  text-decoration: none;
  font-size: 1.2em;
  transition: color 0.3s;
}

nav ul li a:hover {
  color: #f1f1f1;
}

.search-form {
  display: flex;
  align-items: center;
}

.search-form input[type=text] {
  padding: 10px;
  font-size: 1em;
  margin-right: 10px;
}

.search-form input[type=submit] {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: #fff;
  border: none;
  cursor: pointer;
  font-size: 1em;
  transition: background-color 0.3s;
}

.search-form input[type=submit]:hover {
  background-color: #45a049;
}

.main {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
}

.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 50px;
  width: 100%;
  padding: 20px;
  box-sizing: border-box;
}

.product-card {
  width: 100%;
  height: 300px;
  perspective: 1000px;
  position: relative;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  background-color: #fff;
  transition: transform 0.5s;
  overflow: hidden;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

.product-card-inner {
  position: relative;
  width: 100%;
  height: 100%;
  text-align: center;
  transition: transform 0.6s;
  transform-style: preserve-3d;
}

.product-card:hover .product-card-inner {
  transform: rotateY(180deg);
}

.product-card-front,
.product-card-back {
  width: 100%;
  height: 100%;
  position: absolute;
  backface-visibility: hidden;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  padding: 20px;
  box-sizing: border-box;
}

.product-card-front img {
  width: 60%;
  max-height: 150px;
  object-fit: cover;
  border-radius: 10px;
}

.product-card-front h2 {
  margin-top: 10px;
  font-size: 20px;
  color: #333;
}

.product-card-front p {
  margin-top: 5px;
  font-size: 16px;
  color: #666;
  text-align: center;
  flex-grow: 1;
}

.product-card-back {
  transform: rotateY(180deg);
  background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
  box-sizing: border-box;
  text-align: left;
}

.product-card-back p.description {
  font-size: 16px;
  color: #333;
  line-height: 1.5;
  margin-bottom: 10px;
}

.add-to-cart-btn {
    margin-top: auto ;
  background-color: #4caf50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.add-to-cart-btn:hover {
  background-color: #45a049;
}

/* Additional styles for nav and header */
nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #555;
  padding: 10px 20px;
}

nav ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
}

nav ul li {
  display: inline;
  margin-right: 10px;
}

nav ul li a {
  color: #fff;
  text-decoration: none;
  font-size: 16px;
}

nav ul li a:hover {
  text-decoration: underline;
}

.search-form {
  margin-left: auto;
}

.search-form input[type=text],
.search-form input[type=submit] {
  padding: 8px;
  font-size: 14px;
}

</style>
</head>
<link rel="stylesheet" href="styles.css">
<body>
    <div class="container">
<header>
  <h1>Pet Supply Shop</h1>
  <nav>
    <ul>
      <li><a href="petshop.php">Shop</a></li>
      <li><a href="cart.php">Cart</a></li>
    </ul>
    <form class="search-form" method="get" action="petshop.php">
      <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search for products">
      <input type="submit" value="Search">
    </form>
  </nav>
  </div>
</header>
<main class="main">
  <div class="product-grid">
    <?php
    if (!empty($products)) {
        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<div class='product-card-inner'>";
            echo "<div class='product-card-front'>";
            echo "<img src='" . $product['image'] . "' alt='" . $product['name'] . "'>";
            echo "<h2>" . $product['name'] . "</h2>";
            echo "<p>Price: $" . $product['price'] . "</p>";
            echo "</div>";
            echo "<div class='product-card-back'>";
            echo "<p class='description'>" . $product['description'] . "</p>";
            echo "<form method='post' action='petshop.php'>";
            echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
            echo "<input type='submit' name='add_to_cart' value='Add to Cart' class='add-to-cart-btn'>";
            echo "</form>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "No products found.";
    }
    ?>
  </div>
</main>
<footer>
  <p>&copy; 2024 Pet Supply Shop. All rights reserved.</p>
</footer>
</body>
</html>
