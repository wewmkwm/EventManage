<?php
include 'config.php';
session_start();

// Check if UserID is set in the query string
if (isset($_GET['UserID'])) {
    $userID = $_GET['UserID'];

    // SQL statement to delete the user
    $deleteSql = "DELETE FROM user WHERE UserID = ?";

    // Prepare and bind statement to prevent SQL injection
    if ($stmt = mysqli_prepare($con, $deleteSql)) {
        mysqli_stmt_bind_param($stmt, "s", $userID);
        mysqli_stmt_execute($stmt);
        
        // Check if the deletion was successful
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo "<script>alert('User deleted successfully.'); window.location.href='admin_view_users.php';</script>";
        } else {
            echo "<script>alert('Error: Could not delete user.'); window.location.href='admin_view_users.php';</script>";
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Database error.'); window.location.href='admin_view_users.php';</script>";
    }
} else {
    echo "<script>alert('No user specified for deletion.'); window.location.href='admin_view_users.php';</script>";
}

// Close database connection
mysqli_close($con);
?>
