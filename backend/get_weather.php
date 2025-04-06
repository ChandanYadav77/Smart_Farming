 <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

if (!isset($_GET['city'])) {
    die(json_encode(["error" => "City not provided"]));
}

if (!isset($_GET['city']) || empty($_GET['city'])) {
    die(json_encode(["error" => "City parameter is missing or empty."]));
}

$city = urlencode(trim($_GET['city']));


$apiKey = "5e3923421ade4a05aea111101250204"; // Replace with your valid API key
$url = "https://api.weatherapi.com/v1/current.json?key=" . $apiKey . "&q=" . $city . "&aqi=no";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// ✅ Set your proxy
curl_setopt($ch, CURLOPT_PROXY, '172.31.100.25:3128');

// ✅ Set proxy authentication
curl_setopt($ch, CURLOPT_PROXYUSERPWD, 'edcguest:edcguest');

// Optional: disable SSL verification for local testing
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

$response = curl_exec($ch);

// Check for cURL error
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    curl_close($ch);
    die(json_encode(["error" => "cURL error: " . $error_msg]));
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code !== 200) {
    die(json_encode(["error" => "Failed to fetch weather data, HTTP Code: " . $http_code]));
}

$data = json_decode($response, true);
if (!isset($data['current'])) {
    die(json_encode(["error" => "Invalid API response"]));
}

$temperature = $data['current']['temp_c'];
$humidity = $data['current']['humidity'];
$weather = $data['current']['condition']['text'];
$windSpeed = $data['current']['wind_kph'];
$precipitation = $data['current']['precip_mm'];


function getRecommendedCrops($temperature) {
    if ($temperature > 30) {
        return ["Maize", "Sorghum", "Cotton"];
    } elseif ($temperature > 20) {
        return ["Wheat", "Barley", "Peas"];
    } else {
        return ["Potatoes", "Carrots", "Cabbage"];
    }
}

// function getRecommendedCrops($temperature, $soil_type) {
//     $soil_type = strtolower($soil_type);

//     if ($soil_type == "clay") {
//         if ($temperature < 20) {
//             return ["Wheat", "Mustard", "Barley"];
//         } elseif ($temperature <= 30) {
//             return ["Paddy", "Lentils", "Chickpea"];
//         } else {
//             return ["Sugarcane", "Cotton", "Jowar"];
//         }
//     } elseif ($soil_type == "sandy") {
//         if ($temperature < 20) {
//             return ["Barley", "Oats"];
//         } elseif ($temperature <= 30) {
//             return ["Groundnut", "Moong", "Sesame"];
//         } else {
//             return ["Watermelon", "Cucumber", "Millets"];
//         }
//     } elseif ($soil_type == "loamy") {
//         if ($temperature < 20) {
//             return ["Peas", "Cauliflower", "Spinach"];
//         } elseif ($temperature <= 30) {
//             return ["Maize", "Soybean", "Tomato"];
//         } else {
//             return ["Cotton", "Sunflower", "Bajra"];
//         }
//     } else {
//         return ["Invalid soil type. Use: loamy, sandy, or clay."];
//     }
// }



$crops = getRecommendedCrops($temperature);

echo json_encode([
    "temperature" => $temperature,
    "humidity" => $humidity,
    "weather" => $weather,
    "crops" => $crops,
    "windSpeed"=>$windSpeed,
    "precipitation"=>$precipitation
]);
?> 
