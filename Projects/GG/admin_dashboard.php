<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['userrole'] != 0) {
    header("Location: index.php");
    exit;
}

// Determine page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="icon" href="images/icon.png" type="image/png">
    <link href="content/css/bootstrap.min.css" rel="stylesheet">
    <link href="content/css/admin_dashboard.css" rel="stylesheet">
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="text-center mb-3">
        <img src="images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
    </div>
    <hr class="text-light">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_dashboard.php?page=events">Events</a>
    <a href="admin_dashboard.php?page=users">User Management</a>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="sidebar-toggler" onclick="toggleSidebar()">☰</div>

<div class="content" id="content">
    <?php
        if ($page === 'users') {
            include 'user_management.php';
        } 
        else if ($page === 'events') {
            include 'admin_event.php';
        }
        else {
            echo "<h2>Welcome to the Admin Dashboard</h2>";
        }
    ?>
</div>

<script src="content/js/popper.min.js"></script>
<script src="content/js/bootstrap.min.js"></script>
<script>
    function toggleSidebar() {
        var sidebar = document.getElementById('sidebar');
        var content = document.getElementById('content');
        
        sidebar.classList.toggle('show');
        content.classList.toggle('open-sidebar');  // This shifts content to the right when the sidebar is open
    }
</script>

</body>
</html>
