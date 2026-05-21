<?php
session_start();
require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userID = trim($_POST['userID']);
    $userrole = $_POST['userrole'];

    // Validate input
    if (empty($userID)) {
        die("User ID cannot be empty.");
    }

    // Check if user already exists
    $stmt = $conn->prepare("SELECT userID FROM Users WHERE userID = ?");
    $stmt->bind_param("s", $userID);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['notification'] = ['type' => 'danger', 'message' => 'User already exists!'];
        header("Location: admin_dashboard.php?page=users");
        exit;
    }
    $stmt->close();

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO Users (userID, userrole) VALUES (?, ?)");
    $stmt->bind_param("si", $userID, $userrole);
    
    if ($stmt->execute()) {
        // Prepare detailed message with user ID and role
        $roleName = $userrole == 0 ? 'Admin' : 'User';
        $_SESSION['notification'] = [
            'type' => 'success',
            'message' => "User <strong>$userID</strong> with role <strong>$roleName</strong> added successfully!"
        ];
    } else {
        // If insertion failed, show the userID and role in the error message
        $roleName = $userrole == 0 ? 'Admin' : 'User';
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => "Failed to add user <strong>$userID</strong> with role <strong>$roleName</strong>. Please try again."
        ];
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_dashboard.php?page=users");
}
?>
