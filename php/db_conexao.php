<?php
$servername = "172.190.234.148";
$username = "root";
$password = "";
$dbname = "sweethome";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
?>