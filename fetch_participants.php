<?php
include 'config.php';

if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];

    // Fetch participants for the selected event
    $participantsSql = "
        SELECT user.UserID, user.Name, user.Email, user.DOB, user.Gender
        FROM participant
        JOIN user ON participant.UserID = user.UserID
        WHERE participant.EventID = '$eventId'
    ";
    $participantsResult = mysqli_query($con, $participantsSql);

    while ($participant = mysqli_fetch_assoc($participantsResult)) {
        echo '<tr>' .
             '<td>' . $participant['UserID'] . '</td>' .
             '<td>' . $participant['Name'] . '</td>' .
             '<td>' . $participant['Email'] . '</td>' .
             '<td>' . $participant['DOB'] . '</td>' .
             '<td>' . $participant['Gender'] . '</td>' .
             '</tr>';
    }
}
?>
