<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the username and password from the form
    $username = isset($_POST["username"]) ? trim($_POST["username"]) : "";
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    // Check if username or password is empty
    if (empty($username) || empty($password)) {
        die("Username and password are required!");
    }

    // Query the database for the user by username
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify user and password
    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        echo "Login successful!";
        header("Location: homepage.html"); // Redirect to dashboard
        exit();
    } else {
        echo "Invalid username or password!";
    }
}
?>
