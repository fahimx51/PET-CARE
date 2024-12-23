<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
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
/* Add border to product cards */
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
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.search-form {
    margin-left: auto;
}
</style>
</head>
<body>
<header>
  <h1>Pet Supply Shop</h1>
  <nav>
    <ul>
      <li><a href="petshop.php">Shop</a></li>
      <li><a href="cart.php">Cart</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <form class="search-form" method="get" action="petshop.php">
      <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search for products">
      <input type="submit" value="Search">
    </form>
  </nav>
</header>
<main>
  <div class="product-grid">
    <?php
    if (!empty($products)) {
        foreach ($products as $product) {
            echo "<div class='product-card'>";
            echo "<img src='" . $product['image'] . "' alt='" . $product['name'] . "'>";
            echo "<h2>" . $product['name'] . "</h2>";
            echo "<p>Price: $" . $product['price'] . "</p>";
            echo "<form method='post' action='cart.php'>";
            echo "<input type='hidden' name='product_id' value='" . $product['id'] . "'>";
            echo "<input type='submit' name='add_to_cart' value='Add to Cart'>";
            echo "</form>";
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
