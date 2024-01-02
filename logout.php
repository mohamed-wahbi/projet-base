<?php
    session_start();
    unset($_SESSION['userprofile']);
    session_destroy();
    header('location: login.php');
    die();
?>
