<?php
require_once __DIR__ . '/db.php';

try {
    $conn = get_db_connection();
} catch (RuntimeException $e) {
    error_log($e->getMessage());
    http_response_code(500);
    exit('Database connection unavailable.');
}

// Fetch all pending requests
$sql = "SELECT * FROM public.station_requests";
$requests = $conn->query($sql)->fetchAll();
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
            <?php foreach ($requests as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['st_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['st_loc']); ?></td>
                    <td><?php echo htmlspecialchars($row['latitude']); ?></td>
                    <td><?php echo htmlspecialchars($row['longitude']); ?></td>
                    <td><?php echo htmlspecialchars($row['connectors']); ?></td>
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
$conn = null;
?>
