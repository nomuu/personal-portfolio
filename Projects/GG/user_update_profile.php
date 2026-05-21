<?php
session_start();
require 'config/db.php';

$email = $_POST['email'];
$nickname = $_POST['nickname'];
$profilePath = null;

// Validate nickname length
if (strlen($nickname) > 15) {
    die("Nickname must be 15 characters or less.");
}

// Handle profile image
if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
    $allowedTypes = ['image/jpeg', 'image/png'];
    $fileType = mime_content_type($_FILES['profile']['tmp_name']);

    if (!in_array($fileType, $allowedTypes)) {
        die("Invalid file type. Only JPG and PNG are allowed.");
    }

    $ext = strtolower(pathinfo($_FILES['profile']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
        die("Invalid file extension. Only .jpg, .jpeg, and .png are allowed.");
    }

    $targetDir = "uploads/profiles/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

    $filename = uniqid("profile_") . "." . $ext;
    $targetFile = $targetDir . $filename;

    if (move_uploaded_file($_FILES['profile']['tmp_name'], $targetFile)) {
        $profilePath = $targetFile;
    } else {
        die("Failed to upload the profile image.");
    }
}

// Update the database
if ($profilePath) {
    $sql = "UPDATE GG_users SET usernickname = ?, userProfile = ? WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nickname, $profilePath, $email);
} else {
    $sql = "UPDATE GG_users SET usernickname = ? WHERE userID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $nickname, $email);
}

$stmt->execute();
$stmt->close();

// Update session values
$_SESSION['user']['nickname'] = $nickname;
if ($profilePath) {
    $_SESSION['user']['profile'] = $profilePath;
}

header("Location: dashboard.php");
exit;
