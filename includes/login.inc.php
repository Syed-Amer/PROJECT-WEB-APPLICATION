<?php
session_start();
if (isset($_POST['submit'])) {

    include_once 'db.inc.php';
    include_once 'functions.inc.php';

    $usernameOrEmail = $_POST['username_or_email'];
    $password = $_POST['password'];

    $_POST['username_or_email'] = $usernameOrEmail;

    // check if the field is empty
    if (empty($usernameOrEmail)) {
        echo "username empty";
    } elseif (empty($password)) {
        echo "password empty";
    }

    // check login using username or email. Store it in $column to use to verify in database
    $column = (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) ? "email" : "username";

    // check wether the username exist or not
    if (!exists($conn, $usernameOrEmail, $column)) {
        header("Location: ../login.php?error=User not exist");
        exit();
    }

    // check wether user login successfully by checking if the password is correct or not
    if (login($conn, $usernameOrEmail, $column, $password)) {
        header("Location: ../ytdl.php");
        exit();
    } else {
        header("Location: ../login.php?error=Wrong password");
        exit();
    }
} else {
    header("Location: ../login.php");
}
