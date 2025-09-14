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

// Fetch all pending requests
$sql = "SELECT * FROM station_requests";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Review Requests</title>
</head>
<body>
    <h1>Admin - Review Requests</h1>
    <table border="1">
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
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['st_name']; ?></td>
                    <td><?php echo $row['st_loc']; ?></td>
                    <td><?php echo $row['latitude']; ?></td>
                    <td><?php echo $row['longitude']; ?></td>
                    <td><?php echo $row['connectors']; ?></td>
                    <td>
                        <form action="approve_request.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="approve">Approve</button>
                        </form>
                        <form action="approve_request.php" method="POST" style="display: inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="action" value="reject">Reject</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
<?php
$conn->close();
?>
