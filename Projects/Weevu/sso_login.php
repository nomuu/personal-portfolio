<?php
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