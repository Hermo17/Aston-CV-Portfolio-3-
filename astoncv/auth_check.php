<?php
// SECURITY: Authentication Guard: users need to login to view any cv on my website, if they arent logged in it will redirect them to login page.
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>