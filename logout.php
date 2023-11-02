<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other page
header("Location: login.php"); // Change "login.php" to your desired destination
exit();
?>
