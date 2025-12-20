<?php
require_once __DIR__ . '/db.php';

// Backend logic to fetch and update station details
try {
    $conn = get_db_connection();
} catch (RuntimeException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Database connection unavailable.');
}

$station = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_station'])) {
    $id = (int) ($_POST['station-id'] ?? 0);
    $st_name = trim($_POST['station-name'] ?? '');
    $st_loc = trim($_POST['station-location'] ?? '');
    $latitude = trim($_POST['latitude'] ?? '');
    $longitude = trim($_POST['longitude'] ?? '');
    $connectors = trim($_POST['connector-types'] ?? '');

    $stmt = $conn->prepare(
        "UPDATE evadmin SET st_name = :name, st_loc = :loc, latitude = :lat, longitude = :lng, connectors = :connectors
         WHERE id = :id"
    );

    if ($stmt->execute([
        ':name' => $st_name,
        ':loc' => $st_loc,
        ':lat' => $latitude,
        ':lng' => $longitude,
        ':connectors' => $connectors,
        ':id' => $id,
    ])) {
        header("Location: adminstation.php");
        exit;
    }

    echo "Error updating record.";
    exit;
} elseif (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    $stmt = $conn->prepare("SELECT id, st_name, st_loc, latitude, longitude, connectors FROM evadmin WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $station = $stmt->fetch();

    if (!$station) {
        echo "Station not found.";
        exit;
    }
} else {
    header("Location: adminstation.php"); // Redirect to station list if no ID provided
    exit;
}

$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Station</title>
    <style>
 body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #333;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .form-container h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            margin-bottom: 8px;
            font-size: 1rem;
            color: #555;
        }

        form input {
            padding: 12px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            background-color: #f9f9f9;
        }

        form input:focus {
            outline: none;
            border-color: #3c36d6;
            background-color: #fff;
        }

        button {
            padding: 12px;
            background-color: #3c36d6;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2a2ab1;
        }

        button:active {
            background-color: #1a1a7d;
        }

        .form-container .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .form-container .back-link a {
            color: #3c36d6;
            text-decoration: none;
            font-size: 1rem;
        }

        .form-container .back-link a:hover {
            text-decoration: underline;
        }    </style>
</head>
<body>
    <h1>Edit Station</h1>
    <div class="form-container">
        <h2>Update Station Information</h2>
        <form method="POST" action="">
            <input type="hidden" name="update_station" value="1">
            <input type="hidden" name="station-id" value="<?php echo htmlspecialchars($station['id']); ?>">
            
            <label for="station-name">Station Name:</label>
            <input type="text" id="station-name" name="station-name" value="<?php echo htmlspecialchars($station['st_name']); ?>" required>

            <label for="station-location">Location:</label>
            <input type="text" id="station-location" name="station-location" value="<?php echo htmlspecialchars($station['st_loc']); ?>" required>

            <label for="latitude">Latitude:</label>
            <input type="text" id="latitude" name="latitude" value="<?php echo htmlspecialchars($station['latitude']); ?>" required>

            <label for="longitude">Longitude:</label>
            <input type="text" id="longitude" name="longitude" value="<?php echo htmlspecialchars($station['longitude']); ?>" required>

            <label for="connector-types">Connector Types:</label>
            <input type="text" id="connector-types" name="connector-types" value="<?php echo htmlspecialchars($station['connectors']); ?>">

            <button type="submit">Update Station</button>
        </form>

        <div class="back-link">
            <a href="adminstation.php">Back to Stations List</a>
        </div>
    </div>
</body>
</html>


