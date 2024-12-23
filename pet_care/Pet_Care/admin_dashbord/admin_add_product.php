<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Product</title>
  <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
      padding: 20px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    img {
      background-position: center;
    }

    form {
      max-width: 600px;
      margin: 0 auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    input[type="number"] {
      width: calc(100% - 20px);
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
    }

    input[type="file"] {
      margin-top: 10px;
    }

    input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    .message {
      margin-top: 20px;
      padding: 10px;
      background-color: #f2f2f2;
      border-left: 4px solid #4CAF50;
    }
  </style>
</head>

<body>
  <h2>Add Product</h2>
  <img src="../admin_dashbord/admin_img/pet-food.gif">
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <label for="name">Product Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="price">Price:</label><br>
    <input type="number" id="price" name="price" min="0" step="0.01" required><br><br>

    <label for="description">Description:</label><br>
    <textarea id="description" name="description" rows="4" required></textarea><br><br>

    <label for="image">Image:</label><br>
    <input type="file" id="image" name="image" required><br><br>

    <input type="submit" value="Submit">
  </form>

  <?php

  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "petcare";

  $conn = new mysqli($servername, $username, $password, $dbname);


  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    // Check if image file is selected
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
      $target_dir = "../petshop/img/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
      $image = $target_file;

      // Check if file already exists
      if (file_exists($target_file)) {
        echo '<div class="message">Sorry, file already exists.</div>';
      } else {
        // Try to upload file
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
          echo '<div class="message">The file ' . htmlspecialchars(basename($_FILES["image"]["name"])) . ' has been uploaded.</div>';
        } else {
          echo '<div class="message">Sorry, there was an error uploading your file.</div>';
        }
      }
    } else {
      echo '<div class="message">No image selected.</div>';
    }

    // Inserting product into the database
    $sql = "INSERT INTO products (name, price, description, image) VALUES ('$name', '$price', '$description', '$image')";
    if ($conn->query($sql) === TRUE) {
      echo '<div class="message">New product added successfully</div>';
    } else {
      echo '<div class="message">Error: ' . $sql . '<br>' . $conn->error . '</div>';
    }
  }


  $conn->close();
  ?>
</body>

</html>