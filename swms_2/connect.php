<?php
$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "swms_simple"; 
$port = 3306; 

$conn = @new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>