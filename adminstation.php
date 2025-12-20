<?php
require_once __DIR__ . '/db.php';

// Backend logic for database connection and data fetching
try {
    $conn = get_db_connection();
} catch (RuntimeException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Database connection unavailable.');
}

// Fetch data if it's an AJAX request
if (isset($_GET['fetch_stations'])) {
    $sql = "SELECT id, st_name, st_loc, latitude, longitude, connectors FROM evadmin";
    $result = $conn->query($sql);
    $stations = $result->fetchAll();

    // Output JSON for AJAX
    header('Content-Type: application/json');
    echo json_encode($stations);
    exit; // Stop further processing for AJAX requests
}

// Handle delete request
if (isset($_GET['delete_station'])) {
    $id = (int) $_GET['delete_station'];
    $deleteQuery = "DELETE FROM evadmin WHERE id = :id";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->execute([':id' => $id]);
    echo json_encode(['success' => true]);
    exit;
}

// Handle edit request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_station'])) {
    $id = (int) ($_POST['station-id'] ?? 0);
    $name = trim($_POST['station-name'] ?? '');
    $location = trim($_POST['station-location'] ?? '');
    $latitude = trim($_POST['latitude'] ?? '');
    $longitude = trim($_POST['longitude'] ?? '');
    $connectors = trim($_POST['connector-types'] ?? '');

    $updateQuery = "UPDATE evadmin SET st_name = :name, st_loc = :loc, latitude = :lat, longitude = :lng, connectors = :connectors WHERE id = :id";
    $stmt = $conn->prepare($updateQuery);
    $stmt->execute([
        ':name' => $name,
        ':loc' => $location,
        ':lat' => $latitude,
        ':lng' => $longitude,
        ':connectors' => $connectors,
        ':id' => $id,
    ]);

    header("Location: station.php"); // Redirect back to the station page
    exit;
}

// Close the database connection
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EV Charging Stations</title>
    <style>
        /* Styling for body and station container */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('https://img.pikbest.com/wp/202405/electric-vehicle-3d-illustration-of-an-charging-at-a-station_9833629.jpg!w700wp') no-repeat center center fixed;
            background-size: cover;
            color: black;
        }
        #total-stations {
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
        .refresh-info {
            text-align: center;
            font-size: 0.9em;
            color: #888;
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
        .action-btns {
            display: flex;
            gap: 10px;
        }
        button {
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
            border: 1px solid #ddd;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            transition: background-color 0.3s, color 0.3s;
        }
        button:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: gray;
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
    <div id="total-stations" class="refresh-info">
            Total Stations: <span id="station-count">0</span>
        </div>

    <div class="station-container">
        <!-- Total stations count -->
        
        <div class="search-bar">
            <input type="text" id="search-location" placeholder="Search by location...">
        </div>
        <div class="refresh-info">(Updates every 10 seconds)</div>
        <table id="station-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Station Name</th>
                    <th>Location</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Connectors</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be dynamically added here -->
            </tbody>
        </table>
    </div>

    <script>
        // Fetch charging stations from the backend
        async function fetchStations() {
            const response = await fetch('?fetch_stations=1'); // Pass query parameter to trigger backend fetch
            const stations = await response.json();
            updateTable(stations);
        }

        // Update the table with data from the database
        function updateTable(stations) {
            const stationTableBody = document.querySelector('#station-table tbody');
            stationTableBody.innerHTML = ""; // Clear existing table rows

            // Update the total stations count
            document.getElementById('station-count').textContent = stations.length;

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
                    <td>
                        <div class="action-btns">
                            <button class="edit-btn" onclick="editStation(${station.id})">Edit</button>
                            <button class="delete-btn" onclick="deleteStation(${station.id})">Delete</button>
                        </div>
                    </td>
                `;
                row.dataset.location = station.st_loc.toLowerCase(); // Add data attribute for filtering
                stationTableBody.appendChild(row);
            });
        }

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

        // Edit Station (Open a form or redirect to another page)
        function editStation(id) {
            window.location.href = `adminedit.php?id=${id}`;
        }

        // Delete Station
        async function deleteStation(id) {
            if (confirm('Are you sure you want to delete this station?')) {
                const response = await fetch(`?delete_station=${id}`, { method: 'GET' });
                const result = await response.json();
                if (result.success) {
                    alert('Station deleted successfully!');
                    fetchStations(); // Refresh the table
                } else {
                    alert('Error deleting station!');
                }
            }
        }

        // Add event listener to the search bar
        document.querySelector('#search-location').addEventListener('input', filterTable);

        // Fetch and update stations every 10 seconds
        fetchStations();
        setInterval(fetchStations, 10000); // Real-time updates
    </script>
</body>
</html>
