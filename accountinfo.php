<?php
session_start();

// Database connection
$host = "localhost"; 
$username = "root";  
$password = "";      
$database = "smartfund_sacco"; // Updated database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $user_id);

if (!$stmt->execute()) {
    die("Execution failed: " . $stmt->error);
}

$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #e6e6fa;
            color: black;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            min-height: 100vh;
        }

        .account-container {
            width: 100%;
            max-width: 800px;
            background-color: white;
            margin: 40px auto;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .form-group button {
            background-color: #9370db;
            color: white;
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #6a4c9c;
        }

        .success {
            color: green;
            margin-bottom: 20px;
        }

        .error {
            color: red;
            margin-bottom: 20px;
        }

        .back-btn, .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #9370db;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .back-btn:hover, .logout-btn:hover {
            background-color: #6a4c9c;
        }

        .logout-btn {
            background-color: #ff4d4d;
        }

        .logout-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="account-container">
        <header>
            <h1>Account Information</h1>
        </header>

        <!-- Display success or error messages -->
        <?php if (!empty($_SESSION['message'])): ?>
            <p class="success"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <p class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php endif; ?>

        <form action="update_account.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user['id']); ?>">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>

            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>

            <div class="form-group">
                <label>Profile Photo</label>
                <input type="file" name="profile_photo" accept="image/*">
                <?php if (!empty($user['profile_photo'])): ?>
                    <img src="uploads/<?php echo htmlspecialchars($user['profile_photo']); ?>" width="150" alt="Profile Photo">
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <button type="submit">Update Information</button>
            </div>
        </form>

        <a href="dashboard.php" class="back-btn">Back to Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</body>
</html>
