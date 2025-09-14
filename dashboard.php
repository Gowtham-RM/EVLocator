<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;700&display=swap" rel="stylesheet"> <!-- Font link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet"> <!-- Bootstrap Icons -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center; /* Center the content vertically and horizontally */
            background: url('https://img.pikbest.com/wp/202405/electric-vehicle-3d-illustration-of-an-charging-at-a-station_9833629.jpg!w700wp') no-repeat center center fixed; /* Replace with your EV image URL */
            background-size: cover;
            position: relative;
            overflow: hidden;
        }

        /* Overlay to darken the background for text visibility */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
            z-index: -1; /* Place behind all content */
        }

        /* Navbar Style */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: black;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10; /* Ensures the navbar stays on top of other elements */
        }

        .navbar .navbar-left {
            font-size: 24px;
            font-weight: bold;
        }

        .navbar .navbar-right {
            font-size: 20px;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-left: 20px; /* Slightly shift to the left */
        }

        .navbar .navbar-right i {
            margin-right: 8px; /* Space between icon and text */
        }

        .navbar .navbar-right:hover {
            color: #ddd;
        }

        /* Button Styles */
        .button {
            position: relative;
            display: flex; /* Using flexbox to center the content */
            align-items: center; /* Vertically center */
            justify-content: center; /* Horizontally center */
            font-size: 24px; /* Clearer and smaller font size */
            font-family: 'Raleway', sans-serif;
            color: white; /* White text color for visibility */
            width: 250px; /* Adjusted button width */
            height: 70px; /* Adjusted button height */
            margin: 15px; /* Adjusted margin */
            border-radius: 30px;
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent background for contrast */
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.7); /* Text shadow to make text pop */
            box-shadow: 
                0px 0px 0px 15px hsl(330, 80%, 50%),
                0px 10px 0px 15px hsl(330, 80%, 40%),
                0px 20px 20px 15px #0003;
            cursor: pointer;
            border-radius: 100px 30px 100px 30px;
            transition: all 0.3s ease;
        }

        .button p {
            margin: 0; /* Remove any margin */
            transform: rotate(-3deg);
        }

        .button:hover {
            animation: .8s morph ease infinite;
        }

        .button:hover p {
            animation: .8s rot ease infinite;
        }

        @keyframes morph {
            0% {
                border-radius: 100px 30px 100px 30px;
            } 50% {
                border-radius: 30px 100px 30px 100px;
            } 100% {
                border-radius: 100px 30px 100px 30px;
            }
        }

        @keyframes rot {
            0% {
                transform: rotate(-3deg);
            } 50% {
                transform: rotate(3deg);
            } 100% {
                transform: rotate(-3deg);
            }
        }

    </style>
</head>
<body>
    <!-- Overlay for background visibility -->
    <div class="overlay"></div>

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-left">Admin Dashboard</div>
        <div class="navbar-right" id="logout">
            <i class="bi bi-box-arrow-right"></i> Logout
        </div>
    </nav>

    <!-- Buttons Container -->
    <div>
        <a href="admin.php"><div class="button"><p>Add Stations</p></div></a><br><br>
        <a href="adminstation.php"><div class="button"><p>Edit Stations</p></div></a><br><br>
        <a href="station.php"><div class="button"><p>View Stations</p></div></a><br><br>
        <a href="userdetails.php"><div class="button"><p>User details</p></div></a><br>
    </div>

    <script>
        document.getElementById('logout').addEventListener('click', function() {
            const confirmLogout = confirm("Are you sure you want to logout?");
            if (confirmLogout) {
                sessionStorage.clear(); // or localStorage.clear();
                window.location.href = 'home.php'; // Redirect to logout or login page
            }
        });
    </script>
</body>
</html>
