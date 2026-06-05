<?php
// Database connection for XAMPP / MySQL.
$host = 'localhost';
$dbName = 'chai_adda';
$dbUser = 'root';
$dbPass = '';

$conn = @new mysqli($host, $dbUser, $dbPass, $dbName);

if ($conn instanceof mysqli && !$conn->connect_error) {
    $conn->set_charset('utf8mb4');
}
    // Keep the site usable in demo mode even if MySQL is not configured yet.

