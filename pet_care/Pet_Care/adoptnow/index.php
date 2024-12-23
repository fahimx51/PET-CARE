<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="https://kit.fontawesome.com/190e245c5e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style/reset.css">
  <link rel="stylesheet" href="style/style.css">
  <link rel="stylesheet" href="style/responsive.css">
  <title>Adoption Page</title>
</head>


<body>

<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['email'])) {
    // User is logged in, fetch user's email (assuming email is stored in session)
    $email = $_SESSION['email'];
} 
else 
{
    header("Location: ../profile/login.html");
    exit();
}
?>

  <div class="container">
    <header class="header">
      <nav class="nav">
        <a class="logo" href="">
          <span class="fas fa-paw"></span> PET CARE
        </a>

        <input type="checkbox" id="check-menu">

        <div class="burger-menu">
          <label for="check-menu">

            <svg class="burger" width="51" height="51" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.375 14.875H44.625" stroke="#efef42" stroke-width="3.5" stroke-linecap="round"/>
              <path d="M6.375 25.5H44.625" stroke="#efef42" stroke-width="3.5" stroke-linecap="round"/>
              <path d="M6.37488 36.0625H28.0002" stroke="#efef42" stroke-width="3.5" stroke-linecap="round"/>
            </svg>

            <svg class="close" width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M23 23L3 3" stroke="#f16d6d" stroke-width="5.5" stroke-linecap="round"/>
              <path d="M3 23L23 3" stroke="#f16d6d" stroke-width="5.5" stroke-linecap="round"/>
            </svg>

          </label>
        </div>
 
        <ul class="nav__links">
          <li>
            <a class="nav__link" href="#home">Home</a>
          </li>

          <li>
            <a class="nav__link nav__link--bgc-white" href="#adoption">Adoption</a>
          </li>

          <li>
            <a id="adoptLink" class="nav__link nav__link--bgc-white" href="adopt.html">Pets Up for Adoption?</a>
          </li>
          
        </ul>
      </nav>

    </header>

    <main>

      <section class="homepage" id="home">
        <div class="homepage__content">

          <h1 class="title">
            Change <strong>lives</strong>
          </h1>
          <p class="homepage__text">
            You won't change the world by adopting a pet, but you will change the world for that pet
          </p>
          <a class="btn" href="#adoption">Adopt</a>
        </div> 
      </section>

      <section class="adoption" id="adoption">
        <h2 class="title title--medium">
          <strong>Adoption</strong>
        </h2>

        <div class="search-container">
          <input type="text" id="searchInput" class="search-input" placeholder="Search for pets...">
          <button id="searchButton" class="search-button">Search</button>
          <button id="resetButton" class="reset-button">Reset</button>
        </div>

        <div class="adoption__cards" id="adoption-cards">
        </div> 
      </section>
    </main>
  </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const userEmail = "<?php echo $email; ?>"; // Fetch the logged-in user's email from PHP

    fetch('get-pets.php')
        .then(response => response.json())
        .then(data => {
            const adoptionCards = document.getElementById('adoption-cards');
            renderCards(data, adoptionCards);

            document.getElementById('searchButton').addEventListener('click', () => {
                const searchInput = document.getElementById('searchInput').value.toLowerCase();
                const filteredData = data.filter(pet => {
                    return pet.petName.toLowerCase().includes(searchInput) ||
                        pet.petType.toLowerCase().includes(searchInput) ||
                        pet.breed.toLowerCase().includes(searchInput) ||
                        pet.age.toString().includes(searchInput) ||
                        pet.color.toLowerCase().includes(searchInput) ||
                        pet.location.toLowerCase().includes(searchInput);
                });
                renderCards(filteredData, adoptionCards);
            });

            document.getElementById('resetButton').addEventListener('click', () => {
                document.getElementById('searchInput').value = '';
                renderCards(data, adoptionCards);
            });
        })
        .catch(error => {
            console.error('Error fetching pets:', error);
        });

    function renderCards(data, container) {
        container.innerHTML = '';
        data.forEach(pet => {
            const card = document.createElement('div');
            card.classList.add('card');
            card.innerHTML = `
                <img class="card__img" src="uploads/${pet.photo}" alt="Image of a cute pet named ${pet.petName}">
                <div class="card__content">
                    <h2 class="card__pet-name">${pet.petName}</h2>
                    <div class="card__pet-info">
                        <p><strong>Type:</strong> ${pet.petType}</p>
                        <p><strong>Breed:</strong> ${pet.breed}</p>
                        <p><strong>Age:</strong> ${pet.age} months</p>
                        <p><strong>Color:</strong> ${pet.color}</p>
                        <p><strong>Location:</strong> ${pet.location}</p>
                        <p><strong>Vaccinated:</strong> ${pet.vaccinated}</p>
                        <p><strong>Neutered/Spayed:</strong> ${pet.neutered}</p>
                    </div>
                    <button class="btn btn--small ask-to-adopt" data-pet-id="${pet.id}" 
                        ${pet.userEmail === userEmail || pet.requestStatus === 'pending' ? 'disabled' : ''}>
                        Ask to Adopt
                    </button>
                </div>
            `;
            container.appendChild(card);
        });

        document.querySelectorAll('.ask-to-adopt').forEach(button => {
            button.addEventListener('click', function () {
                const petId = this.getAttribute('data-pet-id');
                fetch('request-adoption.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ petId: petId, requesterEmail: userEmail })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        alert('Request to adopt ' + result.petName + ' has been sent to the admin for approval.');
                        this.disabled = true;
                    } else {
                        alert('Error: ' + result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    }
});
</script>

        
        
</body>
</html>
