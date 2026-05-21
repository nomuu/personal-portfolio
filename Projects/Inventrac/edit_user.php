<?php
session_start();
require 'config/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

// Check if the user is an admin
if ($_SESSION['user']['userrole'] != 0) {
    header("Location: admin_dashboard.php");
    exit;
}

// Validate user ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit;
}

$userID = $_GET['id'];

// Fetch user data
$stmt = $conn->prepare("SELECT userID, userrole FROM Users WHERE userID = ?");
$stmt->bind_param("s", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// If user not found, redirect
if (!$user) {
    header("Location: admin_dashboard.php");
    exit;
}

// Update user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUserID = trim($_POST['userID']);
    $userrole = $_POST['userrole'];

    if (empty($newUserID)) {
        die("User ID cannot be empty.");
    }

    // Update user in database
    $stmt = $conn->prepare("UPDATE Users SET userID = ?, userrole = ? WHERE userID = ?");
    $stmt->bind_param("sis", $newUserID, $userrole, $userID);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully!'); window.location.href='admin_dashboard.php?page=users';</script>";
    } else {
        echo "<script>alert('Error updating user.'); window.location.href='admin_dashboard.php?page=users';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="content/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h1>Edit User</h1>
    <hr>

    <form action="" method="POST">
        <div class="mb-3">
            <label for="userID" class="form-label">User ID</label>
            <input type="text" class="form-control" id="userID" name="userID" value="<?= htmlspecialchars($user['userID']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="userrole" class="form-label">User Role</label>
            <select class="form-control" id="userrole" name="userrole" required>
                <option value="1" <?= $user['userrole'] == 1 ? 'selected' : '' ?>>User</option>
                <option value="0" <?= $user['userrole'] == 0 ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script src="content/js/bootstrap.min.js"></script>
</body>
</html>
