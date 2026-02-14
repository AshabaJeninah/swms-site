<?php
$host = "sql111.infinityfree.com";
$user = "if0_41147698"; 
$password = "swmssystem"; 
$database = "if0_41147698_swms_simple"; 
$port = 3306; 

$conn = @new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>