<?php
$conn = new mysqli('localhost', 'Beaniriadb', 'R0nald_mendoza', 'Beaniriadb');

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>