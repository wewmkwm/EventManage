<?php
include 'config.php';
session_start();
error_reporting(0);

// Check admin access
$login = $_SESSION['login'];
if (!$login) {
    header("Location: login.php"); // Redirect if not logged in
    exit;
}

// Fetch users with Role of 'User' or 'Company'
$usersSql = "
    SELECT UserID, Name, Email, DOB, Gender, Role
    FROM user
    WHERE Role = 'User' OR Role = 'Company'
";
$usersResult = mysqli_query($con, $usersSql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'header.html'; ?>
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#usersTable').DataTable();
    });
    </script>
</head>
<body>
    <?php include 'nav_admin.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link" id="v-pills-view-users-tab" href="admin_dashboard.php" role="tab"
                        aria-controls="v-pills-view-users" aria-selected="false">Dashboard</a>
                    <a class="nav-link" id="v-pills-pending-tab" href="event_pending.php" role="tab"
                        aria-controls="v-pills-pending" aria-selected="false">Pending Events</a>
                    <a class="nav-link" id="v-pills-approved-tab" href="event_approved.php" role="tab"
                        aria-controls="v-pills-approved" aria-selected="false">Approved Events</a>
                    <a class="nav-link" id="v-pills-ended-tab" href="event_ended.php" role="tab"
                        aria-controls="v-pills-ended" aria-selected="false">Ended Events</a>
                    <a class="nav-link active" id="v-pills-view-users-tab" href="admin_view_users.php" role="tab"
                        aria-controls="v-pills-view-users" aria-selected="true">View Users</a>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="card my-4">
                    <div class="card-header">View Users</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="usersTable" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($usersResult)) {
                                        echo '<tr>' .
                                            '<td>' . $row['UserID'] . '</td>' .
                                            '<td>' . $row['Name'] . '</td>' .
                                            '<td>' . $row['Email'] . '</td>' .
                                            '<td>' . $row['DOB'] . '</td>' .
                                            '<td>' . $row['Gender'] . '</td>' .
                                            '<td>' . $row['Role'] . '</td>' .
                                            '<td><a href="delete_user.php?UserID=' . $row['UserID'] . '" onclick="return confirm(\'Are you sure you want to delete this user?\');">Delete</a></td>' .
                                            '</tr>';
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
                                        <th>Role</th>
                                        <th>Actions</th>
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
</body>
</html>