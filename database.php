<?php
// Set your database credentials
$host = "localhost";
$dbname = "gawaqq"; // Your database name
$username = "root"; // Your database username (default is root for XAMPP)
$password = ""; // Your database password (leave blank for localhost)

$mysqli = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

// Ensure the 'users' table exists
$mysqli->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'client') NOT NULL DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    email_verified TINYINT(1) NOT NULL DEFAULT 0,  -- Column for email verification status
    verification_token VARCHAR(255) DEFAULT NULL  -- Column to store the verification token
);");

return $mysqli;
?>
