<?php
include 'config.php';
session_start();
error_reporting(0);

if (!isset($_SESSION['login'])) {
    echo "You need to be logged in to join an event.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventId = $_POST['event_id'];
    $userEmail = $_POST['user_email'];

    // Fetch user ID from user email
    $userSql = "SELECT UserID FROM user WHERE Email='$userEmail'";
    $userResult = mysqli_query($con, $userSql);
    $userRow = mysqli_fetch_assoc($userResult);
    $userId = $userRow['UserID'];

    // Insert registration into participant table
    $insertSql = "INSERT INTO participant (EventID, UserID) VALUES ('$eventId', '$userId')";
    if (mysqli_query($con, $insertSql)) {
        echo "Successfully registered for the event!";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
