<?php
include 'config.php';
session_start();
error_reporting(0);

$login = $_SESSION['login'];

// Fetch company events for the dropdown
$companyEventsSql = "SELECT EventID, EventName FROM event WHERE Organizer = (SELECT Name FROM user WHERE Email='$login')";
$companyEventsResult = mysqli_query($con, $companyEventsSql);

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
        $('#eventSelect').change(function() {
            var eventId = $(this).val();
            if (eventId) {
                $.ajax({
                    url: 'fetch_participants.php',
                    type: 'POST',
                    data: {eventId: eventId},
                    success: function(data) {
                        $('#participantTable tbody').html(data);
                        $('#participantTable').DataTable();
                    }
                });
            }
        });

        // Trigger change event to load participants for the first event by default
        $('#eventSelect').change();
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
                    <div class="card-header">Participant List</div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="eventSelect" style = "color:red"><strong>Select Event:</strong></label>
                            <select id="eventSelect" class="form-control">
                                <?php
                                while ($event = mysqli_fetch_assoc($companyEventsResult)) {
                                    echo '<option value="' . $event['EventID'] . '">' . $event['EventName'] . '</option>';
                                }
                                ?>
                            </select>
                        </div><br>
                        <div class="table-responsive">
                            <table id="participantTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Participant ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Participant details will be loaded here via AJAX -->
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Participant ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>DOB</th>
                                        <th>Gender</th>
                                    </tr>
                                </tfoot>
                            </table>
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
