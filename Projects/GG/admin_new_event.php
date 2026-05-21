<?php
session_start();
require 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $eventName = trim($_POST['eventName']);
    $eventDescription = trim($_POST['eventDescription']);
    $eventLocation = trim($_POST['eventLocation']);
    $eventDate = $_POST['eventDate'];

    // Basic validation
    if (empty($eventName) || empty($eventDescription) || empty($eventLocation) || empty($eventDate)) {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => 'Please fill in all required fields.'
        ];
        header("Location: admin_dashboard.php?page=events");
        exit;
    }

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO GG_event (eventname, eventdescription, eventlocation, eventdate, status) VALUES (?, ?, ?, ?, 0)");
    $stmt->bind_param("ssss", $eventName, $eventDescription, $eventLocation, $eventDate);

    if ($stmt->execute()) {
        $_SESSION['notification'] = [
            'type' => 'success',
            'message' => "Event <strong>$eventName</strong> added successfully!"
        ];
    } else {
        $_SESSION['notification'] = [
            'type' => 'danger',
            'message' => "Failed to add event <strong>$eventName</strong>. Please try again."
        ];
    }

    $stmt->close();
    $conn->close();

    header("Location: admin_dashboard.php?page=events");
    exit;
}
?>
