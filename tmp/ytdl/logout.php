<?php
session_start(); // Start the session

// Check if the user is logged in (you can use your own condition)
if (isset($_SESSION['username'])) {
    // Unset all session variables
    session_unset();

    // Destroy the session
    session_destroy();

    // Redirect the user to the login page or any other page
    header("Location: ../login/index.php"); // Replace 'login.php' with your desired page
    exit();
} else {
    // If the user is not logged in, redirect them to the login page
    header("Location: ../login/index.php");
    exit();
}
?>
