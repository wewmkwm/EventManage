<?php
include 'config.php';
session_start();
error_reporting(0);

$login = $_SESSION['login'];

// Fetch approved events and participant count
$approvedEventsSql = "
    SELECT event.EventID, event.EventName, event.Date, event.Time, event.Duration, event.Description, event.Organizer, event.Status, COUNT(participant.EventID) as ParticipantCount
    FROM event
    LEFT JOIN participant ON event.EventID = participant.EventID
    WHERE event.Status = 'Ended' or event.Status = 'Rejected'
    GROUP BY event.EventID
";
$approvedEventsResult = mysqli_query($con, $approvedEventsSql);
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
        $('#approvedEventsTable').DataTable();
    });
    </script>
</head>
<body>
    <?php

    require_once('nav_admin.php');

?>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <h1 class="my-4"></h1>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" id="v-pills-view-users-tab" href="admin_dashboard.php" role="tab"
                        aria-controls="v-pills-view-users" aria-selected="false">Dashboard</a>
                    <a class="nav-link" id="v-pills-pending-tab" href="event_pending.php" role="tab"
                        aria-controls="v-pills-pending" aria-selected="false">Pending Events</a>
                    <a class="nav-link" id="v-pills-approved-tab" href="event_approved.php" role="tab"
                        aria-controls="v-pills-approved" aria-selected="true">Approved Events</a>
                    <a class="nav-link active" id="v-pills-ended-tab" href="event_ended.php" role="tab"
                        aria-controls="v-pills-ended" aria-selected="false">Ended Events</a>
                    <a class="nav-link" id="v-pills-view-users-tab" href="admin_view_users.php" role="tab"
                        aria-controls="v-pills-view-users" aria-selected="false">View Users</a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-approved" role="tabpanel"
                        aria-labelledby="v-pills-approved-tab">
                        <div class="card my-4">
                            <div class="card-header">Ended Events</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="approvedEventsTable" class="display" style="width:100%">
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
                                                <th>Participant Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($approvedEventsResult)) {
                                                echo '<tr>' .
                                                    '<td>' . $row['EventID'] . '</td>' .
                                                    '<td>' . $row['EventName'] . '</td>' .
                                                    '<td>' . $row['Date'] . '</td>' .
                                                    '<td>' . $row['Time'] . '</td>' .
                                                    '<td>' . $row['Duration'] . 'hr</td>' .
                                                    '<td>' . $row['Description'] . '</td>' .
                                                    '<td>' . $row['Organizer'] . '</td>' .
                                                    '<td>' . $row['Status'] . '</td>' .
                                                    '<td>' . $row['ParticipantCount'] . '</td>' .
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
                                                <th>Participant Count</th>
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
