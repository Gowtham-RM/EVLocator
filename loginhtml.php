<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "ev_charge_loc");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST["username"]); //login
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            // Start session and set session variables
            session_start();
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["username"] = $user["username"];

            // Send alert and redirect using JavaScript
            echo "<script>
                window.location.href = 'home.php';
                </script>";
            exit;
        } else {
            echo "<script>
                alert('Invalid password. Please try again.');
                window.history.back();
                </script>";
        }
    } else {
        echo "<script>
            alert('No user found with this email.');
            window.history.back();
            </script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to bottom right, #6c63ff, #43cea2);
      font-family: Arial, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0;
    }
    .card {
      width: 80%; 
      max-width: 400px; /* Set a maximum width for better scaling */
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
    .signup-link {
      text-align: center;
      margin-bottom: 15px;
    }
    .signup-link a {
      color: #007bff;
      text-decoration: none;
      font-size: 14px;
      font-weight: 600;
      transition: color 0.3s ease, transform 0.2s ease;
    }
    .signup-link a:hover {
      color: #0056b3;
      text-decoration: underline;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h4>Login</h4>
          </div>
          <div class="card-body">
            <form action="loginhtml.php" method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Name:</label>
                <input type="text" class="form-control" name="username" id="username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
              </div>
              <div class="signup-link">
                <p> New User?<a href="signuphtml.php"> Sign Up</a></p>
              </div>
              <div class="form-group">
                <button type="submit" id="loginButton">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
