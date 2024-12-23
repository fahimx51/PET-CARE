<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lost & Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
</head>
<body>

<?php
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    header("Location: ../profile/login.html");
    exit();
}
?>

    <div class="container mt-5 text-center">
        <h1>Lost & Found</h1>
        <div class="row mt-4">
            <div class="col-md-6">
                <a href="lost.php?email=<?php echo $email; ?>" class="btn btn-primary btn-lg w-100 mb-3">Lost Your Pet?</a>
            </div>
            <div class="col-md-6">
                <a href="search_lost.php" class="btn btn-secondary btn-lg w-100 mb-3">Search Lost Pets</a>
            </div>
            <div class="col-md-6">
                <a href="found.php?email=<?php echo $email; ?>" class="btn btn-success btn-lg w-100 mb-3">Found a Pet?</a>
            </div>
            <div class="col-md-6">
                <a href="search_found.php" class="btn btn-warning btn-lg w-100 mb-3">Search Found Pets</a>
            </div>
        </div>
    </div>
</body>
</html>
