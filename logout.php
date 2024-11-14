<?php
    //user logout, clear session
    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['role']);
    header("location:index.php");
?>