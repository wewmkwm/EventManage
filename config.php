<?php
// Database configuration
$server = "localhost";
$user = "root";
$pass = "";
$database = "event";

// Establishing connection
$con = mysqli_connect($server, $user, $pass, $database);

// Check connection
if (!$con) {
    die("<script>alert('Connection Failed.')</script>");
}
?>
