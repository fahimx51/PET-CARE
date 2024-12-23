<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Found Pet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Report Found Pet</h2>
        <form action="found.php" method="post" enctype="multipart/form-data" class="mt-4">
            <div class="mb-3">
                <label for="pet_type" class="form-label">Pet Type</label>
                <select id="pet_type" name="pet_type" class="form-select" required>
                    <option value="">Select Pet Type</option>
                    <option value="Cat">Cat</option>
                    <option value="Dog">Dog</option>
                    <option value="Bird">Bird</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="pet_breed" class="form-label">Pet Breed</label>
                <select id="pet_breed" name="pet_breed" class="form-select" required>
                    <!-- Dynamic options will be loaded here -->
                </select>
            </div>
            <div class="mb-3">
                <label for="found_location" class="form-label">Found Location</label>
                <input type="text" id="found_location" name="found_location" class="form-control" required pattern="[A-Za-z0-9\s,]{1,255}">
            </div>
            <div class="mb-3">
                <label for="found_date" class="form-label">Found Date</label>
                <input type="date" id="found_date" name="found_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="pet_color" class="form-label">Pet Color</label>
                <input type="text" id="pet_color" name="pet_color" class="form-control" required pattern="[A-Za-z\s]{1,50}">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" class="form-control" required pattern="\d{10}">
            </div>
            <div class="mb-3">
                <label for="pet_photo" class="form-label">Upload Pet Photo</label>
                <input type="file" id="pet_photo" name="pet_photo" class="form-control" required accept="image/*">
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        const petTypeElement = document.getElementById('pet_type');
        const petBreedElement = document.getElementById('pet_breed');

        const breedOptions = {
            'Cat': ['Persian Cat', 'Bengal Cat', 'British Shorthair', 'Jungle Cat'],
            'Dog': ['Sarail Hound', 'German Shepherd', 'Labrador Retriever', 'Pomeranian'],
            'Bird': ['Oriental Magpie-Robin (Doyel)', 'Common Myna', 'Red-vented Bulbul', 'Rock Pigeon']
        };

        petTypeElement.addEventListener('change', function() {
            const selectedType = this.value;
            petBreedElement.innerHTML = '<option value="">Select Pet Breed</option>';

            if (selectedType && breedOptions[selectedType]) {
                breedOptions[selectedType].forEach(function(breed) {
                    const option = document.createElement('option');
                    option.value = breed;
                    option.text = breed;
                    petBreedElement.appendChild(option);
                });
            }
        });
    </script>

    <?php
    session_start();
    include('../profile/config.php'); // Correct path to config.php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $petType = $_POST['pet_type'];
        $breed = $_POST['pet_breed'];
        $foundLocation = $_POST['found_location'];
        $foundDate = $_POST['found_date'];
        $color = $_POST['pet_color'];
        $phoneNumber = $_POST['phone_number'];
        $petPhoto = $_FILES['pet_photo']['name'];
        $target = "foundpic/".basename($petPhoto);

        // Get the user's email from the session
        $userEmail = $_SESSION['email'];

        // Insert the data into the foundpet table including the user's email
        $query = "INSERT INTO foundpet (pet_type, pet_breed, pet_color, found_location, found_date, phone_number, pet_photo, user_email) 
                  VALUES ('$petType', '$breed', '$color', '$foundLocation', '$foundDate', '$phoneNumber', '$petPhoto', '$userEmail')";

        if (mysqli_query($conn, $query)) {
            // Move the uploaded photo to the target directory
            if (move_uploaded_file($_FILES['pet_photo']['tmp_name'], $target)) {
                echo "Found pet reported successfully.";
            } else {
                echo "Failed to upload the pet photo.";
            }
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
    ?>
</body>
</html>
