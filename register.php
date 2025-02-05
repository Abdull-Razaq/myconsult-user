<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if fields exist before using them
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    // Validate fields
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required!");
    }

    // Hash Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into database
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("Location: signin.html");  // Redirect to login page
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
