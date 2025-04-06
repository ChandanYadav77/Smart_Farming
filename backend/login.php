<?php
session_start();
header('Content-Type: application/json');
include "db.php";

// Sanitize and retrieve POST data
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Username and password are required"]);
    exit();
}

// Prepare SQL to check for user
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500); // Internal Server Error
    echo json_encode(["error" => "Database error"]);
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Send success response with username
        echo json_encode([
            "status" => "success",
            "username" => $_SESSION['username']
        ]);
    } else {
        http_response_code(401); // Unauthorized
        echo json_encode(["error" => "Invalid password"]);
    }
} else {
    http_response_code(404); // Not Found
    echo json_encode(["error" => "User not found"]);
}
?>
