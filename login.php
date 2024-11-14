<?php
session_start();
include 'config.php';  // Ensure the connection file is correct and includes database details.

if (isset($_POST['submit'])) {
    // Capture user input
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL query to securely fetch hashed password and user role
    $stmt = $con->prepare("SELECT UserID, Password, Role FROM user WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    // Verify password if email exists
    if ($row && password_verify($password, $row['Password'])) {
        // Set session variables
        $_SESSION['login'] = $email;
        $_SESSION['role'] = $row['Role'];

        // Log successful login attempt
        $logSql = "INSERT INTO user_logs (UserID, Action) VALUES (?, 'Logged in')";
        $logStmt = $con->prepare($logSql);
        $logStmt->bind_param("s", $row['UserID']);
        $logStmt->execute();

        // Redirect based on role
        switch ($row['Role']) {
            case 'User':
                header("Location: index.php");
                break;
            case 'Company':
                header("Location: manage_event.php");
                break;
            case 'Admin':
                header("Location: event_pending.php");
                break;
            default:
                // In case of unexpected role
                echo "Invalid role!";
                exit;
        }
        exit;  // Prevent further execution after redirect
    } else {
        // Log failed login attempt with no specific user ID
        $logSql = "INSERT INTO user_logs (UserID, Action) VALUES ('Unknown', 'Failed login attempt')";
        $logStmt = $con->prepare($logSql);
        $logStmt->execute();

        // Display error popup
        echo "<script>pop_up()</script>";
    }

    // Close statements
    $stmt->close();
    $logStmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="login_and_register.css?v=<?php echo time(); ?>" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.all.min.js"></script>
    <title>Event Management</title>
    <style>
        body {
            background: #f0f0f0;
        }
    </style>
    <script>
        function pop_up() {
            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: 'You have entered the wrong email or password.',
                showCancelButton: true,
                confirmButtonText: 'Retry again'
            });
        }
    </script>
</head>
<body>
    <div class="form_container">
        <form action="" method="POST" class="login">
            <p class="login_word" style="font-size: 2rem; font-weight: 100;">Login</p>
            <div class="input-field">
                <input type="email" placeholder="Email Address" name="email" required>
            </div>
            <div class="input-field">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-field">
                <button name="submit" class="btn">Login</button>
            </div>
            <p class="login-register_exchange">No Account? &nbsp;<a class="account_a" href="register.php">Sign Up</a></p>
            <p class="home"><a href="index.php">Back to Home Page</a></p>
        </form>
    </div>
</body>
</html>