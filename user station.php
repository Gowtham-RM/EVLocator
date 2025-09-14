<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "EV_charge_loc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Capture form data
$st_name = $_POST['st_name'];
$st_loc = $_POST['st_loc'];
$latitude = $_POST['latitude'];
$longitude = $_POST['longitude'];
$connectors = $_POST['connectors'];

// Insert into station_requests table
$sql = "INSERT INTO station_requests (st_name, st_loc, latitude, longitude, connectors) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $st_name, $st_loc, $latitude, $longitude, $connectors);

if ($stmt->execute()) {
    echo "Request submitted successfully! Awaiting admin approval.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Station</title>
</head>
<body>
    <h1>Add EV Charging Station</h1>
    <form action="add_station_request.php" method="POST">
        <label for="st_name">Station Name:</label>
        <input type="text" id="st_name" name="st_name" required><br><br>

        <label for="st_loc">Location:</label>
        <input type="text" id="st_loc" name="st_loc" required><br><br>

        <label for="latitude">Latitude:</label>
        <input type="text" id="latitude" name="latitude" required><br><br>

        <label for="longitude">Longitude:</label>
        <input type="text" id="longitude" name="longitude" required><br><br>

        <label for="connectors">Connectors:</label>
        <input type="text" id="connectors" name="connectors" required><br><br>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
