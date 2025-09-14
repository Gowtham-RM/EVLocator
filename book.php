<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = ""; // Your MySQL root password
$dbname = "ev_charge_loc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $vehicle_type = $_POST['vehicle_type'];
    $vehicle_make = $_POST['vehicle_make'];
    $booking_date = $_POST['booking_date'];
    $time_slot = $_POST['time_slot'];
    $charging_type = $_POST['charging_type'];
    $phone_number = $_POST['phone_number'];
    $email = $_POST['email'];

    // Check if a booking already exists for the same phone number or email in the given time slot and date
    $stmt = $conn->prepare("SELECT * FROM slot WHERE (phone_number = ? OR email = ?) AND booking_date = ? AND time_slot = ?");
    $stmt->bind_param("ssss", $phone_number, $email, $booking_date, $time_slot);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('You have already made a booking for this time slot. Please choose a different time or modify your existing booking.');</script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO slot 
            (ev_type, ev_make, booking_date, time_slot, charging_type, phone_number, email) 
            VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param(
            "sssssss",
            $vehicle_type,
            $vehicle_make,
            $booking_date,
            $time_slot,
            $charging_type,
            $phone_number,
            $email
        );

        if ($stmt->execute()) {
            $slot_id = $stmt->insert_id;
            $formatted_slot_id = str_pad($slot_id, 4, '0', STR_PAD_LEFT);
            header("Location: book.php?id=$formatted_slot_id");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch data if 'id' parameter is set (after redirection)
if (isset($_GET['id'])) {
    $slot_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM slot WHERE slot_id = ?");
    $stmt->bind_param("i", $slot_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $row = null;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Slot - EV Charging Station Locator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: linear-gradient(180deg, #e3f2fd, #f1f8e9);
        }
        .form-container, .receipt-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 25px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .form-container h2, .receipt-container h3 {
            text-align: center;
            color: #2e7d32;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .btn-success {
            background-color: #43a047;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-success:hover {
            background-color: #2e7d32;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <?php if (!isset($_GET['id'])): ?>
        <div class="form-container">
            <h2>Book Your EV Charging Slot</h2>
            <form method="POST" action="book.php">
                <div class="mb-3">
                    <label for="vehicle_type" class="form-label">Vehicle Type:</label>
                    <select id="vehicle_type" name="vehicle_type" class="form-select" required>
                        <option value="">Select Vehicle Type</option>
                        <option value="Car">Car</option>
                        <option value="Electric Bike">Electric Bike</option>
                        <option value="Bus">Bus</option>
                        <option value="Truck">Truck</option>
                        <option value="Motorcycle">Motorcycle</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="vehicle_make" class="form-label">Make and Model:</label>
                    <input type="text" id="vehicle_make" name="vehicle_make" class="form-control" placeholder="e.g., Tesla Model 3" required>
                </div>
                <div class="mb-3">
                    <label for="booking_date" class="form-label">Booking Date:</label>
                    <input type="date" id="booking_date" name="booking_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="time_slot" class="form-label">Time Slot:</label>
                    <select id="time_slot" name="time_slot" class="form-select" required>
                        <option value="">Select Time Slot</option>
                        <option value="9 AM - 11 AM">9 AM - 11 AM</option>
                        <option value="11 AM - 1 PM">11 AM - 1 PM</option>
                        <option value="1 PM - 3 PM">1 PM - 3 PM</option>
                        <option value="3 PM - 5 PM">3 PM - 5 PM</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="charging_type" class="form-label">Charging Type:</label>
                    <select id="charging_type" name="charging_type" class="form-select" required>
                        <option value="">Select Charging Type</option>
                        <option value="Fast">Fast Charging</option>
                        <option value="Standard">Standard Charging</option>
                        <option value="Slow">Slow Charging</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number:</label>
                    <input type="tel" id="phone_number" name="phone_number" class="form-control" placeholder="9876543210" required pattern="[6-9]{1}[0-9]{9}" title="Enter a valid 10-digit Indian mobile number starting with 6-9">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="e.g., user@example.com" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Book Now</button>
            </form>
        </div>
    <?php else: ?>
        <div class="receipt-container" id="receipt">
            <h3>Booking Receipt</h3>
            <?php if ($row): ?>
                <p><strong>Booking ID:</strong> <?php echo htmlspecialchars($_GET['id']); ?></p>
                <button onclick="generatePDF()" class="btn btn-success w-100">Download Receipt as PDF</button>
            <?php else: ?>
                <p>No booking data found.</p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <script>
        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const data = [
                ["Booking ID", "<?php echo htmlspecialchars($_GET['id']); ?>"],
                ["Vehicle Type", "<?php echo htmlspecialchars($row['ev_type']); ?>"],
                ["Vehicle Make", "<?php echo htmlspecialchars($row['ev_make']); ?>"],
                ["Booking Date", "<?php echo htmlspecialchars($row['booking_date']); ?>"],
                ["Time Slot", "<?php echo htmlspecialchars($row['time_slot']); ?>"],
                ["Charging Type", "<?php echo htmlspecialchars($row['charging_type']); ?>"],
                ["Phone Number", "<?php echo htmlspecialchars($row['phone_number']); ?>"],
                ["Email Address", "<?php echo htmlspecialchars($row['email']); ?>"],
            ];

            doc.setFont("Arial", "bold");
            doc.setFontSize(16);
            doc.text("EV Charging Station Booking Receipt", 105, 15, null, null, 'center');

            doc.autoTable({
                startY: 25,
                head: [["Field", "Details"]],
                body: data,
                theme: 'striped',
                styles: { font: "Arial", fontSize: 12 },
                headStyles: { fillColor: [44, 62, 80], textColor: [255, 255, 255] },
            });

            doc.save("Booking_Receipt.pdf");
        }
    </script>
</body>
</html>
