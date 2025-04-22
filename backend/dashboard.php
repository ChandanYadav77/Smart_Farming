<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.html");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Smart Farming Assistant</title>
  <link rel="stylesheet" href="../frontend/styles.css" />
  <style>
    body {
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      color: #fff;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 0;
    }

    .login-status {
      padding: 10px;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      text-align: right;
    }

    .container {
      max-width: 900px;
      margin: 2rem auto;
      background: rgba(255, 255, 255, 0.05);
      backdrop-filter: blur(20px);
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
    }

    .section {
      margin-bottom: 2rem;
    }

    h1, h2 {
      text-align: center;
    }

    input, select, button {
      display: block;
      width: 100%;
      margin: 0.5rem 0;
      padding: 0.7rem;
      font-size: 1rem;
      border-radius: 10px;
      border: none;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    button {
      cursor: pointer;
      background: #00c9ff;
      color: #000;
      transition: 0.3s;
    }

    button:hover {
      background: #92fe9d;
    }

    ul {
      list-style-type: none;
      padding: 0;
    }

    .forecast-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
      gap: 1rem;
    }

    #chatBox {
      margin-top: 1rem;
      padding: 1rem;
      background: rgba(0, 0, 0, 0.3);
      border-radius: 10px;
      max-height: 200px;
      overflow-y: auto;
    }

    .hidden {
      display: none;
    }

    a {
      color: #00e0ff;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- 🔐 Login Status -->
<div id="loginStatus" class="login-status">
$username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest';
?>
Logged in as: <strong><?php echo $username; ?></strong> |
  <a href="logout.php">Logout</a>
</div>

<div class="container">
  <h1>Smart Farming Assistant 🌾</h1>

  <!-- 🔼 TOP SECTION: Weather & Forecast -->
  <div class="section">
    <h2>🌤️ Weather Information</h2>
    <input type="text" id="cityInput" placeholder="Enter City Name" />

    <!-- ✅ Soil Type Selector -->
    <select id="soilTypeInput">
      <option value="">-- Select Soil Type --</option>
      <option value="sandy">Sandy</option>
      <option value="clay">Clay</option>
      <option value="loamy">Loamy</option>
    </select>

    <button onclick="recommendCrops()">Get Weather & Crop Suggestions</button>

    <div id="weatherResult" class="hidden">
      <p><strong>Temperature:</strong> <span id="temperature"></span></p>
      <p><strong>Humidity:</strong> <span id="humidity"></span></p>
      <p><strong>Wind Speed:</strong> <span id="windSpeed"></span></p>
      <p><strong>Precipitation:</strong> <span id="precipitation"></span></p>

      <h3>📆 3-Day Forecast</h3>
      <ul id="forecastList" class="forecast-grid">
        <li>Loading forecast...</li>
      </ul>
    </div>
  </div>

  <!-- 🟨 MIDDLE SECTION: Crop Suggestions -->
  <div class="section hidden" id="cropSection">
    <h2>🌱 Crop Suggestions</h2>
    <ul id="cropList"></ul>
  </div>

  <!-- 🔽 BOTTOM SECTION: Tips -->
  <div class="section" id="tipsSection">
    <h2>🌾 Best Practices</h2>
    <ul>
      <li>Ensure timely irrigation for optimal yield.</li>
      <li>Use organic fertilizers when possible.</li>
      <li>Rotate crops to maintain soil health.</li>
      <li>Monitor for pests and apply control measures early.</li>
    </ul>
  </div>
</div>

<!-- 🤖 Chatbot Section -->
<div class="container section" id="chatSection">
  <h2>🤖 Ask the Farming Assistant</h2>
  <input type="text" id="chatInput" placeholder="Ask a farming question..." />
  <button onclick="sendMessage()">Send</button>
  <div id="chatBox"></div>
</div>

<script src="../frontend/script.js"></script>
</body>
</html>