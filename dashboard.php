<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding-top: 80px;
        }

        /* Navbar Style */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 1.2rem 3rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .navbar-left {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.5rem;
            background: #f8f9fa;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #495057;
            font-weight: 500;
        }

        .navbar-right:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .navbar-right i {
            font-size: 1.1rem;
        }

        /* Container */
        .container {
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
        }

        .welcome-section {
            text-align: center;
            margin-bottom: 3rem;
            color: white;
        }

        .welcome-section h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .welcome-section p {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Cards Grid */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .card-description {
            color: #718096;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .card-arrow {
            margin-top: 1rem;
            color: #667eea;
            font-size: 1.2rem;
            opacity: 0;
            transform: translateX(-10px);
            transition: all 0.3s ease;
        }

        .card:hover .card-arrow {
            opacity: 1;
            transform: translateX(0);
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 1.5rem;
            }

            .welcome-section h1 {
                font-size: 2rem;
            }

            .cards-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="navbar-left">⚡ EV Admin Portal</div>
        <div class="navbar-right" id="logout">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container">
        <div class="welcome-section">
            <h1>Welcome to Admin Dashboard</h1>
            <p>Manage your EV charging station network efficiently</p>
        </div>

        <div class="cards-grid">
            <a href="admin.php" class="card">
                <div class="card-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div class="card-title">Add Stations</div>
                <div class="card-description">Register new charging stations to the network and expand coverage</div>
                <div class="card-arrow"><i class="bi bi-arrow-right"></i></div>
            </a>

            <a href="adminstation.php" class="card">
                <div class="card-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="card-title">Edit Stations</div>
                <div class="card-description">Update existing station information and manage details</div>
                <div class="card-arrow"><i class="bi bi-arrow-right"></i></div>
            </a>

            <a href="station.php" class="card">
                <div class="card-icon">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div class="card-title">View Stations</div>
                <div class="card-description">Browse all charging stations and their current status</div>
                <div class="card-arrow"><i class="bi bi-arrow-right"></i></div>
            </a>

            <a href="userdetails.php" class="card">
                <div class="card-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="card-title">User Details</div>
                <div class="card-description">View and manage registered users and their activities</div>
                <div class="card-arrow"><i class="bi bi-arrow-right"></i></div>
            </a>
        </div>
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
