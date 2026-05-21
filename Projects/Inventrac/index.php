<?php
// Start session to access error message
session_start();

// Check if there is an error message to display
$errorMessage = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']); // Clear the error message after displaying it

require 'config/sso.php';

// Generate state token for CSRF protection
$_SESSION['state'] = bin2hex(random_bytes(8));

// Google OAuth URL
$googleAuthUrl = "https://accounts.google.com/o/oauth2/auth" . 
    "?client_id=$googleClientId" . 
    "&response_type=code" . 
    "&redirect_uri=" . urlencode($redirectUri) . 
    "&scope=email%20profile" . 
    "&state=" . $_SESSION['state'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventrac - Home</title>
    <link rel="icon" href="images/icon.png" type="image/png">
    <!-- Bootstrap 5.3 CSS -->
    <link href="content/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <link href="content/css/index.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="images/logo.png" alt="Inventrac Logo" width="120" height="40" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav me-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#developer">Developer</a>
                </li>
            </ul>
            <a href="<?= $googleAuthUrl ?>" class="btn btn-outline-light">
                Login with Google
            </a>
        </div>
    </div>
</nav>
<!-- Home Section -->
<section id="home" class="vh-100 d-flex">
    <div class="container">
        <div class="login-box text-center">
            <img src="images/logo.png" alt="Inventrac Logo">
            <p>Your digital partner for efficient product monitoring and compliance tracking. With Inventrac, you can streamline your product tracking processes, ensure compliance with regulations, and improve productivity—all in one place.</p>

<!-- Modal for Error Message -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Permission Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if ($errorMessage): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($errorMessage); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
        </div>
    </div>
</section>
<!-- About Section -->
<section id="about" class="vh-100 d-flex align-items-center text-light" style="background-color: rgba(0, 0, 0, 0.5);">
    <div class="container">
        <div class="row w-100">
            <!-- Left Column -->
            <div class="col-md-6">
                <h2 class="display-4 fw-bold mb-4">What is Inventrac?</h2>
                <p class="lead mb-4">Inventrac is a cloud-based platform designed to help businesses monitor product compliance, manage inventory, and ensure regulatory readiness — all in one place.</p>
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <ul class="list-unstyled">
                    <li class="mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-primary text-white rounded-circle me-3 p-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Real-time compliance monitoring</h5>
                                <p class="mb-0">Stay updated on compliance standards with real-time tracking and alerts.</p>
                            </div>
                        </div>
                    </li>
                    <li class="mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-primary text-white rounded-circle me-3 p-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Simplified product tracking</h5>
                                <p class="mb-0">Streamline your product tracking process and manage your inventory efficiently.</p>
                            </div>
                        </div>
                    </li>
                    <li class="mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-primary text-white rounded-circle me-3 p-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Dashboard insights and alerts</h5>
                                <p class="mb-0">Get insightful analytics and alerts directly from your dashboard.</p>
                            </div>
                        </div>
                    </li>
                    <li class="mb-3">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-primary text-white rounded-circle me-3 p-3">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Designed for audit-readiness</h5>
                                <p class="mb-0">Ensure your processes are always audit-ready with streamlined compliance features.</p>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- Developer Section -->
<section id="developer" class="vh-100 d-flex flex-column justify-content-center align-items-center text-center text-light" style="background-color: rgba(0, 0, 0, 0.5);">
    <h2 class="display-4 fw-bold mb-4">The Developer</h2>

    <!-- Developer Image (Rounded Square) -->
    <img src="images/profile.png" alt="Developer Image" class="img-fluid mb-4" style="width: 150px; height: 180px; border-radius: 10px;">

    <!-- Name -->
    <h5 class="mb-3">Ronald Fernandez Mendoza</h5>

    <!-- Website Button -->
    <a href="https://imronaldmendoza.com" class="btn btn-secondary btn-lg">Visit My Website</a>
</section>


<div class="footer-text">
    <p>&copy; 2025 Inventrac. All Rights Reserved. | <a href="#">Privacy Policy</a></p>
</div>

<!-- Bootstrap 5.3 JS, Popper.js -->
<script src="content/js/popper.min.js"></script>
<script src="content/js/bootstrap.min.js"></script>
<script>
    <?php if ($errorMessage): ?>
        var myModal = new bootstrap.Modal(document.getElementById('errorModal'));
        myModal.show();
    <?php endif; ?>
</script>
</body>
</html>
