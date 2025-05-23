<?php
<<<<<<< HEAD
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}
?>

<?php
=======
>>>>>>> a4c652a1321bf8df4c2c7e2632d90b56b21055c9
include 'db.php';

// Read raw POST JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Validate input
if (!isset($data['soil_type'], $data['temperature'], $data['humidity'])) {
    echo json_encode(["error" => "Missing parameters"]);
    exit;
}

$soil_type = $data['soil_type'];
$temp = $data['temperature'];
$humidity = $data['humidity'];

// Call Python script
$command = escapeshellcmd("python3 python/recommend.py'$soil_type' $temp $humidity");
$output = shell_exec($command);
$output = trim($output); // ✅ IMPORTANT

// Save to DB
$sql = "INSERT INTO crop_recommendations (soil_type, temperature, humidity, recommended_crops) 
        VALUES ('$soil_type', $temp, $humidity, '$output')";
$conn->query($sql);

// Send response
echo json_encode(["recommendation" => $output]);
?>
