<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Care || Update Profile</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.20.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel='stylesheet' href="update.css">
</head>
<body>
    <div class="card">
        <div class="card-body">
            <?php
            include 'config.php';

            $id = $_GET['id'];

            
            $query = "SELECT * FROM users WHERE id = '$id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                echo "Profile not found.";
                exit();
            }
            ?>

            <h1 class="card-title">Update Profile</h1>
            <form action="updateA.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                
            <label for="profile_picture" class="form-label"><b>Profile Picture:</b></label>
            <div class="profile-picture-container">
                    
                    <img id="profileImagePreview" src="<?php echo $row['profile_picture']; ?>" alt="Profile Picture">
                </div>

                <div class="upload-btn-container text-center">
                    <label for="profile_picture_upload" class="btn btn-secondary">Upload</label>
                    <input type="file" name="profile_picture" class="form-control" id="profile_picture_upload" accept="image/*" style="display: none;" onchange="previewImage(this)">
                    <small class="text-muted">Accepted formats: JPEG, PNG, GIF</small>
                </div>
                
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" readonly value="<?php echo $row['email']; ?>" required>
                </div>

                <div class="form-group mb-3">
                    <label for="address" class="form-label">Address:</label>
                    <textarea name="address" class="form-control" required><?php echo $row['address']; ?></textarea>
                </div>

                <div class="text-center">
                    <input type="submit" name="update" value="Update" class="btn btn-primary">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage(input) {
            var preview = document.getElementById('profileImagePreview');
            var file = input.files[0];
            var reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
            };

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "<?php echo $row['profile_picture']; ?>";
            }
        }
    </script>
</body>
</html>