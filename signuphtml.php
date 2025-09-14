<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "ev_charge_loc");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $conn->real_escape_string($_POST["username"]);
  $email = $conn->real_escape_string($_POST["email"]);
  $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // Secure password hashing
  $vehicle_type = $conn->real_escape_string($_POST["vehicle_type"]);
  $connector_type = $conn->real_escape_string($_POST["connector_type"]);
  $city = $conn->real_escape_string($_POST["city"]);
  $state = $conn->real_escape_string($_POST["state"]);
  $zip = $conn->real_escape_string($_POST["zip"]);

  // Check if email already exists
  $checkEmail = $conn->query("SELECT id FROM users WHERE email = '$email'");
  if ($checkEmail->num_rows > 0) {
      echo "<script>alert('Email already exists. Please use another email.');</script>";
  } else {
      $sql = "INSERT INTO users (username, email, password, vehicle_type, connector_type, city, state, zip)
              VALUES ('$username', '$email', '$password', '$vehicle_type', '$connector_type', '$city', '$state', '$zip')";
      if ($conn->query($sql) === TRUE) {
          echo "<script>
                  alert('Registration successful! Redirecting to login page.');
                  window.location.href = 'loginhtml.php';
                </script>";
      } else {
          echo "<script>alert('Error: " . $conn->error . "');</script>";
      }
  }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EV Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #6c63ff, #43cea2);
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
    }
    .card {
      width: 80%; 
      max-width: 500px; 
      background-color: #ffffff;
      margin: auto;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    .card-header {
      background-color: #007bff;
      color: white;
      text-align: center;
      font-weight: bold;
      font-size: 20px;
      border-radius: 12px 12px 0 0;
      padding: 15px;
    }
    .card-body {
      padding: 20px;
    }
    .form-label {
      font-size: 14px;
      font-weight: 600;
      color: #333333;
    }
    .form-control {
      padding: 10px;
      font-size: 14px;
      border: 1px solid #cccccc;
      border-radius: 6px;
    }
    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
    }
    h5 {
      text-align: center;
      color: #007bff;
      font-weight: bold;
      margin-bottom: 15px;
    }
    .form-group button {
      background-color: #007bff;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      padding: 10px 15px;
      font-size: 16px;
      width: 100%;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .form-group button:hover {
      background-color: #0056b3;
      transform: scale(1.02);
    }
    .form-group button:disabled {
      background-color: #cccccc;
      cursor: not-allowed;
    }
    .footer-links {
      text-align: center;
      margin-top: 10px;
      font-size: 14px;
    }
    .footer-links a {
      color: #007bff;
      text-decoration: none;
      transition: color 0.3s ease;
    }
    .footer-links a:hover {
      color: #0056b3;
      text-decoration: underline;
    }
    #terms {
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-header">
      <h4>Sign Up</h4>
    </div>
    <div class="card-body">
      <form action="signuphtml.php" method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username:</label>
          <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Mail-ID:</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password:</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirm Password:</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <h5>EV Details</h5>
        <div class="mb-3">
          <label for="vehicle_type" class="form-label">Vehicle Type:</label>
          <select id="vehicle_type" name="vehicle_type" class="form-control" required>
            <option value="Bike">Bike</option>
            <option value="Car">Car</option>
            <option value="Bus">Bus</option>
            <option value="Truck">Truck</option>
          </select>
        </div>
        <div class="mb-3">
          <label for="connector_type" class="form-label">Connector Type:</label>
          <select id="connector_type" name="connector_type" class="form-control" required>
            <option value="CCS">CCS</option>
            <option value="CHAdeMO">CHAdeMO</option>
            <option value="Tesla Supercharger">Tesla Supercharger</option>
            <option value="Type 2">Type 2</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <h5>Location Information</h5>
        <div class="mb-3">
          <label for="city" class="form-label">City:</label>
          <input type="text" class="form-control" id="city" name="city" required>
        </div>
        <div class="mb-3">
          <label for="state" class="form-label">State:</label>
          <input type="text" class="form-control" id="state" name="state" required>
        </div>
        <div class="mb-3">
          <label for="zip" class="form-label">PinCode:</label>
          <input type="text" class="form-control" id="zip" name="zip" required>
        </div>
        <div class="mb-3">
          <input type="checkbox" id="terms" required>
          <label for="terms">I agree to the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>.</label>
        </div>
        <div class="form-group">
          <button type="submit" id="signupButton" >Sign Up</button>
        </div>
        <div class="footer-links">
          <p>Already have an account? <a href="loginhtml.php">Log in</a> here.</p>
          <a href="#">Help Center</a> | <a href="#">Contact Us</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    var password = document.getElementById("password");
    var confirm_password = document.getElementById("confirm_password");
    function validatePassword() {
      if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }
    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;

    document.getElementById('terms').addEventListener('change', function () {
      signupButton.disabled = !this.checked;
    });
  </script>
</body>
</html>
