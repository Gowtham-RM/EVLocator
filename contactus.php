<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EV Charging Station Locator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> <!-- Correct icon library -->
    <link rel="stylesheet" href="style.css">
    <style>
        .btn-primary {
            background-color: #f21313; /* Bright Gold */
            color: #f4f5f7; /* Deep Blue */
            font-weight: bold;
            padding: 10px 15px;
            font-size: 1.2em;
            border-radius: 50px; 
            transition: background-color 0.3s ease;
        }
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
    <header class="header">
        <a class="navbar-brand" href="#">
            <img src="logo.png" alt="Logo" style="width:50px;" class="hi">
            <h2 class="funky-text">EV Charging Station Locator</h2>
        </a>
        <nav class="navbar">
            <a href="home.php">Home</a>
            <a href="aboutus.php">Aboutus</a>
            <a href="#">Contact</a>
            <a href="signuphtml.php">
                <span class="bi bi-person-plus"></span> Sign Up
            </a>
            <a href="loginhtml.php">
                <span class="bi bi-box-arrow-in-right"></span> Login
            </a>
        </nav>
    </header>
    

    <section class="contact-section">
        <div class="container">
            <h1 class="contact-title">Contact Us</h1>
            
            <div class="contact-form">
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Your Name</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Your Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" rows="4" placeholder="Feedback" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>

            <div class="contact-info">
                <h3>Our Office</h3>
                <p>123 Green Road, Suite 456, Cityname, Country</p>

                <h3>Customer Support</h3>
                <p>Email: support@evcharginglocator.com</p>
                <p>Phone: +1 800 123 4567</p>
            </div>
        </div>
    </section>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
