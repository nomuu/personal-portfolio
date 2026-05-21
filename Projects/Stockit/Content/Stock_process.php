<?php
// Start the session
session_start();

// Include the database connection file
require_once '../Config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $productId = $_POST['producttype'];  // Assuming this is the Product ID from Productlist
    $productName = $_POST['productname'];
    $netWeight = $_POST['netweight'];
    $quantity = $_POST['quantity'];
    $storeId = $_POST['store'];  // Retrieve store ID from the form
    
    // Retrieve the current user ID from the session
    $addedBy = isset($_SESSION['userID']) ? $_SESSION['userID'] : null;
    
    // Get current date and time
    $dateAdded = date('Y-m-d H:i:s');
    
    // Prepare the SQL statement to insert into Stocklist
    $sql = "INSERT INTO Stocklist (Productid, Productname, Netweight, Quantity, Dateadded, addedby, Store)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $productId, $productName, $netWeight, $quantity, $dateAdded, $addedBy, $storeId);
    
    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to Dashboard with success status and preserved page parameter
        header("Location: ../Dashboard.php?page=Stock&status=success");
        exit();
    } else {
        // Redirect to Dashboard with error status and preserved page parameter
        header("Location: ../Dashboard.php?page=Stock&status=error");
        exit();
    }
    // Close connections
    $stmt->close();
}
$conn->close();
?>
