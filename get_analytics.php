<?php
include "config.php";
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    $_SESSION["error"] = "Unauthorized access.";
    header("Location: fetch_hours.php");
    exit();
}

// Get the user ID
$user_id = $_SESSION["user_id"];

// Get today's date, the start of the week, and the start of the month
$today = date('Y-m-d');
$start_of_week = date('Y-m-d', strtotime('last sunday')); // Start of this week (Sunday)
$start_of_month = date('Y-m-01'); // Start of this month

// Debug: Print values to verify
error_log("Today's Date: " . $today);
error_log("Start of Week: " . $start_of_week);
error_log("Start of Month: " . $start_of_month);

// Query to calculate total hours for today, this week, and this month for the logged-in user
$query_today = "
    SELECT 
        SUM(hours) AS total_hours_today 
    FROM log_hours 
    WHERE user_id = ? AND DATE(date) = CURDATE()
";

$query_week = "
    SELECT 
        SUM(hours) AS total_hours_week
    FROM log_hours 
    WHERE user_id = ? AND DATE(date) >= ? AND DATE(date) <= ?
";

$query_month = "
    SELECT 
        SUM(hours) AS total_hours_month
    FROM log_hours 
    WHERE user_id = ? AND DATE(date) >= ?
";

// Prepare the statements for today, week, and month
$stmt_today = $conn->prepare($query_today);
$stmt_today->bind_param("i", $user_id);
$stmt_today->execute();
$result_today = $stmt_today->get_result();
$total_hours_today = $result_today->fetch_assoc()['total_hours_today'] ?? 0;

// Debug: Check Today's Result
error_log("Total Hours Today: " . $total_hours_today);

// Prepare and execute the query for this week
$stmt_week = $conn->prepare($query_week);
$stmt_week->bind_param("iss", $user_id, $start_of_week, $today); // Get hours from start of the week to today
$stmt_week->execute();
$result_week = $stmt_week->get_result();
$total_hours_week = $result_week->fetch_assoc()['total_hours_week'] ?? 0;

// Debug: Check Week's Result
error_log("Total Hours Week: " . $total_hours_week);

// Prepare and execute the query for this month
$stmt_month = $conn->prepare($query_month);
$stmt_month->bind_param("is", $user_id, $start_of_month); // Get hours from the start of the month
$stmt_month->execute();
$result_month = $stmt_month->get_result();
$total_hours_month = $result_month->fetch_assoc()['total_hours_month'] ?? 0;

// Debug: Check Month's Result
error_log("Total Hours Month: " . $total_hours_month);

// Return the results as JSON
echo json_encode([
    'hours_today' => $total_hours_today,
    'hours_week' => $total_hours_week,
    'hours_month' => $total_hours_month
]);

// Close the database connection
$stmt_today->close();
$stmt_week->close();
$stmt_month->close();
$conn->close();
?>
