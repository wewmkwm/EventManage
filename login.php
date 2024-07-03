<?php
session_start();
include 'config.php';
// error_reporting(0);

?>

<!DOCTYPE html>
<html>

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
        })
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
            <p class="login-register_exchange">No Account? &nbsp<a class="account_a" href="register.php"> Sign Up</a></p>
            <p class="home"><a href="index.php">Back to Home Page</a></p>
        </form>
    </div>

</body>

</html>

<?php 
if (isset($_POST['submit'])) {
    
    /* Collect inputted form data */
    $email = $_POST['email'];
    $password = $_POST['password'];

    /* Check to see if existing email and password combination exists in database */
    $sql = "SELECT * FROM user WHERE Email='$email' AND Password='$password'";
    // $sql1 = "SELECT * FROM club WHERE C_Email='$email' AND C_Password='$password'";
    // $sql2 = "SELECT * FROM admin WHERE A_Email='$email' AND A_Pass='$password'";

    
    /* Query between variable 'con' and 'sql' */
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    // $result1 = mysqli_query($con, $sql1);
    // $result2 = mysqli_query($con, $sql2);
    
    if (mysqli_num_rows($result) == 1 && $row['Role']=="User") {
        $_SESSION['login'] = $email;
        $_SESSION['role'] = $row['Role'];  
        header("Location: index.php");
        exit;
    } else if (mysqli_num_rows($result) == 1 && $row['Role']=="Company") {
        $_SESSION['login'] = $email; 
        header("Location: manage_event.php");
        exit;
    } else if (mysqli_num_rows($result) == 1&& $row['Role']=="Admin") {
        $_SESSION['login'] = $email; 
        header("Location: event_pending.php");
        exit;
    } else {
        echo "<script>pop_up()</script>";
    }
}
?>
