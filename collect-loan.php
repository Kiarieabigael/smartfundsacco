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
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    
    if (isset($_POST['mpesa_phone']) && isset($_POST['mpesa_name'])) {
        $mpesa_phone = $conn->real_escape_string($_POST['mpesa_phone']);
        $mpesa_name = $conn->real_escape_string($_POST['mpesa_name']);
        
        $sql = "INSERT INTO loans (user_id, method, phone, name) VALUES ('$user_id', 'M-Pesa', '$mpesa_phone', '$mpesa_name')";
    } elseif (isset($_POST['bank_name']) && isset($_POST['account_number']) && isset($_POST['account_name'])) {
        $bank_name = $conn->real_escape_string($_POST['bank_name']);
        $account_number = $conn->real_escape_string($_POST['account_number']);
        $account_name = $conn->real_escape_string($_POST['account_name']);
        
        $sql = "INSERT INTO loans (user_id, method, bank_name, account_number, account_name) VALUES ('$user_id', 'Bank', '$bank_name', '$account_number', '$account_name')";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Loan collection request submitted successfully!'); window.location.href='thank-you.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Collect Loan - SmartFund</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f3e5f5; text-align: center; }
        .container { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); max-width: 400px; margin: auto; }
        .input-group { margin-bottom: 15px; text-align: left; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ab47bc; border-radius: 4px; }
        button { background-color: #9c27b0; color: white; padding: 10px 20px; border-radius: 4px; border: none; cursor: pointer; }
        button:hover { background-color: #7b1fa2; }
        .hidden { display: none; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Collect Loan</h1>
        <p>Choose how you would like to receive your loan:</p>
        <button id="mpesa-button">Receive via M-Pesa</button>
        <button id="bank-button">Receive via Bank</button>
        <form method="POST" id="mpesa-form" class="hidden">
            <h4>M-Pesa Details</h4>
            <div class="input-group">
                <label for="mpesa-phone">M-Pesa Phone Number:</label>
                <input type="text" name="mpesa_phone" required>
            </div>
            <div class="input-group">
                <label for="mpesa-name">Your Full Name:</label>
                <input type="text" name="mpesa_name" required>
            </div>
            <button type="submit">Submit</button>
        </form>
        <form method="POST" id="bank-form" class="hidden">
            <h4>Bank Details</h4>
            <div class="input-group">
                <label for="bank-name">Bank Name:</label>
                <input type="text" name="bank_name" required>
            </div>
            <div class="input-group">
                <label for="account-number">Account Number:</label>
                <input type="text" name="account_number" required>
            </div>
            <div class="input-group">
                <label for="account-name">Account Holder Name:</label>
                <input type="text" name="account_name" required>
            </div>
            <button type="submit">Submit</button>
        </form>
    </div>
    <script>
        document.getElementById("mpesa-button").addEventListener("click", function() {
            document.getElementById("mpesa-form").classList.remove("hidden");
            document.getElementById("bank-form").classList.add("hidden");
        });
        document.getElementById("bank-button").addEventListener("click", function() {
            document.getElementById("bank-form").classList.remove("hidden");
            document.getElementById("mpesa-form").classList.add("hidden");
        });
    </script>
</body>
</html>