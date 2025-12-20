<?php
    // Start the session at the very beginning of the file
    session_start();
    $isLoggedIn = isset($_SESSION['username']);
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>EV Charging Station Locator</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css">
        <style>
            /* Add your existing styles here */
            <style>
            .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 20px;
        background-color: #216fbd; /* Keep this blue for contrast */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .navbar a {
        text-decoration: none;
        color: #fff; /* Ensure this is contrasting against the header background */
        font-size: 16px;
        transition: color 0.3s;
    }

    .navbar a:hover {
        color: #ffcc00; /* Bright Gold for hover state */
    }

            .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 20px;
                background-color: #216fbd; /* Adjust background color as needed */
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            }

            .brand-container {
                display: flex;
                align-items: center;
            }

            .brand-container h2 {
                margin-left: 10px; /* Adjust spacing between logo and text */
            }

            .funky-text {
                font-family: 'Lobster', cursive;
                font-size: 1.8em; /* Adjust size as needed */
                color: #ffcc00;
                text-shadow: 2px 2px 0 #000;
            }

            .navbar {
                display: flex;
                gap: 15px;
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

            /* Hero Section Styles */
            .hero-section {
                text-align: center;
                padding: 60px 20px;
                background-size: cover;
                background-position: center;
                transition: background-image 0.5s ease;
            }

            .hero-section .btn-primary {
                background-color: #ffcc00; /* Bright Gold */
                color: #002b4f; /* Deep Blue */
                font-weight: bold;
                padding: 15px 30px;
                font-size: 1.2em;
                border-radius: 50px; 
                transition: background-color 0.3s ease;
            }

            .hero-section .btn-primary:hover {
                background-color: #002b4f; /* Deep Blue */
                color: #fff;
            }

            /* Footer Styling */
            footer {
                background-color: #2c3e50; /* Deep Navy Blue for a bold footer */
                color: #ffffff; /* White text for high contrast */
                padding: 40px 0;
                border-top: 2px solid #ffcc00; /* Bright Gold border for contrast */
            }

            .footer-links a {
                color: #ffcc00; /* Bright Gold text */
                text-decoration: none;
                margin-right: 15px;
                transition: color 0.3s ease-in-out;
            }

            .footer-links a:hover {
                color: #ffffff; /* White text on hover */
            }

            .social-icons a {
                color: #ffcc00;
                font-size: 1.5em;
                margin: 0 10px;
                transition: color 0.3s ease-in-out;
            }

            .social-icons a:hover {
                color: #ffffff; /* Blue color */
            }

            .footer-bottom {
                margin-top: 20px;
                text-align: center;
                font-size: 0.9em;
                color: #cccccc;
            }

            @media (max-width: 576px) {
                .footer-links,
                .social-icons {
                    text-align: center;
                    margin-top: 20px;
                }
            }
            span.book {
                color: #000000; /* Set the text color to white */
                padding: 5px; /* Add padding inside the span */
                border-radius: 5px; /* Rounded corners */
                font-weight: bold; /* Make text bold */
            }
        </style>
    </head>
    <body>
        <header class="header">
            <div class="brand-container">
                <a class="navbar-brand" href="#">
                    <img src="logo.PNG" alt="Logo" style="width:50px;" class="hi">
                </a>
                <h2 class="funky-text">EV Charging Station Locator</h2>
            </div>
            <nav class="navbar">
                <a href="home.php">Home</a>
                <a href="station.php">Stations</a>
                <a href="contactus.php">Contact</a>
                <a href="aboutus.php">About us</a>
                <?php if (isset($_SESSION['username'])): ?>
                    <span class="book">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <a href="logout.php" onclick="return confirmLogout()">
                    <span class="bi bi-box-arrow-right"></span> Logout
                    </a>

            <script>
                // Function to confirm logout with an alert
                function confirmLogout() {
                // Display an alert message to confirm logout
                const userConfirmed = confirm("Are you sure you want to logout?");
                // If the user clicks "OK", the logout action will proceed, otherwise it will be canceled
                return userConfirmed; 
                }
            </script>
                    
                <?php else: ?>
                    <a href="signuphtml.php">
                        <span class="bi bi-person-plus"></span> Sign Up
                    </a>
                    
                    <span class="bi bi-box-arrow-in-right"> <a href="#" id="loginBtn">Login</a>
    

                    <div class="modal" id="loginModal">
        <div class="modal-content">
            <button id="adminLogin">Admin Login</button>
            <button id="userLogin">User Login</button>
            <br>
            <button id="closeModal" class="close-button">Close</button>
        </div>
    </div>

    <script>
        const loginBtn = document.getElementById('loginBtn');
        const loginModal = document.getElementById('loginModal');
        const closeModal = document.getElementById('closeModal');

        loginBtn.addEventListener('click', () => {
            loginModal.style.display = 'flex';
        });

        closeModal.addEventListener('click', () => {
            loginModal.style.display = 'none';
        });

        // Redirect to Admin Dashboard
        document.getElementById('adminLogin').addEventListener('click', () => {
            window.location.href = 'adminlogin.php';  // Replace with actual Admin page URL
        });

        // Redirect to User Dashboard
        document.getElementById('userLogin').addEventListener('click', () => {
            window.location.href = 'loginhtml.php';  // Replace with actual User page URL
        });

        // Close modal when clicking outside
        window.addEventListener('click', (event) => {
            if (event.target === loginModal) {
                loginModal.style.display = 'none';
            }
        });
    </script>

                <?php endif; ?>
            </nav>
        </header>
        
    
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container text-center">
                <h1 class="display-4">Welcome</h1>
                <h2>Find EV Charging Station</h2>
                <a class="btn btn-primary btn-lg"  onclick="return redirectToMap()">Click Here</a>
                <script>
        function redirectToMap() {
            <?php if (isset($_SESSION['username'])): ?>
                // If the user is logged in, redirect to map2.php
                window.open("map2.php", "_blank");
            <?php else: ?>
                // If the user is not logged in, alert and stop redirection
                alert("You must be logged in to access this page.");
            <?php endif; ?>
        }
    </script>
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
                        <a href="rating.php">RateUs</a>
                    </div>

                    <!-- Footer Bottom Text -->
                    <div class="col-md-12 text-center footer-bottom">
                        <p>&copy; 2024 EV Charging Station Locator. All Rights Reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            function showLoadingScreen(event) {
                event.preventDefault(); // Prevent immediate navigation
                const loader = document.createElement('div');
                loader.style.position = 'fixed';
                loader.style.top = '0';
                loader.style.left = '0';
                loader.style.width = '100%';
                loader.style.height = '100%';
                loader.style.backgroundColor = 'rgba(255, 255, 255, 0.8)';
                loader.style.display = 'flex';
                loader.style.justifyContent = 'center';
                loader.style.alignItems = 'center';
                loader.innerHTML = '<h2>Logging out...</h2>';
                document.body.appendChild(loader);
                setTimeout(() => {
                    window.location.href = event.target.href; // Proceed to logout
                }, 1500); // Add a short delay for loading effect
            }
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const images = ['b4.png', 'b2.jpg']; // Add image paths
            let index = 0;
            const heroSection = document.querySelector('.hero-section');
        
            setInterval(() => {
                heroSection.style.backgroundImage = `url(${images[index]})`;
                index = (index + 1) % images.length; // Loop through images
            }, 2000); // Change every 5 seconds
        </script> 

    </body>
    </html>
