<?php
session_start();
require 'config/db.php'; // Make sure this path is correct and this file sets $conn properly

if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}

$user = $_SESSION['user'];

// Determine page to load
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weevu - Admin</title>
    <link rel="icon" href="images/icon.png" type="image/png">
    <!-- Bootstrap 5.3 CSS -->
    <link href="content/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <link href="content/css/admin_dashboard.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
    <div class="text-center mb-3">
        <img src="images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
    </div>
        <a href="dashboard.php">Dashboard</a>
        <a href="dashboard.php?page=events">Events</a>
        <a href="dashboard.php?page=gallery">Gallery</a>
        <a href="#">Merch</a>
        <!-- Logout Button (Triggers Modal) -->
        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
    </div>
    
<div class="sidebar-toggler" onclick="toggleSidebar()">☰</div>

<div class="content" id="content">
    <br>
    <?php
        if ($page === 'events') {
            include 'user_event.php';
        }
        else if ($page === 'gallery') {
            include 'user_gallery.php';
        }
        else { ?>
            <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <?php include 'user_info.php'; ?>

                <div class="col-md-4">
                    <!-- Quick Stats Card -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning">
                            Upcoming Events
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <!-- User Info Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            GG Members 
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer-text">
                <p>&copy; 2025 GG. All Rights Reserved. | <a href="#">Privacy Policy</a></p>
            </div>
        </div>
    </div>
        <?php
        }
    ?>
</div>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">Logout Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to log out?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a href="logout.php" class="btn btn-primary">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
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
