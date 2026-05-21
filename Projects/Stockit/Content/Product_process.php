<?php
// Start the session
session_start();

// Include the database connection file
require_once '../Config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $productType = $_POST['producttype'];
    $productName = $_POST['productname'];
    
    // Retrieve the current user ID from the session
    $addedBy = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
    
    // Get current date and time
    $dateAdded = date('Y-m-d H:i:s');
    
    // Prepare the SQL statement
    $sql = "INSERT INTO Productlist (Producttype, Productname, dateadded, addedby)
            VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $productType, $productName, $dateAdded, $addedBy);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to Dashboard with success status and preserved page parameter
        header("Location: ../Dashboard.php?page=Product&status=success");
        exit();
    } else {
        // Redirect to Dashboard with error status and preserved page parameter
        header("Location: ../Dashboard.php?page=Product&status=error");
        exit();
    }
    // Close connections
    $stmt->close();
}
$conn->close();
?>