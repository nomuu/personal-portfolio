<?php
// 1. Force errors to show so you don't get a blank white screen
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config/sso.php';
require 'config/db.php'; 

// Ensure session is started (required for state and user session)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the state matches to prevent CSRF attacks
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['state']) {
    exit("Invalid request. State mismatch. Possible CSRF attack.");
}

if (!isset($_GET['code'])) {
    exit("Login failed: No code provided by Google.");
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
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Keep this false for testing on local/cPanel
$response = curl_exec($ch);

// 2. Check if the network request itself failed
if (curl_errno($ch)) {
    exit('cURL Error: ' . curl_error($ch));
}
curl_close($ch);

$tokenData = json_decode($response, true);

// 3. Check if Google sent back an error (e.g., "invalid_grant" or "redirect_uri_mismatch")
if (!isset($tokenData['access_token'])) {
    echo "<h3>Google Authentication Error</h3>";
    echo "<p>Google did not return an access token. Details:</p>";
    echo "<pre>"; print_r($tokenData); echo "</pre>";
    exit;
}

// Get user info
$userInfoUrl = "https://www.googleapis.com/oauth2/v2/userinfo";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $userInfoUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $tokenData['access_token']]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$userResponse = curl_exec($ch);
$userInfo = json_decode($userResponse, true);
curl_close($ch);

if (!isset($userInfo['email'])) {
    exit("Failed to retrieve user info from Google.");
}

$userEmail = $userInfo['email']; 

// Query the database
$sql = "SELECT UserID, Userrole FROM weevu_users WHERE UserID = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    exit("SQL Prepare Error: " . $conn->error);
}
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    $_SESSION['error'] = "You are not authorized. Email $userEmail not found in our database.";
    header("Location: index.php");
    exit;
}

$stmt->bind_result($userID, $UserRole);
$stmt->fetch();
$stmt->close();

$_SESSION['user'] = [
    'name' => isset($userInfo['name']) ? $userInfo['name'] : $userEmail,
    'userid' => $userEmail
];

// Redirect based on user role
if ($UserRole == 0) {
    header("Location: admin_dashboard.php");
} else {
    header("Location: dashboard.php");
}
exit;