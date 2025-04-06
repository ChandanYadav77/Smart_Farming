<?php
session_start();
header('Content-Type: application/json');
include "db.php";

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (!$username || !$password) {
    echo json_encode(["error" => "Username and password are required"]);
    exit;
}

// Check if user already exists
$check_sql = "SELECT id FROM users WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo json_encode(["error" => "Username already exists"]);
    exit;
}

// Insert new user
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $hashed_password);

if ($stmt->execute()) {
    echo json_encode(["status" => "registered"]);
} else {
    echo json_encode(["error" => "Registration failed"]);
}
?>
