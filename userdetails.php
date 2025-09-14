<?php
// Database connection details
$host = "localhost";
$dbname = "ev_charge_loc";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password

try {
    // Establish a connection to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch user data
try {
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Failed to fetch data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('https://img.pikbest.com/wp/202405/electric-vehicle-3d-illustration-of-an-charging-at-a-station_9833629.jpg!w700wp') no-repeat center center fixed;
            background-size: cover;
            color: black;
            padding: 20px;
        }
        .table-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            width: 100%; /* Ensures the container uses the full width */
            overflow-x: auto; /* Allows horizontal scrolling if the table overflows */
        }
        .table {
            width: 100%; /* Makes the table span the full width */
        }
        .table th, .table td {
            color: white;
        }
        /* Hover effect for table rows */
        .table tr:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Light gray background */
        }
        .table tr:hover td {
            color: gray; /* Change text color to gray on hover */
        }
        /* Total users count style */
        .total-users {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        /* Pagination buttons style */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination button {
            background-color: rgba(0, 0, 0, 0.7); /* Same background as table rows */
            color: white;
            border: none;
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination button:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Same hover effect as table rows */
            color: gray;
        }

        .pagination button:disabled {
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Display total number of users -->
        <div class="total-users">
            Total Users: <span id="user-count">0</span>
        </div>

        <h1 class="text-center"><b>User Details</b></h1>

        <div id="filters" class="d-flex justify-content-center my-3">
            <select id="filter-city" class="form-select w-auto mx-2">
                <option value="all">Filter by City</option>
                <!-- Options will be populated dynamically with JavaScript -->
            </select>
            <select id="filter-charger" class="form-select w-auto mx-2">
                <option value="all">Filter by Charger Type</option>
                <!-- Options will be populated dynamically with JavaScript -->
            </select>
        </div>

        <!-- Table container -->
        <div class="table-container" id="table-container">
            <!-- Sections will be populated dynamically with JavaScript -->
        </div>

        <!-- Pagination buttons -->
        <div class="pagination" id="pagination-controls">
            <button id="prev-button" disabled>Previous</button>
            <!-- Page number buttons will be added here dynamically -->
            <button id="next-button" disabled>Next</button>
        </div>
    </div>

    <script>
        // Mock user data fetched from PHP
        const users = <?php echo json_encode($users); ?>;
        const usersPerPage = 10; // Number of users per page
        let currentPage = 1;

        // Get elements
        const tableContainer = document.getElementById('table-container');
        const paginationControls = document.getElementById('pagination-controls');
        const filterCity = document.getElementById('filter-city');
        const filterCharger = document.getElementById('filter-charger');
        const userCount = document.getElementById('user-count'); // Element to display user count
        const prevButton = document.getElementById('prev-button');
        const nextButton = document.getElementById('next-button');

        // Populate filter options dynamically based on user data
        function populateFilters() {
            const cities = Array.from(new Set(users.map(user => user.city)));
            const chargerTypes = Array.from(new Set(users.map(user => user.connector_type)));

            // Add city options
            cities.forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                filterCity.appendChild(option);
            });

            // Add charger type options
            chargerTypes.forEach(charger => {
                const option = document.createElement('option');
                option.value = charger;
                option.textContent = charger;
                filterCharger.appendChild(option);
            });
        }

        // Function to populate the table with users
        function populateTable(usersToDisplay) {
            const table = document.createElement('table');
            table.classList.add('table', 'table-bordered', 'table-hover', 'text-center');
            const thead = document.createElement('thead');
            thead.innerHTML = `
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Vehicle Type</th>
                    <th>Connector Type</th>
                    <th>City</th>
                    <th>State</th>
                    <th>ZIP</th>
                    <th>Created At</th>
                </tr>
            `;
            table.appendChild(thead);

            const tbody = document.createElement('tbody');
            usersToDisplay.forEach(user => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.vehicle_type}</td>
                    <td>${user.connector_type}</td>
                    <td>${user.city}</td>
                    <td>${user.state}</td>
                    <td>${user.zip}</td>
                    <td>${user.created_at}</td>
                `;
                tbody.appendChild(row);
            });
            table.appendChild(tbody);
            tableContainer.innerHTML = ''; // Clear existing content
            tableContainer.appendChild(table);
        }

        // Function to create pagination buttons (including page numbers)
        function createPagination(totalUsers) {
            const totalPages = Math.ceil(totalUsers / usersPerPage);

            // Enable/Disable previous and next buttons
            prevButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === totalPages;

            // Clear previous page buttons
            const pageButtons = document.querySelectorAll('.page-button');
            pageButtons.forEach(button => button.remove());

            // Create page number buttons
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.classList.add('page-button');
                button.textContent = i;
                button.addEventListener('click', () => {
                    currentPage = i;
                    updateTable();
                });
                paginationControls.insertBefore(button, nextButton); // Insert before the Next button
            }
        }

        // Function to update table content and pagination
        function updateTable() {
            const filteredUsers = filterUsers();
            const start = (currentPage - 1) * usersPerPage;
            const end = start + usersPerPage;
            const usersToDisplay = filteredUsers.slice(start, end);

            populateTable(usersToDisplay);

            // Update user count and pagination
            userCount.textContent = filteredUsers.length;
            createPagination(filteredUsers.length);
        }

        // Function to apply filters based on selected values
        function filterUsers() {
            const selectedCity = filterCity.value;
            const selectedCharger = filterCharger.value;

            return users.filter(user => {
                return (selectedCity === 'all' || user.city === selectedCity) &&
                       (selectedCharger === 'all' || user.connector_type === selectedCharger);
            });
        }

        // Initialize filters and table
        populateFilters();
        updateTable();

        // Add event listeners for filter changes
        filterCity.addEventListener('change', updateTable);
        filterCharger.addEventListener('change', updateTable);

        // Add event listeners for pagination buttons
        prevButton.addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
            }
        });

        nextButton.addEventListener('click', () => {
            const filteredUsers = filterUsers();
            const totalPages = Math.ceil(filteredUsers.length / usersPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                updateTable();
            }
        });
    </script>
</body>
</html>
