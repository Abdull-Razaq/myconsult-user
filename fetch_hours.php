<?php
include "config.php";
session_start();

if (!isset($_SESSION["user_id"])) {
    die("Unauthorized access.");
}

$user_id = $_SESSION["user_id"];
$sql = "SELECT id, hours, task_name, task_description, status, date FROM log_hours WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

header('Content-Type: application/json'); 
echo json_encode($data);
?>

