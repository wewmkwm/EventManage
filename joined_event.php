<?php
include 'config.php';
session_start();
error_reporting(0);

$login = $_SESSION['login'];

// Fetch user details from the database
$userSql = "SELECT * FROM user WHERE Email='$login'";
$userResult = mysqli_query($con, $userSql);
$userRow = mysqli_fetch_assoc($userResult);

// Fetch joined events
$joinedEventsSql = "
    SELECT event.EventID, event.EventName, event.Date, event.Time, event.Duration, event.Description, event.Organizer, event.Status
    FROM event
    JOIN participant ON event.EventID = participant.EventID
    WHERE participant.UserID = (SELECT UserID FROM user WHERE Email='$login')
";
$joinedEventsResult = mysqli_query($con, $joinedEventsSql);
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
    <script>
    $(document).ready(function() {
        $('#joinedEventsTable').DataTable();

        // Check for success parameter in the URL
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success')) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Profile Updated! Please Click On Continue',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: '<a href="profile.php" style="text-decoration:none; color:white;">Continue</a>',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
            });
        }
    });
    </script>
</head>
<body>
    <?php
if (isset($login)) {
    require_once('nav_login.php');
} else {
    require_once('nav.php');
}
?>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <h1 class="my-4"></h1>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" id="v-pills-profile-tab" href="profile.php" role="tab"
                        aria-controls="v-pills-profile" aria-selected="false">Profile</a>
                    <a class="nav-link active" id="v-pills-joined-tab" href="joined_event.php" role="tab"
                        aria-controls="v-pills-joined" aria-selected="true">Joined events</a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-joined" role="tabpanel"
                        aria-labelledby="v-pills-joined-tab">
                        <div class="card my-4">
                            <div class="card-header">Joined Events</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="joinedEventsTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Event Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Duration</th>
                                                <th>Description</th>
                                                <th>Organizer</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($joinedEventsResult)) {
                                                echo '<tr>' .
                                                    '<td>' . $row['EventID'] . '</td>' .
                                                    '<td>' . $row['EventName'] . '</td>' .
                                                    '<td>' . $row['Date'] . '</td>' .
                                                    '<td>' . $row['Time'] . '</td>' .
                                                    '<td>' . $row['Duration'] . 'hr</td>' .
                                                    '<td>' . $row['Description'] . '</td>' .
                                                    '<td>' . $row['Organizer'] . '</td>' .
                                                    '<td>' . $row['Status'] . '</td>' .
                                                    '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Event ID</th>
                                                <th>Event Name</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Duration</th>
                                                <th>Description</th>
                                                <th>Organizer</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
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
