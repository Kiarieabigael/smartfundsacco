<?php
session_start();
include ('database.php');

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo "You are not logged in.";
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Get logged-in user ID

// Fetch the user's email
$sql = "SELECT Email FROM users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();



$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartfund Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
        /* Global Styles */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #e6e6fa; /* Lavender Purple */
    color: black;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 100vh;
}

/* Dashboard Container */
.dashboard-container {
    width: 100%;
    max-width: 1200px;
    background-color: white;
    margin: 40px auto;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 30px;
}

/* Header Section */
header {
    text-align: center;
    margin-bottom: 40px;
}

header h1 {
    color: #6a4c9c; /* Dark Lavender Purple */
    font-size: 36px;
    margin-bottom: 10px;
}

header p {
    color: #6a4c9c;
    font-size: 18px;
    margin-bottom: 20px;
}

.logout-btn {
    font-size: 16px;
    color: white;
    background-color: #6a4c9c;
    padding: 10px 20px;
    border-radius: 6px;
    text-decoration: none;
    transition: background-color 0.3s;
}

.logout-btn:hover {
    background-color: #9370db; /* Lighter Lavender */
}

/* Dashboard Content Section */
.dashboard-content {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    display: flex;
    justify-content: space-around;
}

/* Dashboard Card */
.dashboard-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.dashboard-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
}

.dashboard-card h2 {
    font-size: 24px;
    color: #6a4c9c;
    margin-bottom: 15px;
}

.dashboard-card p {
    font-size: 16px;
    color: #333;
    margin-bottom: 20px;
}

.dashboard-card button {
    background-color: #9370db; /* Lavender Purple */
    color: white;
    padding: 12px 25px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.dashboard-card button:hover {
    background-color: #6a4c9c; /* Darker Lavender */
}

    </style>
</head>
<body>
<a href="logout.php" class="logout-btn">Logout</a>


    <!-- Dashboard Container -->
    <div class="dashboard-container">

        <!-- Header Section -->
        <header>
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION["username"]); ?>!</h1>
            <p>Your Smartfund Dashboard</p>
            <!-- <p><?php if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            echo "Your Email: <p>" . $row['Email']  ;
                        }
                        ?> 
            </p>            -->
        </header>

        <!-- Main Content Section -->
        <section class="dashboard-content">
            <div class="dashboard-card">
                <h2>Account Info</h2>
                <p> View your account details and update your information. </p>
                <button><a href="accountinfo.php">View Account</a></button>
            </div>

            <div class="dashboard-card">
                <h2>View Savings</h2>
                <p>Track your savings progress and manage your funds.</p>
                <button><a href="savingshares.php">View savings</a></button>
            </div>

            <div class="dashboard-card">
                <h2>Apply for loan</h2>
                <p>Access quick and easy loan approval based on your savings.</p>
                <button><a href="login.php">Apply loan</a></button>
            </div>
            
        </section>
        
    </div>

</body>
</html>