<?php
// Include database connection
include 'db_connect.php';

// Assuming you're using a session or passing the user id via GET
session_start();
$user_id = $_SESSION['user_id']; // Example: Fetching user_id from session

// Fetch user details
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title>
        <style>
            body { font-family: Arial, sans-serif; margin: 20px; }
            h1 { text-align: center; }
            table { width: 50%; margin: 0 auto; border-collapse: collapse; }
            td, th { padding: 10px; border: 1px solid #ccc; text-align: left; }
        </style>
    </head>
    <body>
        <h1>User Profile</h1>
        <table>
            <tr><th>ID</th><td><?php echo htmlspecialchars($row['id']); ?></td></tr>
            <tr><th>Username</th><td><?php echo htmlspecialchars($row['username']); ?></td></tr>
            <tr><th>Email</th><td><?php echo htmlspecialchars($row['email']); ?></td></tr>
            <tr><th>Vehicle Type</th><td><?php echo htmlspecialchars($row['vehicle_type']); ?></td></tr>
            <tr><th>Connector Type</th><td><?php echo htmlspecialchars($row['connector_type']); ?></td></tr>
            <tr><th>City</th><td><?php echo htmlspecialchars($row['city']); ?></td></tr>
            <tr><th>State</th><td><?php echo htmlspecialchars($row['state']); ?></td></tr>
            <tr><th>ZIP</th><td><?php echo htmlspecialchars($row['zip']); ?></td></tr>
        </table>
    </body>
    </html>

    <?php
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>
