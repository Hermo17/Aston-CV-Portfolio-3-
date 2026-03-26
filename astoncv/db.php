<?php
// Database settings connection to myphpadmin database astoncv
$host     = "localhost";
$dbname   = "dg240167376_astoncv";
$username = "dg240167376";
$password = "tgE1BsJDBdOx7TD3fjyY1iUwN"; 

try {
    // Create connection using PDO 
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Show errors clearly during development 
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>