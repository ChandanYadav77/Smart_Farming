<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Ensure POST method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["reply" => "❌ Invalid request method."]);
    exit;
}

// Ensure Content-Type is application/json
$contentType = $_SERVER["CONTENT_TYPE"] ?? '';
if (stripos($contentType, 'application/json') === false) {
    echo json_encode(["reply" => "⚠️ Expected JSON input."]);
    exit;
}

// Parse JSON body
$input = json_decode(file_get_contents('php://input'), true);
$prompt = $input['message'] ?? '';

if (!$prompt) {
    echo json_encode(["reply" => "⚠️ Empty message."]);
    exit;
}

// Prepare payload for Ollama
$payload = json_encode([
    "model" => "tinyllama",
    "prompt" => $prompt,
    "stream" => false
]);

$options = [
    "http" => [
        "method"  => "POST",
        "header"  => "Content-Type: application/json",
        "content" => $payload
    ]
];

// Send request to LLaMA/Ollama API
$context = stream_context_create($options);
$result = file_get_contents("http://localhost:11434/api/generate", false, $context);

// Handle response
if ($result === false) {
    echo json_encode(["reply" => "⚠️ Failed to connect to LLaMA server."]);
    exit;
}

$responseData = json_decode($result, true);
$botReply = $responseData["response"] ?? "⚠️ No reply from LLaMA";

echo json_encode(["reply" => $botReply]);
