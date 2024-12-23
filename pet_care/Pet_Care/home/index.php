<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Pet Care || Home</title>
    <link rel="shortcut icon" href="image/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    include '../profile/config.php';
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    ?>

    <header class="header">

        <a href="../home/index.php?email=<?php echo $email; ?>" aria-label="Home" class="logo">
            <i class="fa fa-paw" style="font-size:40px;color:red"></i>
            <div class=logo-text><span>Pet</span>&nbsp;Care</div>
        </a>

        <nav class="nav">
            <ul class="nav-menu">
                <li><a href="#">Home</a></li>
                <li><a href="#">Products</a>
                    <ul class="nav-submenu" id="level-1">
                        <li><a href="../petshop/petshop.php?email=<?php echo $email; ?>"><strong>Pet Food</strong></a></li>
                        <li><a href="../petshop/petshop.php?email=<?php echo $email; ?>"><strong>Pet Medicine</strong></a></li>
                        <li><a href="../petshop/petshop.php?email=<?php echo $email; ?>"><strong>Pet Toys</strong></a></li>
                    </ul>
                </li>

                <li><a href="#">Services</a>
                    <ul class="nav-submenu">
                        <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>"><strong>Grooming</strong></a></li>
                        <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>"><strong>Boarding</strong></a></li>
                        <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>"><strong>Day Care</strong></a></li>
                        <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>"><strong>Veterinary</strong></a></li>
                        <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>"><strong>Vaccination</strong></a></li>
                        <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>"><strong>Emergency Care</strong></a></li>
                    </ul>
                </li>
                <li><a href="#">Tips</a>
                    <ul class="nav-submenu">
                        <li><a href="../tips/health_information.html"><strong>Pet Health Information</strong></a></li>
                        <li><a href="../tips/pet_breeds_information.html"><strong>Pet Breeds Information</strong></a></li>
                        <li><a href="../tips/bmi_calculator.html"><strong>Pet Care Calculator</strong></a></li>
                        <li><a href="../tips/exercise.html"><strong>Exercise and Mental Stimulation</strong></a></li>
                        <li><a href="#"><strong>Pet Care and Guides</strong></a></li>
                        <li><a href="#"><strong>Training and Socialization</strong></a></li>
                        <li><a href="#"><strong>Clean Living Environment</strong></a></li>
                        <li><a href="#"><strong>Safety Measures</strong></a></li>
                    </ul>
                </li>
                <li><a href="#">About Us</a>
                    <ul class="nav-submenu">
                        <li><a href="../about_us/our_team.html"><strong>Our Team</strong></a></li>
                        <li><a href="../about_us/contact.php?email=<?php echo $email; ?>"><strong>Contact Us</strong></a></li>
                    </ul>
                </li>

                <!-- <li><a href="#">Customer Feedback</a></li> -->

            </ul>
        </nav>


        <!-- Pet Shop -->
        <a href="../petshop/petshop.php?email=<?php echo $email; ?>" class="shop">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z" />
            </svg></a>

        <!-- Profile Picture -->
        <a href="#" aria-label="Profile Image" class="profile-a" onclick="toggleProfileMenu()">
            <?php
            include '../profile/config.php';
            $email = isset($_GET['email']) ? $_GET['email'] : '';

            if ($email) {
                $query = "SELECT profile_picture FROM users WHERE email = '$email'";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $profileImage = $row['profile_picture'];
                    echo '<img src="' . $profileImage . '" alt="Profile Image" style="width: 50px; height: 50px; border-radius: 50%;">';
                    echo '<script>function toggleProfileMenu(){ window.location.href = "../profile/profile.php?email=' . $email . '"; }</script>';
                } else {
                    echo '<img src="../home/pic/user.png" alt="Default Profile Image" width="50px" height="50px">';

                    if (!$result) {
                        echo "Error in query: " . mysqli_error($conn);
                    } else {
                        echo "No rows found for email: $email";
                    }
                }
            } else {
                echo '<img src="../home/pic/user.png" alt="Default Profile Image" width="50px" height="50px">';
                echo '<script>function toggleProfileMenu(){ window.location.href = "../profile/login.html"; }</script>';
            }
            ?>
        </a>

        <!-- Menu -->
        <div class="menu-container">
            <div class="menu-icon">
                <img src="../home/image/three-dots-vertical.png" width="40" height="40" alt="Menu Icon">
            </div>
            <ul class="nav-submenu">
                <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>"><strong>Vet Appointment</strong></a></li>
                <li><a href="../todopet/index.html?email=<?php echo $email; ?>"><strong>Pet To Do</strong></a></li>
                <li><a href="../Blog/cards.html?email=<?php echo $email; ?>"><strong>Blog</strong></a></li>
                <li><a href="../Vet List/index.html?email=<?php echo $email; ?>"><strong>Veterinary List</strong></a></li>
                <li><a href="../pet_database/index.php?email=<?php echo $email; ?>"><strong>Your Pets</strong></a></li>
                <li><a href="../adoptnow/index.php?email=<?php echo $email; ?>"><strong>Pet Adoption</strong></a></li>
                <li><a href="../lostfound/index.php?email=<?php echo $email; ?>"><strong>Lost And Found</strong></a></li>

            </ul>
        </div>


    </header><br><br><br><br>

    <!--home body-->
    <section id="home" class="home">
        <div class="home-content">
            <h1>They Need Love, Safety and Care</h1>
            <p>where your pets are our priority. Our user-friendly platform offers grooming, boarding, and expert advice tailored to your pet's needs. With a team of dedicated professionals, we ensure personalized care and attention for every furry friend. Explore heartwarming pet profiles, read testimonials, and schedule appointments effortlessly online. Trust us to provide a secure and loving environment, focusing on your pet's health and happiness. Join our community of pet lovers and experience exceptional pet care like never before.</p><br>
        </div>
    </section>

    <!--about body start-->
    <div class="container">
        <p>
        <h1>Our Service</h1>
        </p>
    </div>

    <section class="our-service" id="our-service">
        <div class="box-container">

            <a href="../Vet Appointment/index.html?email=<?php echo $email; ?>">
                <div class="box">
                    <div class="image"><img src="../home/image/grooming.png" alt="food"></div>
                    <div class="content">
                        <h3>Grooming</h3>
                        <div class="amount">Regular pet grooming is crucial for maintaining your pet's health and hygiene.</div>
                    </div>
                </div>
            </a>

            <a href="../Vet Appointment/index.html?email=<?php echo $email; ?>">
                <div class="box">
                    <div class="image"><img src="../home/image/boarding.png" alt="food"></div>
                    <div class="content">
                        <h3>Boarding</h3>
                        <div class="amount">Pet boarding facilities offer a secure and supervised environment for your pet when you're away, ensuring their safety and well-being.</div>
                    </div>
                </div>
            </a>

            <a href="../Vet Appointment/index.html?email=<?php echo $email; ?>">
                <div class="box">
                    <div class="image"><img src="../home/image/day_care.png" alt="food"></div>
                    <div class="content">
                        <h3>Day Care</h3>
                        <div class="amount">Offering socialization, exercise, and mental stimulation, pet day care ensures your furry companion receives attention and care while you're busy, fostering a well-balanced and happy pet.</div>
                    </div>
                </div>
            </a>

            <a href="../Vet Appointment/index.html?email=<?php echo $email; ?>">
                <div class="box">
                    <div class="image"><img src="../home/image/veterinary.png" alt="food"></div>
                    <div class="content">
                        <h3>Veterinary</h3>
                        <div class="amount">Vital for preventive health, timely treatments, and expert advice, veterinary care safeguards your pet's well-being, ensuring a healthy and happy life.</div>
                    </div>
                </div>
            </a>

            <a href="../Vet Appointment/index.html?email=<?php echo $email; ?>">
                <div class="box">
                    <div class="image"><img src="../home/image/vet.png" alt="food"></div>
                    <div class="content">
                        <h3>Vaccination</h3>
                        <div class="amount">Essential for disease prevention, pet vaccinations bolster their immune system, providing lifelong protection against deadly illnesses and promoting a healthier, longer life.</div>
                    </div>
                </div>
            </a>

            <a href="../Vet Appointment/index.html?email=<?php echo $email; ?>">
                <div class="box">
                    <div class="image"><img src="../home/image/emergency_care.png" alt="food"></div>
                    <div class="content">
                        <h3>Emergency Care</h3>
                        <div class="amount">Rapid and skilled emergency veterinary care is critical, ensuring immediate attention in times of illness or injury, potentially saving your pet's life and providing vital support during urgent situations.</div>
                    </div>
                </div>
            </a>

        </div>
    </section>
    <br>
    <hr>

    <section class="about" id="about">
        <div class="image"><img src="../home/image/pet-food.png" alt="dog_food"></div>
        <div class="con">
            <h1>Importance of Healthy Food</h1>
            <p>Providing nutritious, balanced meals ensures optimal physical health, strengthens their immune system, promotes shiny coats, and enhances overall vitality, supporting a longer and happier life for your beloved pets.</p><br>
            <a href="#" class="btn">read more</a>
        </div>
    </section><br>

    <div class="container">
        <p>
        <h1>Pet Foods</h1>
        </p>
    </div>

    <section class="pet-food" id="pet-food">
        <div class="box-con">

            <div class="box-f">
                <div class="image"><img src="../home/image/f2.jpg" alt="food"></div>
                <div class="content">
                    <h3>Bonnie Cat Food – Beef Cocktail (500g)</h3>
                    <div class="amount">295-TK</div><br>
                    <a href="#" class="btn">Add To Cart</a>
                </div>
            </div>

            <div class="box-f">
                <div class="image"><img src="../home/image/f3.jpg" alt="food"></div>
                <div class="content">
                    <h3>Brit Premium by Nature Cat Can – Chicken with Rice (200g)</h3>
                    <div class="amount">190</div><br>
                    <a href="#" class="btn">Add To Cart</a>
                </div>
            </div>

            <div class="box-f">
                <div class="image"><img src="../home/image/f4.jpg" alt="food"></div>
                <div class="content">
                    <h3>Bonnie Dog Can – Chicken Chunks in Gravy (400g)</h3>
                    <div class="amount">155-TK</div><br>
                    <a href="#" class="btn">Add To Cart</a>
                </div>
            </div>
            <div class="box-f">
                <div class="image"><img src="../home/image/f1.jpg" alt="food"></div>
                <div class="content">
                    <h3>Spectrum Hairball34 Cat Food – Chicken Formula (2kg)</h3>
                    <div class="amount">1755-TK</div><br>
                    <a href="#" class="btn">Add To Cart</a>
                </div>
            </div>

            <div class="box-f">
                <div class="image"><img src="../home/image/f5.jpg" alt="food"></div>
                <div class="content">
                    <h3>Brit Pate & Meat Dog Can – Beef (400g)</h3>
                    <div class="amount">200-TK</div><br>
                    <a href="#" class="btn">Add To Cart</a>
                </div>
            </div>

    </section>

    <div class="container">
        <p>
        <h1>Discover Our Team</h1>
        </p>
    </div>

    <section class="our-service" id="our-service">
        <div class="box-container">

            <div class="box">
                <div class="image"><img src="../home/image/d1.png" alt="food"></div>
                <div class="content">
                    <h3>Dr. Jason Berg</h3>
                    <div class="amount">Board Certified in Veterinary Internal Medicine and Neurology</div><br>

                </div>
            </div>

            <div class="box">
                <div class="image"><img src="../home/image/d2.png" alt="food"></div>
                <div class="content">
                    <h3>Dr. Jonathan Goodwin</h3>
                    <div class="amount">Board Certified in Veterinary Cardiology</div><br>

                </div>
            </div>

            <div class="box">
                <div class="image"><img src="../home/image/d3.png" alt="food"></div>
                <div class="content">
                    <h3>Dr. Laura Ateca</h3>
                    <div class="amount">Board Certified in Emergency and Critical Care</div><br>

                </div>
            </div>

            <div class="box">
                <div class="image"><img src="../home/image/d1.png" alt="food"></div>
                <div class="content">
                    <h3>Dr. Richard Joseph</h3>
                    <div class="amount">Board Certified in Veterinary Neurology</div><br>

                </div>
            </div>

            <div class="box">
                <div class="image"><img src="../home/image/d2.png" alt="food"></div>
                <div class="content">
                    <h3>Dr. Zijin Zhou</h3>
                    <div class="amount">Board Certified in Veterinary Dermatology</div><br>

                </div>
            </div>
        </div><br>

        <div class="ab"><a href="../about_us/our_team.html" class="btn">View More</a></div><br><br>
    </section><br>
    <hr>

    <div class="container">
        <h1>GENERAL PET CARE</h1>
    </div>

    <section class="about" id="about">

        <div class="image"><img src="../home/image/emergency-care.jpg" alt="dog_food"></div>
        <div class="con">
            <h1>Emergency Care for Your Pet</h1>
            <p>Unfortunately, accidents do happen. When a medical emergency befalls our furry friends, pet parents may find it difficult to make rational decisions, especially if something occurs during the middle of the night. That’s why it’s crucial to have an emergency plan in place—before you need it.</p><br>
            <a href="#" class="btn">read more</a>
        </div>
    </section><br>

    <section class="about" id="about">
        <div class="image"><img src="../home/image/travel-safety-tips.jpg" alt="dog_food"></div>
        <div class="con">
            <h1>Travel Safety Tips</h1>
            <p>For some pet parents, a trip is no fun if the four-legged members of the family can’t come along. But traveling can be highly stressful, both for you and your pets. If you’re planning to take a trip with pets in tow, we have some tips to help ensure a safe and comfortable journey for everyone.
                Remember, no matter where you’re headed or how you plan to get there, make sure your pet is microchipped for identification and wears a collar and tag imprinted with your name, phone number and any relevant contact information. It’s a good idea for your pet’s collar to also include a temporary travel tag with your cell phone and destination phone number for the duration of your trip.</p><br>
            <a href="#" class="btn">read more</a><br><br>
        </div>
    </section><br>

    <section class="about" id="about">
        <div class="image"><img src="../home/image/pet-care_vaccinations_main-image.jpg" alt="dog_food"></div>
        <div class="con">
            <h1>Vaccinations for Your Pet</h1>
            <p>Vaccines help prevent many illnesses that affect pets. Vaccinating your pet has long been considered one of the easiest ways to help him live a long, healthy life. Not only are there different vaccines for different diseases, there are different types and combinations of vaccines. Vaccination is a procedure that has risks and benefits that must be weighed for every pet relative to his lifestyle and health. Your veterinarian can determine a vaccination regime that will provide the safest and best protection for your individual animal.</p><br>
            <a href="#" class="btn">read more</a>
        </div>
    </section><br>

    <div class="s"><a href="#" class="btn">View More</a></div><br>
    <hr>

    <!--about body end-->

    <!-- Footer -->
    <div class="card">
        <section class="footer">
            <div class="footer-row">

                <div class="footer-col">
                    <h4>Info</h4>
                    <ul class="links">
                        <li><a href="../about_us/our_team.html">About Us</a></li>
                        <li><a href="../about_us/contact.php?email=<?php echo $email; ?>">Emergency Service</a></li>
                        <li><a href="../Vet Appointment/index.html?email=<?php echo $email; ?>">Service</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Get Help</h4>
                    <ul class="links">
                        <li><a href="../petshop/petshop.php?email=<?php echo $email; ?>">Shop</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <ul class="links">
                        <li><a href="#">Terms and Conditions</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

            </div>

        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jolty/dist/jolty.esm.min.js"></script>
    <script src="pet_care.js" type="module"></script>
    <!-- <script src="script.js"></script> -->
</body>

</html>