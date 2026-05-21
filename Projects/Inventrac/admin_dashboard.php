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
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            width: 220px;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
            z-index: 999;  /* Ensure sidebar stays on top */
        }
        .sidebar a {
            color: white;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
            transition: margin-left 0.3s ease-in-out;
        }
        @media (max-width: 767px) {
            .sidebar {
                display: none;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background-color: #343a40;
                padding-top: 60px;
                z-index: 1000; /* Sidebar appears above content */
            }
            .sidebar a {
                text-align: center;
                padding: 15px;
            }
            .content {
                margin-left: 0;
                width: 100%;
                transition: margin-left 0.3s ease-in-out;
                z-index: 1; /* Ensure content stays behind sidebar */
            }
            .sidebar.show {
                display: block;
            }
            .sidebar-toggler {
                display: block;
                background-color: #343a40;
                color: white;
                padding: 10px;
                text-align: center;
                cursor: pointer;
                position: absolute;
                top: 10px;
                left: 10px;
                z-index: 1100;  /* Make sure the toggle button is on top */
            }
            .content.open-sidebar {
                margin-left: 220px;  /* Shift content when sidebar is open */
            }
        }
    </style>
</head>
<body>

<div class="sidebar" id="sidebar">
    <div class="text-center mb-3">
        <img src="images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
    </div>
    <hr class="text-light">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="admin_dashboard.php?page=users">User Management</a>
    <a href="logout.php" class="text-danger">Logout</a>
</div>

<div class="sidebar-toggler" onclick="toggleSidebar()">☰</div>

<div class="content" id="content">
    <?php
        if ($page === 'users') {
            include 'user_management.php';
        } else {
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
