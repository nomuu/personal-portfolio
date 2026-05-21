<?php
require 'config/sso.php';
require 'config/db.php'; // Include the database connection

// Check if the state matches to prevent CSRF attacks
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['state']) {
    exit("Invalid request. Possible CSRF attack.");
}

if (!isset($_GET['code'])) {
    exit("Login failed.");
}

$code = $_GET['code'];

// Exchange authorization code for access token
$tokenUrl = "https://oauth2.googleapis.com/token";
$postData = http_build_query([
    "client_id" => $googleClientId,
    "client_secret" => $googleClientSecret,
    "grant_type" => "authorization_code",
    "code" => $code,
    "redirect_uri" => $redirectUri
]);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $tokenUrl);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$tokenData = json_decode($response, true);

if (!isset($tokenData['access_token'])) {
    exit("Failed to get access token.");
}

// Get user info
$userInfoUrl = "https://www.googleapis.com/oauth2/v2/userinfo";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $tokenData['access_token']]);
$userInfo = json_decode(curl_exec($ch), true);
curl_close($ch);

if (!isset($userInfo['email'])) {
    exit("Failed to retrieve user info.");
}

$userEmail = $userInfo['email']; // The email address of the logged-in user

// Query the database to check if the user is allowed and get the role
$sql = "SELECT userID, Userrole FROM Users WHERE userID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->store_result();

// Check if user exists in the database
if ($stmt->num_rows === 0) {
    // Set error message and redirect back to the login page
    $_SESSION['error'] = "You are not authorized to access this website.";
    header("Location: index.php"); // Redirect to login page
    exit;
}

// Fetch the user data
$stmt->bind_result($userID, $UserRole);
$stmt->fetch();
$stmt->close();

// Store user session
$_SESSION['user'] = [
    'name' => $userInfo['name'],
    'email' => $userEmail
];

// Redirect based on user role
if ($UserRole == 0) {
    header("Location: admin_dashboard.php"); // Redirect to admin dashboard
    exit;
} else {
    header("Location: dashboard.php"); // Redirect to user dashboard
    exit;
}
