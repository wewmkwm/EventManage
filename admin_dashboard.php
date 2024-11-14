<?php
session_start();
include 'config.php';

// Check if user is logged in as admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Admin') {
    header("Location: login.php");
    exit;
}

// Fetch logs including failed login attempts
$logsSql = "SELECT u.Name, l.Action, l.Timestamp
            FROM user_logs l
            JOIN user u ON l.UserID = u.UserID
            ORDER BY l.Timestamp DESC
            LIMIT 100";
$logsResult = mysqli_query($con, $logsSql);

// Fetch the list of users and events they joined
$joinedEventsSql = "SELECT 
                        u.Name AS UserName, 
                        u.Email AS UserEmail, 
                        e.EventName, 
                        e.Date, 
                        e.Time, 
                        e.Description
                    FROM 
                        participant p
                    JOIN 
                        user u ON p.UserID = u.UserID
                    JOIN 
                        event e ON p.EventID = e.EventID";
$joinedEventsResult = mysqli_query($con, $joinedEventsSql);

// Fetch the list of companies and events they created
$companyEventsSql = "SELECT 
                        u.Name AS CompanyName, 
                        u.Email AS CompanyEmail, 
                        e.EventName, 
                        e.Date, 
                        e.Time, 
                        e.Description
                    FROM 
                        event e
                    JOIN 
                        user u ON e.Organizer = u.Name
                    WHERE 
                        u.Role = 'Company'";
$companyEventsResult = mysqli_query($con, $companyEventsSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.html'; ?>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <title>Admin Dashboard</title>
</head>
<body>
    <?php require_once('nav_admin.php'); ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <h1 class="my-4"></h1>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
                    <a class="nav-link" href="event_pending.php">Pending Events</a>
                    <a class="nav-link" href="event_approved.php">Approved Events</a>
                    <a class="nav-link" href="event_ended.php">Ended Events</a>
                    <a class="nav-link" href="admin_view_users.php">View Users</a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active">
                        <!-- Recent User Activity -->
                        <div class="card my-4">
                            <div class="card-header">Recent User Activity</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="logsTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Action</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($log = mysqli_fetch_assoc($logsResult)) {
                                                echo "<tr>
                                                        <td>{$log['Name']}</td>
                                                        <td>{$log['Action']}</td>
                                                        <td>{$log['Timestamp']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Action</th>
                                                <th>Timestamp</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Users Who Joined Events -->
                        <div class="card my-4">
                            <div class="card-header">Users Who Joined Events</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="joinedEventsTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Event Name</th>
                                                <th>Event Date</th>
                                                <th>Event Time</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($event = mysqli_fetch_assoc($joinedEventsResult)) {
                                                echo "<tr>
                                                        <td>{$event['UserName']}</td>
                                                        <td>{$event['UserEmail']}</td>
                                                        <td>{$event['EventName']}</td>
                                                        <td>{$event['Date']}</td>
                                                        <td>{$event['Time']}</td>
                                                        <td>{$event['Description']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Event Name</th>
                                                <th>Event Date</th>
                                                <th>Event Time</th>
                                                <th>Description</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Companies and Their Created Events -->
                        <div class="card my-4">
                            <div class="card-header">Companies and Their Created Events</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="companyEventsTable" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Company Name</th>
                                                <th>Company Email</th>
                                                <th>Event Name</th>
                                                <th>Event Date</th>
                                                <th>Event Time</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($companyEvent = mysqli_fetch_assoc($companyEventsResult)) {
                                                echo "<tr>
                                                        <td>{$companyEvent['CompanyName']}</td>
                                                        <td>{$companyEvent['CompanyEmail']}</td>
                                                        <td>{$companyEvent['EventName']}</td>
                                                        <td>{$companyEvent['Date']}</td>
                                                        <td>{$companyEvent['Time']}</td>
                                                        <td>{$companyEvent['Description']}</td>
                                                      </tr>";
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Company Name</th>
                                                <th>Company Email</th>
                                                <th>Event Name</th>
                                                <th>Event Date</th>
                                                <th>Event Time</th>
                                                <th>Description</th>
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
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
        $(document).ready(function() {
            $('#logsTable').DataTable();
            $('#joinedEventsTable').DataTable();
            $('#companyEventsTable').DataTable();
        });
    </script>
</body>
</html>
