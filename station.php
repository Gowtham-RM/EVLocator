<?php
// Backend logic for database connection and data fetching

$servername = "localhost";
$username = "root";
$password = ""; // Use your MySQL root password
$dbname = "EV_charge_loc";  // Ensure your database name is correct

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination logic
$limit = 10; // Number of items per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Sorting logic
$sortColumn = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'id';  // Default sort by id
$sortOrder = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';  // Default sort order is ascending

// Fetch data if it's an AJAX request
if (isset($_GET['fetch_stations'])) {
    // Count total number of stations
    $countSql = "SELECT COUNT(*) AS total FROM evadmin";
    $countResult = $conn->query($countSql);
    $countRow = $countResult->fetch_assoc();
    $totalStations = $countRow['total'];

    // Fetch the current page's data with sorting
    $sql = "SELECT id, st_name, st_loc, latitude, longitude, connectors FROM evadmin 
            ORDER BY $sortColumn $sortOrder 
            LIMIT $limit OFFSET $offset";
    $result = $conn->query($sql);

    $stations = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $stations[] = $row;
        }
    }

    // Output JSON for AJAX
    header('Content-Type: application/json');
    echo json_encode([
        'stations' => $stations,
        'total' => $totalStations,
    ]);
    exit; // Stop further processing for AJAX requests
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EV Charging Stations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://img.pikbest.com/wp/202405/electric-vehicle-3d-illustration-of-an-charging-at-a-station_9833629.jpg!w700wp') no-repeat center center fixed;
            background-size: cover;
            color: black;
        }
        .total-stations {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .station-container {
            margin: 20px auto;
            max-width: 1200px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h1, h2 {
            text-align: center;
            color: black;
        }
        .total-stations {
            text-align: center;
            font-size: 1.2em;
            margin: 20px 0;
            color: white;
        }
        .search-bar {
            margin: 20px auto;
            max-width: 600px;
            display: flex;
            justify-content: center;
        }
        .search-bar input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(0, 0, 0, 0.7);
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: white;
        }
        table th {
            background-color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
        }
        table tbody tr {
            opacity: 0;
            animation: fadeIn 0.5s forwards;
        }
        table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: gray;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination button {
            padding: 10px 20px;
            margin: 0 5px;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ddd;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            transition: background-color 0.3s, color 0.3s;
        }
        .pagination button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: gray;
        }
        .pagination button.disabled {
            cursor: not-allowed;
        }
        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    <h1>Charging Stations List</h1>
    <div class="total-stations">
        Total Stations: <span id="total-stations-count">Loading...</span>
    </div><br>
    <div class="station-container">
        <div class="search-bar">
            <input type="text" id="search-location" placeholder="Search by location...">
        </div>
        <table id="station-table">
            <thead>
                <tr>
                    <th data-column="id">ID</th>
                    <th data-column="st_name">Station Name</th>
                    <th data-column="st_loc">Location</th>
                    <th data-column="latitude">Latitude</th>
                    <th data-column="longitude">Longitude</th>
                    <th data-column="connectors">Connectors</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically added here -->
            </tbody>
        </table>
        <div class="pagination" id="pagination-controls">
            <!-- Pagination buttons will be dynamically added here -->
        </div>
    </div>

    <script>
        let currentPage = 1;
        let totalStations = 0;
        const stationsPerPage = 10;
        let sortColumn = 'id';  // Default sort by 'id'
        let sortOrder = 'ASC';  // Default sort order

        // Fetch charging stations from the backend
        async function fetchStations(page = 1) {
            const response = await fetch(`?fetch_stations=1&page=${page}&sort_column=${sortColumn}&sort_order=${sortOrder}`);
            const data = await response.json();
            totalStations = data.total;
            document.getElementById('total-stations-count').textContent = totalStations; // Update total stations count
            updateTable(data.stations);
            updatePagination(page);
        }

        // Update the table with sorted data
        function updateTable(stations) {
            const stationTableBody = document.querySelector('#station-table tbody');
            stationTableBody.innerHTML = ""; // Clear existing table rows

            stations.forEach(station => {
                // Add row to the table
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${station.id}</td>
                    <td>${station.st_name}</td>
                    <td>${station.st_loc}</td>
                    <td>${station.latitude}</td>
                    <td>${station.longitude}</td>
                    <td>${station.connectors}</td>
                `;
                row.dataset.location = station.st_loc.toLowerCase(); // Add data attribute for filtering
                stationTableBody.appendChild(row);
            });
        }

        // Pagination controls
        function updatePagination(page) {
            const totalPages = Math.ceil(totalStations / stationsPerPage);
            const paginationControls = document.getElementById('pagination-controls');
            paginationControls.innerHTML = '';

            const prevButton = document.createElement('button');
            prevButton.textContent = 'Previous';
            prevButton.classList.toggle('disabled', page === 1);
            prevButton.onclick = () => fetchStations(page - 1);
            paginationControls.appendChild(prevButton);

            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.classList.toggle('disabled', i === page);
                pageButton.onclick = () => fetchStations(i);
                paginationControls.appendChild(pageButton);
            }

            const nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.classList.toggle('disabled', page === totalPages);
            nextButton.onclick = () => fetchStations(page + 1);
            paginationControls.appendChild(nextButton);
        }

        // Sort the column
        function sortTable(column) {
            sortColumn = column;
            sortOrder = (sortOrder === 'ASC') ? 'DESC' : 'ASC';
            fetchStations(currentPage);
        }

        // Add event listeners for sorting
        document.querySelectorAll('th').forEach(header => {
            header.addEventListener('click', () => {
                const column = header.dataset.column;
                sortTable(column);
            });
        });

        // Search feature
        function filterTable() {
            const searchInput = document.querySelector('#search-location').value.toLowerCase();
            const rows = document.querySelectorAll('#station-table tbody tr');
            rows.forEach(row => {
                const location = row.dataset.location || '';
                if (location.includes(searchInput)) {
                    row.style.display = ''; // Show row
                } else {
                    row.style.display = 'none'; // Hide row
                }
            });
        }

        // Add event listener to the search bar
        document.querySelector('#search-location').addEventListener('input', filterTable);

        // Fetch and update stations on initial load
        fetchStations(currentPage);

    </script>
</body>
</html>
