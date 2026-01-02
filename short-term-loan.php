<?php
$loanAmount = $interestAmount = $repaymentAmount = $fineMessage = $blacklistMessage = "";
$savings = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $savings = isset($_POST['savings']) ? (float)$_POST['savings'] : 0;
    
    if ($savings < 1) {
        $errorMessage = "Please enter a valid savings amount.";
    } else {
        // Constants
        $INTEREST_RATE = 0.10; // 10% interest rate
        $LOAN_PERCENTAGE = 0.6; // 60% of savings
        $FINE_RATE = 0.05; // 5% fine for late payment

        // Calculate loan amount (60% of savings)
        $loanAmount = $savings * $LOAN_PERCENTAGE;

        // Calculate interest amount (10% of loan amount)
        $interestAmount = $loanAmount * $INTEREST_RATE;

        // Calculate repayment amount (loan + interest)
        $repaymentAmount = $loanAmount + $interestAmount;

        // Simulate late payment scenario
        $isLate = rand(0, 1); // 50% chance of late payment
        
        if ($isLate) {
            $fineAmount = $repaymentAmount * $FINE_RATE;
            $repaymentAmount += $fineAmount;
            $fineMessage = "Fine for 15 Days Late: Ksh " . number_format($fineAmount, 2);
            
            // Simulate blacklisting scenario
            $isBlacklisted = rand(0, 1); // 50% chance of blacklisting
            if ($isBlacklisted) {
                $blacklistMessage = "You have been blacklisted and are no longer eligible for loans.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Short-Term Loan - SmartFund</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3e5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
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
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            font-weight: bold;
            color: #7b1fa2;
        }
        input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ab47bc;
            border-radius: 4px;
            font-size: 14px;
        }
        button {
            background-color: #9c27b0;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        button:hover {
            background-color: #7b1fa2;
        }
        .result-box {
            background-color: #e1bee7;
            padding: 10px;
            border: 1px solid #ab47bc;
            border-radius: 4px;
            margin-bottom: 10px;
            font-size: 16px;
            font-weight: bold;
            color: #4a148c;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Short-Term Loan</h1>
        <form method="POST">
            <div class="input-group">
                <label for="savings">Total Savings (Ksh):</label>
                <input type="number" id="savings" name="savings" required>
            </div>
            <button type="submit">Calculate Loan</button>
        </form>

        <?php if (!empty($errorMessage)) : ?>
            <p class="error"> <?php echo $errorMessage; ?> </p>
        <?php elseif ($loanAmount > 0) : ?>
            <div class="results">
                <h4>Loan Details</h4>
                <div class="result-box">Loan Amount: Ksh <?php echo number_format($loanAmount, 2); ?></div>
                <div class="result-box">Interest Amount: Ksh <?php echo number_format($interestAmount, 2); ?></div>
                <div class="result-box">Total Repayment (After 1 Month): Ksh <?php echo number_format($repaymentAmount, 2); ?></div>
                <?php if ($fineMessage) : ?>
                    <div class="result-box"> <?php echo $fineMessage; ?> </div>
                <?php endif; ?>
                <?php if ($blacklistMessage) : ?>
                    <div class="error"> <?php echo $blacklistMessage; ?> </div>
                <?php else : ?>
                    <button onclick="window.location.href='collect-loan.php'">Collect Loan</button>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <button onclick="window.location.href='loan-type.php'">Back</button>
    </div>
</body>
</html>
