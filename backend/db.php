<?php
$host = "localhost";
$user = "root"; // change if your DB user is different
$pass = "";     // set your DB password
$dbname = "smart_farming"; // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
