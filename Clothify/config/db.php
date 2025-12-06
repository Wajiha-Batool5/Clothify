<?php
// Database configuration
$servername = "localhost";
$username   = "root";
$password   = "";
$database   = "clothify";
$port       = 3307;

// Create MySQLi connection
$conn = new mysqli($servername, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to UTF-8
$conn->set_charset("utf8");
?>
