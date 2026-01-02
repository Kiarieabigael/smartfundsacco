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

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Handle loan type selection
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['loan_type'])) {
    $loan_type = $_POST['loan_type'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

    // Insert loan request into database
    $stmt = $conn->prepare("INSERT INTO loans (user_id, loan_type, status) VALUES (?, ?, 'pending')");
    $stmt->bind_param("is", $user_id, $loan_type);

    if ($stmt->execute()) {
        echo "<script>alert('Loan type selected successfully! Redirecting...');</script>";
        echo "<script>window.location.href='loan-details.php';</script>";
    } else {
        echo "<script>alert('Error selecting loan type. Try again!');</script>";
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
    <title>Choose Loan Type - SmartFund</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f3e5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #6a1b9a;
            margin-bottom: 20px;
        }
        .loan-options {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .loan-option {
            background-color: #9c27b0;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .loan-option:hover {
            background-color: #7b1fa2;
        }
        .loan-option.long-term {
            background-color: #ab47bc;
        }
        .loan-option.long-term:hover {
            background-color: #8e24aa;
        }
        .back-button {
            margin-top: 20px;
            background-color: #e1bee7;
            color: #6a1b9a;
            padding: 10px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #ce93d8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Choose Your Loan Type</h1>
        <form method="POST">
            <div class="loan-options">
                <button type="submit" name="loan_type" value="short-term" class="loan-option short-term">Short-Term Loan</button>
                <button type="submit" name="loan_type" value="long-term" class="loan-option long-term">Long-Term Loan</button>
            </div>
        </form>
        <button class="back-button" onclick="window.location.href='eligibility.php'">Back to Eligibility Check</button>
    </div>
</body>
</html>
