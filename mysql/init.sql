CREATE DATABASE smart_farming;

USE smart_farming;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255)
);

CREATE TABLE weather_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location VARCHAR(100),
    temperature FLOAT,
    humidity FLOAT,
    weather_condition VARCHAR(100),
    timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
