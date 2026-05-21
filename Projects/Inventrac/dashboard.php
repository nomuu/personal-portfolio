<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventrac - Dashboard</title>
    <link rel="icon" href="images/icon.png" type="image/png">
    <!-- Bootstrap 5.3 CSS -->
    <link href="content/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <link href="content/css/dashboard.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
    <div class="text-center mb-3">
        <img src="images/logo.png" alt="Logo" class="img-fluid" style="max-width: 150px;">
    </div>
        <a href="dashboard.php">Dashboard</a>
        <a href="#">Supplier</a>
        <a href="#">Inventory</a>
        <a href="#">Tracking</a>
        <!-- Logout Button (Triggers Modal) -->
        <a href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">Logout</a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- User Info Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            User Information
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Welcome, <?= htmlspecialchars($user['name']) ?>!</h5>
                            <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Quick Stats Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            Quick Stats
                        </div>
                        <div class="card-body">
                            <p>Dashboard Overview</p>
                            <ul>
                                <li><strong>Users: </strong> 120</li>
                                <li><strong>Reports: </strong> 55</li>
                                <li><strong>Tasks: </strong> 9</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer-text">
                <p>&copy; 2025 Inventrac. All Rights Reserved. | <a href="#">Privacy Policy</a></p>
            </div>
        </div>
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
</body>

</html>
