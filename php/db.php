<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wifi_subscription";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
