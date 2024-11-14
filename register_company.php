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
    function pop_up_success() {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Account Registered! Please Click On Continue to Login',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: '<a href="login.php" style="text-decoration:none; color:white;">Continue</a>',
            showClass: {
                popup: 'animate_animated animate_fadeInDown'
            },
            hideClass: {
                popup: 'animate_animated animate_fadeOutUp'
            }
        })
    };

    function pop_up_email() {
        Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'The Email Address entered is already Registered.',
            showCancelButton: true,
            confirmButtonText: 'Retry again'
        })
    }

    function pop_up_password() {
        Swal.fire({
            icon: 'error',
            title: 'Oops',
            text: 'Password and Confirm Password do not match.',
            showCancelButton: true,
            confirmButtonText: 'Retry again'
        })
    }

    function pop_up_password_requirements() {
        Swal.fire({
            icon: 'error',
            title: 'Password Requirements',
            text: 'Password must be at least 8 characters long and contain at least one special character.',
            showCancelButton: true,
            confirmButtonText: 'Retry again'
        })
    }
    </script>

</head>

<body>
    <div class="form_container">
        <form action="" method="POST" class="login">
            <p class="login_word" style="font-size: 2rem; font-weight: 100;">Company Register</p>
            <div class="input-field">
                <input type="text" placeholder="Company Name" name="name" required>
            </div>
            <div class="input-field">
                <input type="email" placeholder="Company Email Address" name="email" required>
            </div>
            <div class="input-field">
                <input type="password" placeholder="Password" name="password" required>
            </div>
            <div class="input-field">
                <input type="password" placeholder="Confirm Password" name="confirmpassword" required>
            </div>
            <div class="input-field">
                <button name="submit" class="btn">Register</button>
            </div>
            <p class="login-register_exchange">For User Register: &nbsp<a class="account_a" href="register.php">Click Here</a></p>
            <p class="home"><a href="login.php">Back to Login</a></p>
        </form>
    </div>
</body>
</html>

<?php 
if (isset($_POST['submit'])) {
    /* Collect inputted form data */
    $email = $_POST['email'];
    $name = $_POST['name'];
    $confirmpass = $_POST['confirmpassword'];
    $password = $_POST['password'];

    // Email validation with regular expression
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match("/@.+\.com$/", $email)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address with an \"@\" symbol and \".com\" at the end.',
                confirmButtonText: 'Retry again'
            });
        </script>";
    } 
    // Check if password meets requirements
    else if (strlen($password) < 8 || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        echo "<script>pop_up_password_requirements()</script>";
    } 
    else if ($password == $confirmpass) {
        // Check if email is already registered
        $sql = "SELECT * FROM user WHERE Email='$email'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result) == 1) {
            echo "<script>pop_up_email()</script>";
        } else {
            // Generate UserID
            $sql11 = "SELECT * FROM user";
            $result11 = mysqli_query($con, $sql11);
            $X = mysqli_num_rows($result11);
            $id = 'C' . sprintf("%'03d", $X + 2 );

            // Hash the password before storing it
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert company data into the database
            $sql = "INSERT INTO `user`(`UserID`, `Name`, `Email`, `Password`, `Role`) 
                    VALUES ('$id','$name','$email','$hashed_password','Company')";
            $result = mysqli_query($con, $sql);
            if ($result) {
                echo "<script>pop_up_success()</script>";
            } else {
                echo "<script>pop_up_error()</script>";  // Error popup for failed insertion
            }
        }
    } else {
        echo "<script>pop_up_password()</script>";
    }
}
?>
