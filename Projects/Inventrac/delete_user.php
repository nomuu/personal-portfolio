<?php
session_start();
require 'config/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Check if admin
if ($_SESSION['user']['userrole'] != 0) {
    header("Location: admin_dashboard.php");
    exit;
}

// Check if user ID is set
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$userID = $_GET['id'];

// Prevent deleting yourself
if ($_SESSION['user']['userID'] == $userID) {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => 'You cannot delete your own account.'
    ];
    header("Location: admin_dashboard.php?page=users");
    exit;
}

// Delete user
$stmt = $conn->prepare("DELETE FROM Users WHERE userID = ?");
$stmt->bind_param("s", $userID);

if ($stmt->execute()) {
    $_SESSION['notification'] = [
        'type' => 'success',
        'message' => "User <strong>$userID</strong> deleted successfully!"
    ];
} else {
    $_SESSION['notification'] = [
        'type' => 'danger',
        'message' => "Failed to delete user <strong>$userID</strong>."
    ];
}

$stmt->close();
$conn->close();

header("Location: admin_dashboard.php?page=users");
exit;
?>
