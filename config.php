<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$host = "localhost";  // Change this if your database is hosted elsewhere
$username = "root";   // Your database username (default is "root" for XAMPP)
$password = "";       // Your database password (leave empty if using XAMPP default)
$database = "smartfund_sacco"; // Change this to your actual database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
