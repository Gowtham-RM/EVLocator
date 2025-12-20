<?php
require_once __DIR__ . '/db.php';

try {
    $conn = get_db_connection();
} catch (RuntimeException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Database connection unavailable.');
}

if (!isset($_POST['id']) || !isset($_POST['action'])) {
    die("Error: Missing required parameters.");
}

$id = (int) $_POST['id'];
$action = $_POST['action'];

if ($id <= 0) {
    die("Error: Invalid station request ID.");
}

if ($action === "approve") {
    $sql = "INSERT INTO evadmin (st_name, st_loc, latitude, longitude, connectors)
            SELECT st_name, st_loc, latitude, longitude, connectors 
            FROM station_requests WHERE id = :id";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([':id' => $id])) {
        $deleteSql = "DELETE FROM station_requests WHERE id = :id";
        $deleteStmt = $conn->prepare($deleteSql);

        if ($deleteStmt->execute([':id' => $id])) {
            echo "Request approved and station added.";
        } else {
            echo "Error: Unable to delete the request after approval.";
        }

        $deleteStmt = null;
    } else {
        echo "Error: Unable to approve the request.";
    }
    $stmt = null;
} elseif ($action === "reject") {
    $sql = "DELETE FROM station_requests WHERE id = :id";
    $stmt = $conn->prepare($sql);

    if ($stmt->execute([':id' => $id])) {
        echo "Request rejected.";
    } else {
        echo "Error: Unable to reject the request.";
    }
    $stmt = null;
} else {
    echo "Error: Invalid action.";
}

$conn = null;
?>
