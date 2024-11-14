<?php
include 'config.php';
session_start();

if (isset($_POST['id']) && isset($_POST['status'])) {
    $eventId = $_POST['id'];
    $status = $_POST['status'];

    $updateSql = "UPDATE event SET Status='$status' WHERE EventID='$eventId'";
    if (mysqli_query($con, $updateSql)) {
        echo "Success";
    } else {
        echo "Error";
    }
}
?>
