<?php
// Simulating database connection (Replace with actual DB connection)
$member_name = "James Chege";
$savings_balance = 75000;
$last_deposit = 5000;
$last_deposit_date = "05/10/2023";
$total_savings = $savings_balance;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Savings - SMARTFUND SACCO</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #6a1b9a;
        }
        .details {
            text-align: left;
            margin-bottom: 20px;
        }
        .details p {
            font-size: 16px;
            color: #4a148c;
            margin: 10px 0;
        }
        .details p span {
            font-weight: bold;
            color: #6a1b9a;
        }
        .back-button {
            background-color: #9c27b0;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }
        .back-button:hover {
            background-color: #7b1fa2;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>SMARTFUND SACCO</h2>
    <h3>View Savings</h3>
    <div class="details">
        <p><span>Member Name:</span> <?php echo htmlspecialchars($member_name); ?></p>
        <p><span>Savings Balance:</span> KES <?php echo number_format($savings_balance, 2); ?></p>
        <p><span>Last Deposit:</span> KES <?php echo number_format($last_deposit, 2); ?> (<?php echo htmlspecialchars($last_deposit_date); ?>)</p>
        <p><span>Total Savings:</span> KES <?php echo number_format($total_savings, 2); ?></p>
    </div>
    <button class="back-button" onclick="window.location.href='savingshares.php'">Back</button>
</div>

</body>
</html>