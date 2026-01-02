<?php
// Sample data (replace with database query if needed)
$member_name = "James Chege";
$shares_balance = 150000;
$last_contribution = 10000;
$last_contribution_date = "05/10/2023";
$total_shares = 1500;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Shares - SMARTFUND SACCO</title>
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
    <h3>View Shares</h3>
    <div class="details">
        <p><span>Member Name:</span> <?php echo $member_name; ?></p>
        <p><span>Shares Balance:</span> KES <?php echo number_format($shares_balance); ?></p>
        <p><span>Last Contribution:</span> KES <?php echo number_format($last_contribution); ?> (<?php echo $last_contribution_date; ?>)</p>
        <p><span>Total Shares:</span> <?php echo number_format($total_shares); ?></p>
    </div>
    <button class="back-button" onclick="window.location.href='savingshares.php'">Back</button>
</div>
</body>
</html>