<?php
$servername = "localhost:3306";
$username = "dtfj_pg6";
$password = "mobiledev";
$database = "dtfj_pg6";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
//    else { echo "Connected successfully"; }
?>