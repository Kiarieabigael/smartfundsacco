<?php
session_start();
require_once "config.php"; // Make sure database config is in a separate file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $fullname = trim($_POST['fullname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Handle profile photo upload
    if (!empty($_FILES['profile_photo']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allowed file types
        $allowed_types = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_types)) {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            header("Location: accountinfo.php");
            exit();
        }

        // Move uploaded file
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            $profile_photo = basename($_FILES["profile_photo"]["name"]);
        } else {
            $_SESSION['error'] = "Error uploading profile photo.";
            header("Location: accountinfo.php");
            exit();
        }
    } else {
        $profile_photo = $_POST['existing_photo']; // Keep existing photo if none uploaded
    }

    // Update user details
    $sql = "UPDATE users SET name=?, username=?, email=?, phone=?, address=?, profile_photo=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $fullname, $username, $email, $phone, $address, $profile_photo, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Account information updated successfully!";
    } else {
        $_SESSION['error'] = "Error updating account.";
    }

    $stmt->close();
    header("Location: accountinfo.php");
    exit();
}
?>
