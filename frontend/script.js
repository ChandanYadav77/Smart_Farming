// // ✅ Set API Base URL (Change 'localhost' to your server IP if needed)
// const BASE_URL = "http://localhost/smart_farming/backend"; // If remote, use "http://your-server-ip/backend"

// // 🌾 Recommend Crops Function (Global Scope for onclick)
// function recommendCrops() {
//     const city = getInputValue("cityInput");
//     const soilType = getInputValue("soilTypeInput") || "loamy";

//     if (!city || !soilType) {
//         showToast("Please enter both city and soil type!", "error");
//         return;
//     }

//     showToast(`Fetching weather for ${city}...`, "info");

//     fetchData(`${BASE_URL}/get_weather.php?city=${encodeURIComponent(city)}`)
//         .then(data => {
//             if (data.error) {
//                 showToast("❌ Weather API Error: " + data.error, "error");
//                 return;
//             }

//             updateWeatherUI(data);
//             fetch7DayForecast(city);
//             return fetchData(`${BASE_URL}/recommend_crops.php`, "POST", {
//                 soil_type: soilType,
//                 temperature: data.temperature,
//                 humidity: data.humidity
//             });
//         })
//         .then(response => {
//             if (!response) return;
//             updateCropUI(response.recommendation);
//         })
//         .catch(err => handleError("weather/crop recommendation", err));
// }

// // 🌦️ Fetch & Display 7-Day Forecast
// function fetch7DayForecast(city) {
//     fetchData(`${BASE_URL}/get_forecast.php?city=${encodeURIComponent(city)}`)
//         .then(data => {
//             if (data.error) {
//                 showToast("⚠️ Error fetching forecast: " + data.error, "error");
//                 return;
//             }
//             updateForecastUI(data.forecast);
//         })
//         .catch(err => handleError("7-day forecast", err));
// }

// // 📅 Update 7-Day Forecast UI
// function updateForecastUI(forecast) {
//     const forecastList = document.getElementById("forecastList");
//     forecastList.innerHTML = "";

//     if (!forecast || forecast.length === 0) {
//         forecastList.innerHTML = "<li>⚠️ No forecast data available.</li>";
//         return;
//     }

//     forecast.forEach(day => {
//         const { date, condition, temp, icon } = day;
//         forecastList.innerHTML += `
//             <li>
//                 <strong>${date}</strong> - ${condition} <br/>
//                 🌡️ ${temp}°C <br/>
//                 <img src="${icon}" alt="${condition}" style="width: 40px; height: 40px;">
//             </li>`;
//     });

//     toggleVisibility("forecastList", true);
// }

// // 🤖 Chatbot Function (Global Scope for onclick)
// function sendMessage() {
//     const input = getInputValue("chatInput");
//     if (!input) return;

//     updateChatBox("You", input);
//     const botMsg = addTypingPlaceholder();

//     fetchData(`${BASE_URL}/chatbot.php`, "POST", { message: input })
//         .then(data => {
//             const reply = data.reply || "⚠️ No response from bot";
//             botMsg.innerHTML = `<strong>Bot:</strong> ${reply}`;
//         })
//         .catch(err => {
//             console.error("🤖 Chatbot error:", err);
//             botMsg.innerHTML = `<strong>Bot:</strong> ⚠️ Error talking to bot.`;
//         });
// }

// // 🌤️ Update Weather UI
// function updateWeatherUI(data) {
//     setText("temperature", `${data.temperature}°C`);
//     setText("humidity", `${data.humidity}%`);
//     setText("windSpeed", `${data.wind_kph} km/h`);
//     setText("precipitation", `${data.precipitation} mm`);
//     toggleVisibility("weatherResult", true);
// }

// // 🌾 Update Crop UI
// function updateCropUI(recommendation) {
//     const crops = parseCropList(recommendation);
//     if (!crops.length) {
//         showToast("⚠️ No crops returned. Try again.", "warn");
//         return;
//     }

//     renderList("cropList", crops, crop => `<strong>${crop}</strong><br/>Reason: Suitable for current conditions<br/>Estimated Yield: High`);
//     toggleVisibility("cropSection", true);
//     scrollToSection("cropSection");
//     showToast("✅ Crops loaded successfully!", "success");
// }

// // 🚀 Utility: Fetch Data
// function fetchData(url, method = "GET", body = null) {
//     const options = { method, headers: { "Content-Type": "application/json" } };
//     if (body) options.body = JSON.stringify(body);
//     return fetch(url, options).then(res => res.json());
// }

// // 🌿 Utility: Parse Crop List
// function parseCropList(text) {
//     return (text || "").replace(/\n/g, "").split(",").map(c => c.trim()).filter(c => c.length > 0);
// }

// // ✍️ Utility: Update Text Content
// function setText(id, value) {
//     document.getElementById(id).innerText = value;
// }

// // 👀 Utility: Show/Hide Elements
// function toggleVisibility(id, show) {
//     document.getElementById(id).classList.toggle("hidden", !show);
// }

// // 📝 Utility: Get Input Value
// function getInputValue(id) {
//     return document.getElementById(id).value.trim();
// }

// // 💬 Utility: Update Chat Box
// function updateChatBox(sender, message) {
//     document.getElementById("chatBox").innerHTML += `<p><strong>${sender}:</strong> ${message}</p>`;
// }

// // ⏳ Utility: Add "Typing..." Placeholder
// function addTypingPlaceholder() {
//     const box = document.getElementById("chatBox");
//     const botMsg = document.createElement("p");
//     botMsg.innerHTML = `<strong>Bot:</strong> <em>typing...</em>`;
//     box.appendChild(botMsg);
//     box.scrollTop = box.scrollHeight;
//     return botMsg;
// }

// // 📜 Utility: Render List Items
// function renderList(id, items, template) {
//     const list = document.getElementById(id);
//     list.innerHTML = items.map(item => `<li>${template(item)}</li>`).join("");
// }

// // ✅ Custom Toast Notifications
// function showToast(message, type = "info") {
//     const toast = document.createElement("div");
//     toast.className = `toast toast-${type}`;
//     toast.innerText = message;

//     document.body.appendChild(toast);
//     setTimeout(() => toast.classList.add("show"), 10);
//     setTimeout(() => {
//         toast.classList.remove("show");
//         setTimeout(() => toast.remove(), 300);
//     }, 3000);
// }

// // 🔥 Error Handling
// function handleError(context, err) {
//     console.error(`🚨 Error fetching ${context}:`, err);
//     showToast(`Error in ${context}`, "error");
// }

// // 📜 Utility: Scroll to Section
// function scrollToSection(id) {
//     const el = document.getElementById(id);
//     if (el) el.scrollIntoView({ behavior: "smooth" });
// }

// // 🔗 Final Attachments on Load
// document.addEventListener("DOMContentLoaded", () => {
//     console.log("✅ Smart Farming script loaded successfully.");
//     // You can also auto-load weather for a default city here if needed
// });

// ✅ Correct BASE URL for your project structure
const BASE_URL = "http://localhost/smart_farming/backend";

// 🌾 Recommend Crops Function
function recommendCrops() {
    const city = getInputValue("cityInput");
    const soilType = getInputValue("soilTypeInput") || "loamy";

    if (!city || !soilType) {
        showToast("Please enter both city and soil type!", "error");
        return;
    }

    showToast(`Fetching weather for ${city}...`, "info");

    fetchData(`${BASE_URL}/get_weather.php?city=${encodeURIComponent(city)}`)
        .then(data => {
            if (!data || data.error) {
                showToast("❌ Weather API Error: " + (data?.error || "Invalid response"), "error");
                return;
            }

            updateWeatherUI(data);
            fetch7DayForecast(city);

            // ✅ If crops are already present in weather response, use them
            if (data.crops && Array.isArray(data.crops)) {
                updateCropUI(data.crops.join(", "));
            }
            // Optional: else fallback to POSTing to recommend_crops.php
            else {
                return fetchData(`${BASE_URL}/recommend_crops.php`, "POST", {
                    soil_type: soilType,
                    temperature: data.temperature,
                    humidity: data.humidity
                }).then(response => {
                    if (response) updateCropUI(response.recommendation);
                });
            }
        })
        .catch(err => handleError("weather/crop recommendation", err));
}


// 🌦️ Fetch & Display 7-Day Forecast
function fetch7DayForecast(city) {
    fetchData(`${BASE_URL}/get_forecast.php?city=${encodeURIComponent(city)}`)
        .then(data => {
            if (!data || data.error) {
                showToast("⚠️ Error fetching forecast: " + (data?.error || "Invalid response"), "error");
                return;
            }
            updateForecastUI(data.forecast);
        })
        .catch(err => handleError("7-day forecast", err));
}

// 📅 Update 7-Day Forecast UI
function updateForecastUI(forecast) {
    const forecastList = document.getElementById("forecastList");
    forecastList.innerHTML = "";

    if (!forecast || forecast.length === 0) {
        forecastList.innerHTML = "<li>⚠️ No forecast data available.</li>";
        return;
    }

    forecast.forEach(day => {
        const { date, condition, max_temp, icon } = day;
        forecastList.innerHTML += `
            <li>
                <strong>${date}</strong> - ${condition} <br/>
                🌡️ ${max_temp}°C <br/>
                <img src="${icon}" alt="${condition}" style="width: 40px; height: 40px;">
            </li>`;
    });

    toggleVisibility("forecastList", true);
}

// 🤖 Chatbot Function
function sendMessage() {
    const input = getInputValue("chatInput");
    if (!input) return;

    updateChatBox("You", input);
    const botMsg = addTypingPlaceholder();

    fetchData(`${BASE_URL}/chatbot.php`, "POST", { message: input })
        .then(data => {
            const reply = data?.reply || "⚠️ No response from bot";
            botMsg.innerHTML = `<strong>Bot:</strong> ${reply}`;
        })
        .catch(err => {
            console.error("🤖 Chatbot error:", err);
            botMsg.innerHTML = `<strong>Bot:</strong> ⚠️ Error talking to bot.`;
        });
}

// 🌤️ Update Weather UI
function updateWeatherUI(data) {
    setText("temperature", `${data.temperature}°C`);
    setText("humidity", `${data.humidity}%`);
    setText("windSpeed", `${data.windSpeed} km/h`);
    setText("precipitation", `${data.precipitation} mm`);
    toggleVisibility("weatherResult", true);
}

// 🌾 Update Crop UI
function updateCropUI(recommendation) {
    const crops = parseCropList(recommendation);
    if (!crops.length) {
        showToast("⚠️ No crops returned. Try again.", "warn");
        return;
    }

    renderList("cropList", crops, crop => `<strong>${crop}</strong><br/>Reason: Suitable for current conditions<br/>Estimated Yield: High`);
    toggleVisibility("cropSection", true);
    scrollToSection("cropSection");
    showToast("✅ Crops loaded successfully!", "success");
}

// 🚀 Utility: Fetch Data with safe JSON handling
function fetchData(url, method = "GET", body = null) {
    const options = { method, headers: { "Content-Type": "application/json" } };
    if (body) options.body = JSON.stringify(body);

    return fetch(url, options)
        .then(async res => {
            const contentType = res.headers.get("Content-Type") || "";
            if (!res.ok) {
                throw new Error(`HTTP ${res.status}: ${res.statusText}`);
            }
            if (contentType.includes("application/json")) {
                return res.json();
            } else {
                const text = await res.text();
                console.warn("Expected JSON, but got:", text);
                throw new Error("Response is not valid JSON");
            }
        });
}

// 🌿 Utility: Parse Crop List
function parseCropList(text) {
    return (text || "").replace(/\n/g, "").split(",").map(c => c.trim()).filter(c => c.length > 0);
}

// ✍️ Utility: Update Text Content
function setText(id, value) {
    document.getElementById(id).innerText = value;
}

// 👀 Utility: Show/Hide Elements
function toggleVisibility(id, show) {
    document.getElementById(id).classList.toggle("hidden", !show);
}

// 📝 Utility: Get Input Value
function getInputValue(id) {
    return document.getElementById(id).value.trim();
}

// 💬 Utility: Update Chat Box
function updateChatBox(sender, message) {
    document.getElementById("chatBox").innerHTML += `<p><strong>${sender}:</strong> ${message}</p>`;
}

// ⏳ Utility: Add "Typing..." Placeholder
function addTypingPlaceholder() {
    const box = document.getElementById("chatBox");
    const botMsg = document.createElement("p");
    botMsg.innerHTML = `<strong>Bot:</strong> <em>typing...</em>`;
    box.appendChild(botMsg);
    box.scrollTop = box.scrollHeight;
    return botMsg;
}

// 📜 Utility: Render List Items
function renderList(id, items, template) {
    const list = document.getElementById(id);
    list.innerHTML = items.map(item => `<li>${template(item)}</li>`).join("");
}

// ✅ Custom Toast Notifications
function showToast(message, type = "info") {
    const toast = document.createElement("div");
    toast.className = `toast toast-${type}`;
    toast.innerText = message;

    document.body.appendChild(toast);
    setTimeout(() => toast.classList.add("show"), 10);
    setTimeout(() => {
        toast.classList.remove("show");
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// 🔥 Error Handling
function handleError(context, err) {
    console.error(`🚨 Error fetching ${context}:`, err);
    showToast(`Error in ${context}: ${err.message || err}`, "error");
}

// 📜 Scroll to Section
function scrollToSection(id) {
    const el = document.getElementById(id);
    if (el) el.scrollIntoView({ behavior: "smooth" });
}

// 🔗 Initialize
document.addEventListener("DOMContentLoaded", () => {
    console.log("✅ Smart Farming script initialized.");
});
