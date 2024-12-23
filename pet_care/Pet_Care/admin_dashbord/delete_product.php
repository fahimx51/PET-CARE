<?php

include_once 'config.php';


$message = "";
$redirectUrl = "pet_food_list.php"; 

// Check if product ID is set
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $sql = "SELECT image FROM products WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $imagePath = $row['image'];

        
        $sql_delete = "DELETE FROM products WHERE id='$id'";
        if (mysqli_query($conn, $sql_delete)) {
           
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            $message = "Product deleted successfully.";
        } else {
            $message = "Error deleting product: " . mysqli_error($conn);
        }
    } else {
        $message = "Product not found.";
    }
} else {
    $message = "Invalid product ID.";
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <script>
       
        function displayPopupAndRedirect(message, redirectUrl) {
            alert(message); 
            window.location.href = redirectUrl; 
        }


        window.onload = function () {
            displayPopupAndRedirect("<?php echo $message; ?>", "<?php echo $redirectUrl; ?>");
        };
    </script>
</head>
<body>
</body>
</html>
