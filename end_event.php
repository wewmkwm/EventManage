<?php
include 'config.php';

if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // Update the event status to 'Ended'
    $updateSql = "UPDATE event SET Status='Ended' WHERE EventID='$eventId'";
    if (mysqli_query($con, $updateSql)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
