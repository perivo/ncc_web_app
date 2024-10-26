<?php
// config.php

// Database configuration
$host = 'localhost: 3305';          // Database host
$db_name = 'ncc_web_app';   // Database name
$db_user = 'root';   // Database user
$db_pass = '';   // Database password

// Create a connection to the database
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set the character set to utf8
$conn->set_charset("utf8");
?>
