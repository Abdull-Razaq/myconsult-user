<?php
include "config.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    $_SESSION["error"] = "Unauthorized access.";
    header("Location: fetch_hours.php");
    exit();
}

// submit_hours.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $hours = isset($_POST["hours"]) ? trim($_POST["hours"]) : null;
    $task_name = isset($_POST["task_name"]) ? trim($_POST["task_name"]) : null;
    $task_description = isset($_POST["task_description"]) ? trim($_POST["task_description"]) : null;
    $status = 'pending'; // Default status for normal users

    // Validate input
    if (!$hours || !$task_name || !$task_description) {
        $_SESSION["error"] = "All fields are required!";
        header("Location: fetch_hours.php");
        exit();
    }

    // Insert into the database
    $sql = "INSERT INTO log_hours (user_id, hours, task_name, task_description, status) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisss", $user_id, $hours, $task_name, $task_description, $status);

    if ($stmt->execute()) {
        $_SESSION["success"] = "Hours logged successfully!";
    } else {
        $_SESSION["error"] = "Error: " . $stmt->error;
    }

    header("Location: homepage.html");
    exit();
}
?>
