<?php

//establish database connectivity
$server = "localhost";
$user = "root";
$pass = "";
$database = "event";

$con = mysqli_connect($server, $user, $pass, $database);

if (!$con) {
    die("<script>alert('Connection Failed.')</script>");
}

?>