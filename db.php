<?php
$host = "localhost";
$user = "root";
$pass = ""; // Weka password yako kama ipo
$dbname = "hardware_db";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>