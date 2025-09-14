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

// Check if required POST parameters are set
if (!isset($_POST['id']) || !isset($_POST['action'])) {
    die("Error: Missing required parameters.");
}

// Get POST parameters
$id = $_POST['id'];
$action = $_POST['action'];

// Validate `id` to ensure it's numeric
if (!is_numeric($id)) {
    die("Error: Invalid station request ID.");
}

if ($action === "approve") {
    // Approve the request
    $sql = "INSERT INTO evadmin (st_name, st_loc, latitude, longitude, connectors)
            SELECT st_name, st_loc, latitude, longitude, connectors 
            FROM station_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Remove the request from station_requests
        $deleteSql = "DELETE FROM station_requests WHERE id = ?";
        $deleteStmt = $conn->prepare($deleteSql);
        $deleteStmt->bind_param("i", $id);

        if ($deleteStmt->execute()) {
            echo "Request approved and station added.";
        } else {
            echo "Error: Unable to delete the request after approval.";
        }

        $deleteStmt->close();
    } else {
        echo "Error: Unable to approve the request.";
    }

    $stmt->close();
} elseif ($action === "reject") {
    // Reject the request
    $sql = "DELETE FROM station_requests WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Request rejected.";
    } else {
        echo "Error: Unable to reject the request.";
    }

    $stmt->close();
} else {
    echo "Error: Invalid action.";
}

$conn->close();
?>
