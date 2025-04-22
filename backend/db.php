<?php
<<<<<<< HEAD
$host = "localhost";
$user = "root"; // change if your DB user is different
$pass = "";     // set your DB password
$dbname = "smart_farming"; // your database name

$conn = new mysqli($host, $user, $pass, $dbname);

// Check connection
=======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smart_farming";

$conn = new mysqli($servername, $username, $password, $dbname);

>>>>>>> a4c652a1321bf8df4c2c7e2632d90b56b21055c9
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
