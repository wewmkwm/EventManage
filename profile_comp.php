<?php
include 'config.php';
session_start();
error_reporting(0);

$login = $_SESSION['login'];

// Fetch user details from the database
$userSql = "SELECT * FROM user WHERE Email='$login'";
$userResult = mysqli_query($con, $userSql);
$userRow = mysqli_fetch_assoc($userResult);

// Handle form submission to update user details
if (isset($_POST['update'])) {
    $pass = $_POST['pass'];

    $updateSql = "UPDATE user SET Password='$pass' WHERE Email='$login'";
    if (mysqli_query($con, $updateSql)) {
        header("Location: profile_comp.php?success=true");
        exit;
    } else {
        echo "<script>alert('Error updating profile');</script>";
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#editButton').click(function() {
                $('.profile-view').toggle();
                $('.profile-edit').toggle();
            });

            // Check for success parameter in the URL
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Profile Updated! Please Click On Continue',
                    showDenyButton: false,
                    showCancelButton: true,
                    confirmButtonText: '<a href="profile_comp.php" style="text-decoration:none; color:white;">Continue</a>',
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
    require_once('nav_company.php');
} else {
    require_once('nav.php');
}
?>
    <!-- Page Content -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-model" role="tabpanel"
                        aria-labelledby="v-pills-model-tab">
                        <div class="card my-4">
                            <div class="card-header">Profile</div>
                            <div class="card-body">
                                <button id="editButton" class="btn btn-primary edit-btn">Edit Profile</button>
                                <div class="profile-container profile-view">
                                    <div class="profile-section">
                                        <div class="profile-info">
                                            <i class="profile-icon fas fa-user"></i>
                                            <div>
                                                <h4><strong>Company Name:</strong></h4>
                                                <p style = "color:blue" ><?php echo $userRow['Name']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-section">
                                        <div class="profile-info">
                                            <i class="profile-icon fas fa-envelope"></i>
                                            <div>
                                                <h4><strong>Company Email:</strong></h4>
                                                <p style = "color:blue"><?php echo $userRow['Email']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-section">
                                        <div class="profile-info">
                                            <i class="profile-icon fas fa-envelope"></i>
                                            <div>
                                                <h4><strong>Password:</strong></h4>
                                                <p style = "color:blue"><?php echo $userRow['Password']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form method="POST" class="profile-container profile-edit profile-form" style="display:none;">
                                    <div class="profile-section">
                                        <div class="profile-info">
                                            <i class="profile-icon fas fa-user"></i>
                                            <div>
                                                <h4><strong>Company Name:</strong></h4>
                                                <input type="text" name="name" value="<?php echo $userRow['Name']; ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-section">
                                        <div class="profile-info">
                                            <i class="profile-icon fas fa-envelope"></i>
                                            <div>
                                                <h4><strong>Company Email:</strong></h4>
                                                <input type="email" name="email" value="<?php echo $userRow['Email']; ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="profile-section">
                                        <div class="profile-info">
                                            <i class="profile-icon fas fa-envelope"></i>
                                            <div>
                                                <h4><strong>Password:</strong></h4>
                                                <input type="text" name="pass" value="<?php echo $userRow['Password']; ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="button">
                                        <button type="submit" name="update" class="btn btn-success">Save Changes</button>
                                        <button type="button" id="editButton" class="btn btn-secondary">Cancel</button>
                                    </div>
                                </form>
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
