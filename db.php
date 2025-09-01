<?php
$host = '127.0.0.1';   // use IP to avoid socket weirdness
$user = 'root';
$pass = 'root';
$db   = 'mydb';
$port = 8889;

$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
  die('DB connect failed: (' . $conn->connect_errno . ') ' . $conn->connect_error);
}
$conn->set_charset('utf8mb4');
