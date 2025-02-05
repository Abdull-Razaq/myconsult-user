<?php
$host = "localhost";
$user = "root";  // Default XAMPP user
$pass = "";  // No password by default
$dbname = "myconsulthours-1";  // Your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
