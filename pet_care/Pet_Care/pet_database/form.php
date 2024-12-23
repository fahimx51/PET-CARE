<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Pet</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <style>
        body {
            font-family: sans-serif;
            margin: 100px;
            background-color: #f5f5f5;
            background-image: url('../home/image/pet1.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }

        form {
            background-color: white;
            border-radius: 5px;
            padding: 20px;
            margin: 0 auto;
            width: 400px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-size: 18px;
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        select, input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="file"] {
            display: none;
        }

        .upload-btn-container {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .btn {
            background-color: #2ecc71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-right: 10px;
        }

        .btn:hover {
            background-color: #27ae60;
        }

        .image-preview {
            width: 100%;
            height: 150px;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #eee;
        }

        .image-preview img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        input[type="submit"] {
            background-color: green;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: darkgreen;
        }

        .text-muted {
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>

<form action="index.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <h1>Pet Information</h1>
    <label for="petImageUpload">Pet Image:</label>
    <div class="image-preview" id="imagePreview">
        <img id="imagePreviewSrc" src="../pet_database/img/plus-circle.svg" alt="Image Preview">
    </div>
    <div class="upload-btn-container">
        <label for="petImageUpload" class="btn btn-secondary">Upload</label>
        <input type="file" id="petImageUpload" name="petImage" accept="image/*" onchange="previewImage(event)" required>
    </div>
    <small class="text-muted">Accepted formats: JPEG, PNG, GIF</small><br>

    <label for="pet_type">Pet Type:</label>
    <select name="pet_type" id="pet_type" required>
        <option value="dog">Dog</option>
        <option value="cat">Cat</option>
    </select><br>

    <label for="name">Name:</label>
    <input type="text" name="name" id="name" required><br>

    <label for="breed">Breed:</label>
    <input type="text" name="breed" id="breed" required><br>

    <label for="age">Age:</label>
    <input type="number" name="age" id="age" required><br>

    <input type="submit" name="submit" value="Add Pet">
</form>

<script>
    // Preview image before upload
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreviewSrc').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    }

    // Form validation
    function validateForm() {
        const petImage = document.getElementById('petImageUpload').value;
        if (!petImage) {
            alert('Please upload a pet image.');
            return false;
        }
        return true;
    }
</script>
</body>
</html>
