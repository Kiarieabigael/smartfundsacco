<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "smartfund_sacco";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST['amount'];
    $paymentMethod = $_POST['paymentMethod'];
    $name = $phone = $bankName = $bankAccount = "";

    if ($paymentMethod == "mpesa") {
        $name = $_POST['mpesaName'];
        $phone = $_POST['mpesaPhone'];
    } elseif ($paymentMethod == "bank") {
        $name = $_POST['bankName'];
        $bankAccount = $_POST['bankAccount'];
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO deposits (amount, payment_method, name, phone, bank_name, bank_account) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $amount, $paymentMethod, $name, $phone, $bankName, $bankAccount);

    if ($stmt->execute()) {
        echo "<script>alert('Deposit Successful!'); window.location.href='deposit_form.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
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
    <title>Deposit Amount - SMARTFUND SACCO</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .container { background-color: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 350px; text-align: center; }
        h2 { color: #6a1b9a; }
        label { display: block; font-weight: bold; color: #4a148c; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #9c27b0; color: #fff; border: none; padding: 10px; cursor: pointer; width: 100%; }
        .hidden { display: none; }
    </style>
</head>
<body>
<div class="container">
    <h2>SMARTFUND SACCO</h2>
    <h3>Deposit Amount</h3>
    <form method="POST" action="">
        <label>Amount (KES):</label>
        <input type="number" name="amount" min="1" required>
        
        <label>Payment Method:</label>
        <select name="paymentMethod" id="paymentMethod" required>
            <option value="">Select Payment Method</option>
            <option value="mpesa">M-Pesa</option>
            <option value="bank">Bank</option>
        </select>
        
        <div id="mpesaDetails" class="hidden">
            <label>Full Name:</label>
            <input type="text" name="mpesaName">
            <label>Phone Number:</label>
            <input type="text" name="mpesaPhone">
        </div>
        
        <div id="bankDetails" class="hidden">
            <label>Full Name:</label>
            <input type="text" name="bankName">
            <label>Account Number:</label>
            <input type="text" name="bankAccount">
        </div>
        
        <button type="submit">Deposit Amount</button>
    </form>
</div>

<script>
    document.getElementById("paymentMethod").addEventListener("change", function () {
        document.getElementById("mpesaDetails").style.display = this.value === "mpesa" ? "block" : "none";
        document.getElementById("bankDetails").style.display = this.value === "bank" ? "block" : "none";
    });
</script>
</body>
</html>
