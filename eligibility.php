<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $savings = isset($_POST['savings']) ? (float)$_POST['savings'] : 0;
    $duration = isset($_POST['duration']) ? (int)$_POST['duration'] : 0;
    
    if ($savings >= 9000 && $duration > 0) {
        header("Location: loan-type.php");
        exit();
    } else {
        $errorMessage = "Sorry, you are not eligible for a loan at this time.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartFund Loan Eligibility Checker</title>
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
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #6a1b9a;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 8px;
            font-weight: bold;
            color: #7b1fa2;
        }
        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ab47bc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            background-color: #9c27b0;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #7b1fa2;
        }
        .result {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>SmartFund Loan Eligibility Checker</h1>
        <form method="POST">
            <label for="savings">Total Savings (Ksh):</label>
            <input type="number" id="savings" name="savings" required>
            
            <label for="duration">Duration of Consistent Savings (Months):</label>
            <input type="number" id="duration" name="duration" required>
            
            <button type="submit">Check Eligibility</button>
        </form>
        
        <?php if (isset($errorMessage)): ?>
            <div class="result"><?php echo $errorMessage; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
