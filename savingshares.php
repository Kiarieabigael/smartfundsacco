<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case "view_shares":
                header("Location: view_shares.php");
                exit();
            case "deposit_shares":
                header("Location: deposit_amount.php?type=shares");
                exit();
            case "withdraw_shares":
                header("Location: withdraw_shares.php");
                exit();
            case "view_savings":
                header("Location: view_savings.php");
                exit();
            case "deposit_savings":
                header("Location: deposit_amount.php?type=savings");
                exit();
            case "withdraw_savings":
                header("Location: withdraw_savings.php");
                exit();
            case "back":
                echo "<script>window.history.back();</script>";
                exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartFUND Sacco</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: lavender;
            color: #4b0082;
            text-align: center;
            padding: 50px;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            display: inline-block;
        }
        button {
            background-color: #4b0082;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 5px;
        }
        button:hover {
            background-color: #6a5acd;
        }
        .section {
            margin-top: 20px;
        }
        .back-button {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to SmartFUND Sacco</h1>
        <p>Manage your shares and savings</p>

        <div class="section">
            <h2>Shares</h2>
            <form method="POST">
                <button type="submit" name="action" value="view_shares">View Shares</button>
                <button type="submit" name="action" value="deposit_shares">Deposit Shares</button>
                <button type="submit" name="action" value="withdraw_shares">Withdraw Shares</button>
            </form>
            <div id="sharesDetails"></div>
        </div>

        <div class="section">
            <h2>Savings</h2>
            <form method="POST">
                <button type="submit" name="action" value="view_savings">View Savings</button>
                <button type="submit" name="action" value="deposit_savings">Deposit Savings</button>
                <button type="submit" name="action" value="withdraw_savings">Withdraw Savings</button>
            </form>
            <div id="savingsDetails"></div>
        </div>

        <!-- Back Button -->
        <div class="back-button">
            <form method="POST">
                <button type="submit" name="action" value="back">Back</button>
            </form>
        </div>
    </div>
</body>
</html>
