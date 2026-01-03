<?php
// db.php
$host = 'localhost';
$db   = 'sleep_quality';
$user = 'root';
$pass = '';
$port = 3306;

// Create mysqli connection
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
