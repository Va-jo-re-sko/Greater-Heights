<?php
$servername = "localhost";
$username = "Smart Curriculum"; // your MySQL username
$password = "Vajoresko2";     // your MySQL password
$dbname = "greater_heights";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
