<?php
require 'config/db.php'; // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userID']) && isset($_POST['userrole'])) {
    $userID = $_POST['userID'];
    $userrole = $_POST['userrole'];

    // Update the user role in the database
    $stmt = $conn->prepare("UPDATE Users SET userrole = ? WHERE userID = ?");
    $stmt->bind_param("ii", $userrole, $userID);
    $stmt->execute();
    $stmt->close();

    // Redirect back to the admin dashboard
    header("Location: admin_dashboard.php");
    exit;
}
?>
