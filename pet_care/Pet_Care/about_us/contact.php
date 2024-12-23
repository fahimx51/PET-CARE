<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: ../profile/login.html");
    exit();
}

include_once "fetch_user_name.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Pet Care Center</title>
    <link rel="shortcut icon" href="../home/image/logo.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="contact.css">
</head>

<body>
    
    <header>
        <h1>Pet Care Center</h1>
        <p class="h">Your Pets Deserve the Best Care</p>
    </header>
    
    <section>
        <h2 class="t">Contact Us</h2>
        <hr>
        
        <form id="contactForm" action="submit_message.php" method="POST">

            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($_SESSION['name']) ?>" readonly>
    
            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['email']) ?>" readonly>
    
            <label for="message">Your Message:</label>
            <textarea id="message" name="message" rows="4" placeholder="Type your message here:" required></textarea>
    
            <button type="submit">Submit</button>

        </form>
        <hr>

        <h2 class="p">Our Location and Contacts</h2>
        <div class="contact-card">

            <div class="card">
                <h3>Main Office</h3>
                <hr>
                <p>Sylhet</p>
                <p>Amborkhana, H-A-26/32</p>
                <p><i class="fa fa-phone"></i> +880 17******12</p>
            </div>
    
            <div class="card">
                <h3>Emergency Line</h3>
                <hr>
                <p>For emergencies, contact us at</p>
                <p><i class="fa fa-phone"></i> +880 13*******52</p>
            </div>
    
            <div class="card">
                <h3>Email Us</h3>
                <hr>
                <p><i class="fa fa-envelope"></i> info@petcarecenter.com</p>
                <p>admin@petcarecenter.com</p>
            </div>

        </div>
    </section>
</body>
</html>
