<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - EV Charging Station Locator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Correct icon library -->
    <link rel="stylesheet" href="style.css">
    <style>
         .header {
    display: flex;
    align-items: center;
    padding: 10px 20px;
    background-color: #216fbd; /* Adjust background color as needed */
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.header .navbar-brand {
    display: flex;
    align-items: center;
    gap: 10px; /* Adjust the spacing between logo and text */
}

.funky-text {
    font-family: 'Lobster', cursive;
    font-size: 1.8em; /* Adjust size as needed */
    color: #ffcc00;
    text-shadow: 2px 2px 0 #000;
    margin: 0; /* Remove unnecessary margin */
}

        .navbar {
            display: flex;
            gap: 15px;
        }
        .funky-text {
            font-family: 'Lobster', cursive;
            font-size: 1.8em; /* Adjust size as needed */
            color: #ffcc00;
            text-shadow: 2px 2px 0 #000;
        }
        .navbar a {
            text-decoration: none;
            color: #fff; /* Link color */
            font-size: 16px;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #ffcc00; /* Hover color */
        }

        .hi {
            border-radius: 50%;
            transition: transform 2s;
        }

        .navbar-brand img:hover {
            transform: rotate(360deg);
        }
        /* Styling for contact section */
        .contact-section {
            padding: 60px 0;
            background-color: #f4f4f4;
        }
        .contact-title {
            font-family: 'Lobster', cursive;
            font-size: 2.5em;
            color: #ffcc00;
            text-align: center;
            margin-bottom: 30px;
        }
        .contact-form {
            margin-bottom: 40px;
        }
        .contact-info h3 {
            color: #002b4f;
        }
        .contact-info p {
            color: #333;
        }
        .contact-form input, .contact-form textarea {
            border-radius: 5px;
        }

        /* Footer Section Styling */
        footer {
            background-color: #2c3e50;
            color: #ffffff;
            padding: 40px 0;
            border-top: 2px solid #ffcc00;
        }
        .footer-links a {
            color: #ffcc00;
            text-decoration: none;
            margin-right: 15px;
            transition: color 0.3s ease-in-out;
        }
        .footer-links a:hover {
            color: #ffffff;
        }
        .social-icons a {
            font-size: 2em; /* Adjusted icon size */
            color: #ffcc00;
            margin: 0 15px;
            transition: color 0.3s ease-in-out;
        }
        .social-icons a:hover {
            color: #ffffff;
        }
        .footer-logo img {
            width: 50px;
            margin-bottom: 10px;
        }
        .footer-bottom {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #cccccc;
        }
    </style>
</head>
<body>
   <!-- Header Section -->
   <header class="header">
    <a class="navbar-brand" href="#">
        <img src="logo.PNG" alt="Logo" style="width:50px;" class="hi">
        <h2 class="funky-text">EV Charging Station Locator</h2>
    </a>
    <nav class="navbar">
        <a href="home.php">Home</a>
        <a href="#service">Aboutus</a>
        <a href="contactus.php">Contact</a>
        <?php if (isset($_SESSION['username'])): ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php">
                    <span class="bi bi-box-arrow-right"></span> Logout
                </a>
            <?php else: ?>
                <a href="signuphtml.php">
                    <span class="bi bi-person-plus"></span> Sign Up
                </a>
                <a href="loginhtml.php">
                    <span class="bi bi-box-arrow-in-right"></span> Login
                </a>
            <?php endif; ?>
    </nav>
</header>

    <!-- About Us Section -->
    <section class="about-section">
        <div class="container">
            <h1 class="about-title">About Us</h1>
            <p class="about-text">
                Welcome to the EV Charging Station Locator, a platform created to simplify the experience of owning and operating electric vehicles (EVs). As the world transitions to cleaner energy, we believe that easy access to EV charging stations is essential for driving adoption. Our platform helps EV owners find nearby stations, check real-time availability, and plan longer trips without worrying about charging options.
            </p>
            <div class="mission-section">
                <h2 class="subheading">Our Mission</h2>
                <p class="about-text">
                    Our mission is to empower eco-conscious drivers by making EV charging as accessible, reliable, and convenient as possible. Whether you're on the road or looking for a station close to home, we are dedicated to providing accurate, up-to-date information about charging locations. Our goal is to remove the barriers to EV adoption and to help the world transition to cleaner energy for a sustainable future.
                </p>
            </div>

            <div class="vision-section">
                <h2 class="subheading">Our Vision</h2>
                <p class="about-text">
                    We envision a world where electric vehicles are the norm, and every driver can easily find a charging station anywhere, anytime. Our vision extends beyond just locating charging stations — we aim to be a key player in the larger movement towards sustainable energy solutions. By supporting the growth of EV infrastructure, we believe that together we can create a cleaner, more efficient, and more environmentally friendly future for all.
                </p>
            </div>

            <div class="values-section">
                <h2 class="subheading">Our Values</h2>
                <p class="about-text">
                    At EV Charging Station Locator, we are guided by our core values:
                    <ul>
                        <li><strong>Innovation:</strong> We embrace new technologies to improve the user experience and make the future of transportation smarter.</li>
                        <li><strong>Integrity:</strong> We ensure transparency in all our services and provide our users with honest, real-time information.</li>
                        <li><strong>Sustainability:</strong> We are committed to reducing our carbon footprint and support green initiatives to protect the planet.</li>
                        <li><strong>Customer-Centricity:</strong> Our users' needs are at the heart of everything we do. We prioritize accessibility and ease-of-use in our platform.</li>
                    </ul>
                </p>
            </div>

            <p class="about-text">
                Join us in shaping the future of sustainable driving and driving the transition towards a cleaner, greener world. We are constantly working to expand our network of charging stations and improve the platform’s features to serve you better.
            </p>
        </div>
    </section>

    <!-- Footer Section -->
    <footer>
        <div class="container">
            <div class="row">
                <!-- Social Icons -->
                <div class="col-md-12 text-center social-icons mb-3">
                    <a href="#" target="_blank"><i class="bi bi-facebook"></i></a>
                    <a href="#" target="_blank"><i class="bi bi-twitter"></i></a>
                    <a href="#" target="_blank"><i class="bi bi-instagram"></i></a>
                    <a href="#" target="_blank"><i class="bi bi-telegram"></i></a>
                    <a href="#" target="_blank"><i class="bi bi-youtube"></i></a>
                </div>

                <!-- Footer Links -->
                <div class="col-md-12 text-center footer-links mb-3">
                    <a href="#">Privacy Statement</a>
                    <a href="#">Terms and Conditions</a>
                    <a href="aboutus.php">About Us</a>
                    <a href="contactus.php">Contact Us</a>
                    <a href="#">Service</a>
                </div>

                <!-- Footer Bottom Text -->
                <div class="col-md-12 text-center footer-bottom">
                    <p>&copy; 2024 EV Charging Station Locator. All Rights Reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
