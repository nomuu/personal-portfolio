<?php
// Start the session
session_start();

// Check if the user is logged in and if the userrole is 0
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["userrole"] != 0) {
    // Redirect to login page if not logged in or user role is not 0
    header("location: ../login.php");
    exit;
}

// Get the page from the URL parameter, default to 'Content'
$page = isset($_GET['page']) ? $_GET['page'] : 'Content';

// Sanitize the page parameter to avoid security issues
$page = preg_replace('/[^a-zA-Z0-9_]/', '', $page);

// Map the page to a corresponding PHP file
$allowed_pages = ['Content', 'Product', 'Stock', 'reports'];
if (in_array($page, $allowed_pages)) {
    $page_file = 'Content/' . $page . '.php';
} else {
    $page_file = 'Content/404.php'; // Optional: You can create a 404 page for non-existent pages
}

// Include the selected page
include $page_file;
?>
