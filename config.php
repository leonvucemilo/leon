<?php
$servername = "localhost";
$dbname = "leon_api";
$username = "root";
$password = "";
$secret_code = "top-secret-code";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>