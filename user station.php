<?php
require_once __DIR__ . '/db.php';

try {
    $conn = get_db_connection();
} catch (RuntimeException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Database connection unavailable.');
}

// Capture form data
$st_name = trim($_POST['st_name'] ?? '');
$st_loc = trim($_POST['st_loc'] ?? '');
$latitude = trim($_POST['latitude'] ?? '');
$longitude = trim($_POST['longitude'] ?? '');
$connectors = trim($_POST['connectors'] ?? '');

$sql = "INSERT INTO station_requests (st_name, st_loc, latitude, longitude, connectors)
        VALUES (:name, :loc, :lat, :lng, :connectors)";
$stmt = $conn->prepare($sql);

if ($stmt->execute([
    ':name' => $st_name,
    ':loc' => $st_loc,
    ':lat' => $latitude,
    ':lng' => $longitude,
    ':connectors' => $connectors,
])) {
    echo "Request submitted successfully! Awaiting admin approval.";
} else {
    echo "Error: Unable to submit the request.";
}

$stmt = null;
$conn = null;
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
