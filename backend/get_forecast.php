<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Validate city input
if (!isset($_GET['city']) || empty($_GET['city'])) {
    echo json_encode(["error" => "City is required"]);
    exit;
}

$city = urlencode(trim($_GET['city']));
$apiKey = "5e3923421ade4a05aea111101250204"; // Replace with your valid key
$url = "http://api.weatherapi.com/v1/forecast.json?key=$apiKey&q=$city&days=7&aqi=no&alerts=no";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set timeout
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL for local testing

// ❌ Remove or Uncomment Proxy if needed
// curl_setopt($ch, CURLOPT_PROXY, '172.31.100.25:3128');
// curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'edcguest:edcguest');

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    echo json_encode(["error" => "cURL Error: " . $error_msg]);
    exit;
}

curl_close($ch);

// Handle API failure
$data = json_decode($response, true);
if ($http_code !== 200 || !isset($data['forecast']['forecastday'])) {
    echo json_encode(["error" => "Unable to fetch forecast"]);
    exit;
}

// Format forecast data (only required details)
$forecast = [];
foreach ($data['forecast']['forecastday'] as $day) {
    $forecast[] = [
        "date" => $day['date'],
        "max_temp" => $day['day']['maxtemp_c'],
        "min_temp" => $day['day']['mintemp_c'],
        "condition" => $day['day']['condition']['text'],
        "icon" => "https:" . $day['day']['condition']['icon'] // Ensure HTTPS
    ];
}

// Return JSON
echo json_encode(["forecast" => $forecast]);
?>
