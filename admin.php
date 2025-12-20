<?php
require_once __DIR__ . '/db.php';

try {
  $conn = get_db_connection();
} catch (RuntimeException $e) {
  error_log($e->getMessage());
  http_response_code(500);
  exit('Database connection unavailable.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
  $id = (int) ($_POST['station-id'] ?? 0);
  $name = trim($_POST['station-name'] ?? '');
  $location = trim($_POST['station-location'] ?? '');
  $latitude = trim($_POST['latitude'] ?? '');
  $longitude = trim($_POST['longitude'] ?? '');
  $connectors = trim($_POST['connector-types'] ?? '');

  $checkQuery = "SELECT 1 FROM public.evadmin WHERE id = :id OR (latitude = :lat AND longitude = :lng) LIMIT 1";
  $stmt = $conn->prepare($checkQuery);
  $stmt->execute([
    ':id' => $id,
    ':lat' => $latitude,
    ':lng' => $longitude,
  ]);

  if ($stmt->fetch()) {
        // Duplicate found
        echo "<script>alert('The ID or Latitude/Longitude combination already exists. Check it!');</script>";
    } else {
        // Use prepared statement to insert data into the database
    $insertQuery = "INSERT INTO public.evadmin (id, st_name, st_loc, latitude, longitude, connectors)
             VALUES (:id, :name, :location, :latitude, :longitude, :connectors)";
    $insertStmt = $conn->prepare($insertQuery);

    if ($insertStmt->execute([
      ':id' => $id,
      ':name' => $name,
      ':location' => $location,
      ':latitude' => $latitude,
      ':longitude' => $longitude,
      ':connectors' => $connectors,
    ])) {
            echo "<script>alert('Station added successfully!!');</script>";
        } else {
      echo "Error: Unable to add station.";
        }

    $insertStmt = null;
    }

  $stmt = null;
}

// Close the database connection
$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - Manage Stations</title>
<style>/* General Reset */
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background: url('https://img.pikbest.com/wp/202405/electric-vehicle-3d-illustration-of-an-charging-at-a-station_9833629.jpg!w700wp') no-repeat center center fixed;
  background-size: cover;
  color: white;
  padding: 20px;
}

/* Header */
.header {
  background-color: rgba(0, 0, 0, 0.7);
  color: white;
  text-align: center;
  padding: 2rem;
  border-radius: 10px;
  margin-bottom: 2rem;
}

/* Main Container */
.container {
  max-width: 800px;
  margin: 2rem auto;
  padding: 2rem;
  background: rgba(0, 0, 0, 0.7);
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
}

/* Form Section */
.form-section h2 {
  margin-bottom: 1.5rem;
  text-align: center;
  color: white;
  font-size: 1.8rem;
}

form label {
  display: block;
  margin: 0.8rem 0;
  font-size: 1rem;
  color: white;
}

form input, form button {
  width: 100%;
  padding: 1rem;
  margin-bottom: 1.5rem;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 1rem;
}

form button {
  background-color: rgba(106, 94, 94, 0.7);
  color: white;
  border: none;
  cursor: pointer;
  transition: background-color 0.3s;
  font-weight: bold;
}

form button:hover {
  background-color: rgba(234, 222, 222, 0.92);
}

/* Link Section */
h3 a {
  color: white;
  text-decoration: none;
  font-size: 1rem;
}

h3 a:hover {
  text-decoration: underline;
}

/* Table Section */
.list-section table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.list-section th, .list-section td {
  padding: 1rem;
  text-align: left;
  border: 1px solid #ddd;
}

.list-section th {
  background-color: rgba(0, 0, 0, 0.7);
  color: white;
}

.list-section td {
  background-color: rgba(255, 255, 255, 0.1);
}

.list-section button {
  padding: 0.4rem 0.8rem;
  background-color: #f44336;
  color: white;
  border: none;
  cursor: pointer;
  font-size: 0.9rem;
}

.list-section button:hover {
  background-color: #d32f2f;
}

/* Footer */
.footer {
  text-align: center;
  padding: 1rem;
  background-color: #333;
  color: white;
}

    
    </style>
</head>
<body>
  <header class="header">
    <h1>Admin Dashboard</h1>
  </header>
  

  <main class="container">
    <!-- Add Station Form -->
    <section class="form-section">
      <h2>Add/Update Station</h2>
      <form  method="POST" action="admin.php">
        <label for="station-id">Station ID:</label>
        <input type="text" id="station-id" name="station-id" placeholder="Enter Station ID" required>

        <label for="station-name">Station Name:</label>
        <input type="text" id="station-name" name="station-name" placeholder="Enter Station Name" required>

        <label for="station-location">Location:</label>
        <input type="text" id="station-location" name="station-location" placeholder="Enter Location" required>

        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" placeholder="Enter Latitude" required>

        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" placeholder="Enter Longitude" required>

        <label for="connector-types">Connector Types:</label>
        <input type="text" id="connector-types" name="connector-types" placeholder="e.g., Type 1, Type 2" required>

        <button type="submit">Add/Update Station</button>
        <center> <h3> <a href="adminstation.php">View Stations</a> </h3>
      </form>
    </section>

   
</body>
</html>
