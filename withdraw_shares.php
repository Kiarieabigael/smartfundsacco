<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $membershipDuration = $_POST['membershipDuration'];
    $outstandingLoan = $_POST['outstandingLoan'];
    $withdrawalAmount = $_POST['withdrawalAmount'];
    
    // Simulated user data
    $totalShares = 10000; // Total shares in KES
    $membershipDurationRequired = 6; // Minimum membership duration in months
    $withdrawalLimit = 0.5; // Maximum withdrawal limit (50% of total shares)
    $withdrawalFee = 0.02; // 2% withdrawal fee
    
    // Validation
    if ($membershipDuration < $membershipDurationRequired) {
        $errorMessage = "You must be a member for at least $membershipDurationRequired months to withdraw shares.";
    } elseif ($outstandingLoan === 'yes') {
        $errorMessage = "You must clear your outstanding loan before withdrawing shares.";
    } elseif ($withdrawalAmount > ($totalShares * $withdrawalLimit)) {
        $errorMessage = "You cannot withdraw more than " . number_format($totalShares * $withdrawalLimit) . " KES.";
    } else {
        $withdrawalFeeAmount = $withdrawalAmount * $withdrawalFee;
        $netAmount = $withdrawalAmount - $withdrawalFeeAmount;
        $successMessage = "Your withdrawal request for " . number_format($withdrawalAmount) . " KES has been approved.<br>
        A withdrawal fee of " . number_format($withdrawalFeeAmount) . " KES (2%) will be deducted.<br>
        You will receive " . number_format($netAmount) . " KES after approval.<br>
        Please allow 30-90 days for processing.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdraw Shares - SMARTFUND SACCO</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: lavender; color: #4b0082; text-align: center; padding: 50px; }
        .container { background-color: white; padding: 20px; border-radius: 10px; display: inline-block; width: 400px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        h2 { color: #6a1b9a; }
        label { display: block; margin-bottom: 10px; font-weight: bold; color: #4a148c; }
        input, select { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; }
        button { background-color: #9c27b0; color: white; border: none; padding: 10px 20px; border-radius: 4px; font-size: 16px; cursor: pointer; width: 100%; }
        .message { margin-top: 20px; font-size: 16px; color: #6a1b9a; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Withdraw Shares</h2>
        <?php if (!empty($errorMessage)) echo "<p class='error'>$errorMessage</p>"; ?>
        <?php if (!empty($successMessage)) { echo "<p class='message'>$successMessage</p>"; exit(); } ?>
        <form method="post">
            <label for="membershipDuration">Membership Duration (in months):</label>
            <input type="number" id="membershipDuration" name="membershipDuration" min="0" required>
            
            <label for="outstandingLoan">Do you have an outstanding loan?</label>
            <select id="outstandingLoan" name="outstandingLoan" required>
                <option value="">Select</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            
            <label for="withdrawalAmount">Amount to Withdraw (KES):</label>
            <input type="number" id="withdrawalAmount" name="withdrawalAmount" min="1" required>
            
            <button type="submit">Submit Withdrawal Request</button>
        </form>
    </div>
</body>
</html>