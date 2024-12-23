<?php
include 'config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['id'];

$sql = "SELECT * FROM pets WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($row) {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Pet Information</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background-image: url('../home/image/pet1.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 400px;
            text-align: start;
        }

        h1 {
            color: gold;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: green;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="card">
    <h1>Update Pet Information</h1>

    <form method="post">
        <label for="pet_type">Pet Type:</label>
        <select name="pet_type" value="<?php echo $row['pet_type']; ?>">
            <option value="dog">Dog</option>
            <option value="cat">Cat</option>
        </select><br>

        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>" required><br>

        <label for="breed">Breed:</label>
        <input type="text" name="breed" value="<?php echo $row['breed']; ?>" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" value="<?php echo $row['age']; ?>" required><br>

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <input type="submit" name="update" value="Update Pet">
    </form>
</div>

</body>
</html>

<?php
} else {
    echo "Pet not found.";
}

if (isset($_POST['update'])) {
    $pet_type = mysqli_real_escape_string($conn, $_POST['pet_type']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $breed = mysqli_real_escape_string($conn, $_POST['breed']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $sql = "UPDATE pets SET pet_type='$pet_type', name='$name', breed='$breed', age='$age' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?updated=true");
        exit();
    } else {
        echo "Error updating pet: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
