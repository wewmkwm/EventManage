<?php
include 'config.php';
session_start();
error_reporting(0);

$login = $_SESSION['login'];

// Fetch all events organized by the company
$approvedEventsSql = "
    SELECT event.EventID, event.EventName, event.Date, event.Time, event.Duration, event.Description, event.Organizer, event.Status, COUNT(participant.EventID) as ParticipantCount
    FROM event
    LEFT JOIN participant ON event.EventID = participant.EventID
    WHERE event.Organizer = (SELECT Name FROM user WHERE Email='$login')
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

        // Handle "Event Ended" button click
        $(document).on('click', '.end-event-btn', function() {
            var eventId = $(this).data('id');
            $.ajax({
                url: 'end_event.php',
                type: 'POST',
                data: { eventId: eventId },
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Event status updated to Ended!',
                            showCancelButton: true,
                            confirmButtonText: '<a href="manage_event.php" style="text-decoration:none; color:white;">Continue</a>',
                            showClass: {
                                popup: 'animate__animated animate__fadeInDown'
                            },
                            hideClass: {
                                popup: 'animate__animated animate__fadeOutUp'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to update event status. Please try again.'
                        });
                    }
                }
            });
        });
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
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-approved" role="tabpanel"
                        aria-labelledby="v-pills-approved-tab">
                        <div class="card my-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <span>My Events</span>
                                <button class="btn btn-success" onclick="window.location.href='add_event.php'">Add Event</button>
                            </div>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($row = mysqli_fetch_assoc($approvedEventsResult)) {
                                                $endButton = $row['Status'] === 'On-Going' ? 
                                                    '<button class="btn btn-danger end-event-btn" data-id="' . $row['EventID'] . '">Event Ended</button>' :
                                                    '';
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
                                                    '<td>' . $endButton . '</td>' .
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
                                                <th>Action</th>
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
