<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user']['email'])) {
    echo "User email is missing from session.";
    exit;
}

if (!isset($_POST['event_id'])) {
    echo "Event ID is missing.";
    exit;
}

$eventID = $_POST['event_id'];
$userID = $_SESSION['user']['email']; // using email as userID
$status = 0;

// Check if user already joined the event
$stmt = $conn->prepare("SELECT 1 FROM GG_event_register WHERE eventID = ? AND userID = ?");
$stmt->bind_param("ss", $eventID, $userID);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    // Already joined; optionally redirect or show a message
    $_SESSION['message'] = "You have already joined this event.";
    header("Location: dashboard.php?page=events");
    exit;
}

// Insert new record
$stmt = $conn->prepare("INSERT INTO GG_event_register (eventID, userID, status) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $eventID, $userID, $status);
$stmt->execute();

$_SESSION['message'] = "Successfully joined the event!";
header("Location: dashboard.php?page=events");
exit;
?>
