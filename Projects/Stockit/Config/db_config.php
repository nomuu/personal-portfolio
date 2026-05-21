<?php
// db_connect.php

// Database configuration
$host = 'localhost';
$db   = 'Beaniriadb';
$user = 'Beaniriadb';
$pass = 'R0nald_mendoza';

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>
