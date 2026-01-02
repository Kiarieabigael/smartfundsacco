<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$database = "smartfund_sacco";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect logged-in users to dashboard
if (isset($_SESSION['UserID'])) {
    header("Location: dashboard.php");
    exit();
}

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $sql = "SELECT * FROM users WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['Password'])) {
                // Store session data
                $_SESSION['UserID'] = $user['UserID'];
                $_SESSION['Username'] = $user['Username'];
                $_SESSION['Role'] = $user['Role'];

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<script>alert('Invalid password'); window.location='index.php';</script>";
            }
        } else {
            echo "<script>alert('User not found'); window.location='index.php';</script>";
        }
        $stmt->close();
    } elseif (isset($_POST['register'])) {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT);
        $role = "Member"; // Default role

        // Check if email already exists
        $checkEmail = $conn->prepare("SELECT Email FROM users WHERE Email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            echo "<script>alert('Email already registered. Please log in.'); window.location='index.php';</script>";
        } else {
            $sql = "INSERT INTO users (Username, Email, Password, Role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if (!$stmt) {
                die("Error preparing statement: " . $conn->error);
            }

            $stmt->bind_param("ssss", $name, $email, $password, $role);

            if ($stmt->execute()) {
                // Store session data
                $_SESSION['UserID'] = $conn->insert_id;
                $_SESSION['Username'] = $name;
                $_SESSION['Role'] = $role;

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                echo "<script>alert('Error: " . $stmt->error . "'); window.location='index.php';</script>";
            }
            $stmt->close();
        }
        $checkEmail->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartFund SACCO - Login & Sign Up</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body { display: flex; justify-content: center; align-items: center; height: 100vh; background: #EDE7F6; }
        .container { display: flex; width: 850px; height: 500px; background: white; border-radius: 15px; overflow: hidden; border: 2px solid #6A0572; transition: transform 0.5s ease-in-out; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); }
        .welcome-section { width: 50%; height: 100%; background: #6A0572; display: flex; justify-content: center; align-items: center; text-align: center; color: #fff; padding: 0 40px; font-size: 18px; }
        .forms-section { width: 50%; display: flex; align-items: center; justify-content: center; background: #F3E5F5; }
        .form-container { width: 80%; display: flex; flex-direction: column; align-items: center; text-align: center; }
        .form-container h2 { color: #6A0572; margin-bottom: 20px; }
        .form-container input { width: 100%; padding: 12px; margin: 10px 0; border: none; border-radius: 5px; outline: none; background: #fff; border: 1px solid #6A0572; }
        .form-container button { background: #6A0572; border: none; padding: 12px; width: 100%; border-radius: 5px; cursor: pointer; font-size: 16px; color: white; font-weight: bold; margin-top: 10px; }
        .hidden { display: none; }
    </style>
</head>
<body>
<div class="container">
    <div class="welcome-section">
        <h2>Welcome to SmartFund SACCO! 💰</h2>
        <p>Secure your future with reliable savings and loans. Join us today!</p>
    </div>
    <div class="forms-section">
        <div id="login-form" class="form-container">
            <h2>Member Login</h2>
            <form method="POST">
                <input type="email" name="email" placeholder="Email Address" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" name="login">Login</button>
            </form>
            <p>Not a member? <a href="#" onclick="toggleForm()">Join Now</a></p>
        </div>
        <div id="register-form" class="form-container hidden">
            <h2>Join SmartFund SACCO</h2>
            <form method="POST">
                <input type="text" name="name" placeholder="Full Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Create Password" required>
                <button type="submit" name="register">Register</button>
            </form>
            <p>Already a member? <a href="#" onclick="toggleForm()">Login</a></p>
        </div>
    </div>
</div>
<script>
    function toggleForm() {
        document.getElementById('login-form').classList.toggle('hidden');
        document.getElementById('register-form').classList.toggle('hidden');
    }
</script>
</body>
</html>
