<?php
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
    <title>GG - Grease and Gears</title>
    <link rel="icon" href="images/icon.png" type="image/png">
    <!-- Bootstrap 5.3 CSS -->
    <link href="content/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for styling -->
    <link href="content/css/index.css" rel="stylesheet">
</head>
<body>
<div class="bg-slider">
    <div class="slide" style="background-image: url('images/bg/bg1.jpg');"></div>
    <div class="slide" style="background-image: url('images/bg/bg2.jpg');"></div>
    <div class="slide" style="background-image: url('images/bg/bg3.jpg');"></div>
    <div class="slide" style="background-image: url('images/bg/bg4.jpg');"></div>
    <div class="slide" style="background-image: url('images/bg/bg5.jpg');"></div>
</div>
<div class="container">
    <div class="login-box">
        <img src="images/logo.png" alt="Inventrac Logo"> <!-- Replace with your logo -->
        <h3>Welcome to Grease and Gears (GG) Web Portal</h3>
        <p>This is the official web portal of Grease and Gears (GG), a Tamiya Mini 4WD team.
A group of racers brought together by a shared hobby — exchanging guides, tips, and knowledge to keep the wheels turning.</p>
        <hr>
        <a href="<?= $googleAuthUrl ?>" class="btn-google">
            Login with Google
        </a>
        <br>
        <!-- Display error message if set -->
        <?php if ($errorMessage): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="footer-text">
    <p>&copy; 2025 Inventrac. All Rights Reserved. | <a href="#">Privacy Policy</a></p>
</div>

<!-- Bootstrap 5.3 JS, Popper.js -->
<script src="content/js/popper.min.js"></script>
<script src="content/js/bootstrap.min.js"></script>

</body>
</html>