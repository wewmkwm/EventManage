<?php
include 'config.php';
session_start();
error_reporting(0);

$login = $_SESSION['login'];
$success = false;

if (isset($_POST['add_event'])) {
    $eventName = $_POST['event_name'];
    $eventDescription = $_POST['event_description'];
    $eventDate = $_POST['event_date'];
    $eventTime = $_POST['event_time'] . ":00"; // Append ":00" to match the HH:MM:SS format
    $eventDuration = $_POST['event_duration'];

    // Fetch the organizer name using the session login email
    $organizerQuery = "SELECT Name FROM user WHERE Email='$login'";
    $organizerResult = mysqli_query($con, $organizerQuery);
    $organizerRow = mysqli_fetch_assoc($organizerResult);
    $organizerName = $organizerRow['Name'];

    $sql11 = "SELECT * FROM event";
    $result11 = mysqli_query($con, $sql11);
    $X =mysqli_num_rows($result11);
    $id= 'E'.sprintf("%'03d", $X+1);

    $addEventSql = "INSERT INTO `event`(`EventID`, `EventName`, `Date`, `Time`, `Duration`, `Description`, `Organizer`, `Status`) 
    VALUES ('$id','$eventName','$eventDate','$eventTime','$eventDuration','$eventDescription','$organizerName','Pending')";
    if (mysqli_query($con, $addEventSql)) {
        $success = true;
    } else {
        echo "<script>alert('Error adding event');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include 'header.html'; 
    ?>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
    $(document).ready(function() {
        <?php if ($success): ?>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Event Added! Please Click On Continue',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: '<a href="manage_event.php" style="text-decoration:none; color:white; ">Continue</a>',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        <?php endif; ?>
    });
    </script>
</head>
<body>
    <?php
    require_once('nav_company.php');
    ?>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card my-4">
                    <div class="card-header">Add New Event</div>
                    <div class="card-body">
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="event_name">Event Name</label>
                                <input type="text" class="form-control" id="event_name" name="event_name" required>
                            </div>
                            <div class="form-group">
                                <label for="event_description">Event Description</label>
                                <textarea class="form-control" id="event_description" name="event_description" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="event_date">Date</label>
                                <input type="date" class="form-control" id="event_date" name="event_date" required>
                            </div>
                            <div class="form-group">
                                <label for="event_time">Time</label>
                                <input type="time" class="form-control" id="event_time" name="event_time" required>
                            </div>
                            <div class="form-group">
                                <label for="event_duration">Duration (hours)</label>
                                <input type="number" class="form-control" id="event_duration" name="event_duration" required>
                            </div><br>
                            <button type="submit" name="add_event" class="btn btn-primary">Add Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        Copyright 2024 © Event Management System
    </footer>
    <!-- FontAwesome CDN for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
