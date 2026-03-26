<?php
// this page is for logging out users by destroying their session and redirecting them to the login page :)
session_start();
session_destroy();
header("Location: login.php");
exit();
?>