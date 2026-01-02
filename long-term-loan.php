<?php
$loanAmount = $monthlyPayment = $totalRepayment = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $savings = isset($_POST['savings']) ? (float)$_POST['savings'] : 0;
    $loanTerm = isset($_POST['loan_term']) ? (int)$_POST['loan_term'] : 0;
    $reason = isset($_POST['reason']) ? trim($_POST['reason']) : "";
    $guarantor1 = isset($_POST['guarantor1']) ? trim($_POST['guarantor1']) : "";
    $guarantor2 = isset($_POST['guarantor2']) ? trim($_POST['guarantor2']) : "";

    // Constants
    $LOAN_MULTIPLIER = 3; // Loan amount is 3 times savings
    $ANNUAL_INTEREST_RATE = 0.12; // 12% annual interest rate

    if ($savings < 1 || $loanTerm < 1 || $loanTerm > 24 || empty($reason) || empty($guarantor1) || empty($guarantor2)) {
        $errorMessage = "Please enter valid details for all fields.";
    } else {
        // Calculate loan amount
        $loanAmount = $savings * $LOAN_MULTIPLIER;

        // Calculate monthly interest rate
        $monthlyInterestRate = $ANNUAL_INTEREST_RATE / 12;

        // Calculate monthly payment using the loan formula
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$loanTerm));

        // Calculate total repayment amount
        $totalRepayment = $monthlyPayment * $loanTerm;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Long-Term Loan - SmartFund</title>
    <style>
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
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #6a1b9a;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #7b1fa2;
        }
        input, textarea {
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
        .results {
            margin-top: 20px;
        }
        h4 {
            font-size: 18px;
            margin-bottom: 10px;
            color: #6a1b9a;
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
        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Long-Term Loan</h1>

        <form method="POST">
            <div class="input-group">
                <label for="savings">Total Savings (Ksh):</label>
                <input type="number" id="savings" name="savings" required>
            </div>
            <div class="input-group">
                <label for="loan_term">Loan Term (Months, max 24):</label>
                <input type="number" id="loan_term" name="loan_term" min="1" max="24" required>
            </div>
            <div class="input-group">
                <label for="reason">Reason for Loan:</label>
                <textarea id="reason" name="reason" rows="3" placeholder="Explain why you need the loan" required></textarea>
            </div>

            <!-- Guarantors Section -->
            <div class="input-group">
                <label for="guarantor1">Guarantor 1 (Member ID):</label>
                <input type="text" id="guarantor1" name="guarantor1" placeholder="Enter Member ID" required>
            </div>
            <div class="input-group">
                <label for="guarantor2">Guarantor 2 (Member ID):</label>
                <input type="text" id="guarantor2" name="guarantor2" placeholder="Enter Member ID" required>
            </div>

            <button type="submit">Calculate Loan</button>
        </form>

        <?php if ($errorMessage): ?>
            <p class="error"><?php echo $errorMessage; ?></p>
        <?php elseif ($loanAmount > 0): ?>
            <div class="results">
                <h4>Loan Details</h4>
                <div class="result-box">Loan Amount: Ksh <?php echo number_format($loanAmount, 2); ?></div>
                <div class="result-box">Annual Interest Rate: 12%</div>
                <div class="result-box">Monthly Payment: Ksh <?php echo number_format($monthlyPayment, 2); ?></div>
                <div class="result-box">Total Repayment: Ksh <?php echo number_format($totalRepayment, 2); ?></div>
            </div>

            <!-- Collect Loan Button -->
            <button onclick="window.location.href='collect-loan.php'">Collect Loan</button>
        <?php endif; ?>

        <button onclick="window.location.href='loan-type.php'">Back</button>
    </div>
</body>
</html>
