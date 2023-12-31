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
    if (!exists($conn, $usernameOrEmail, $column, "Admin")) {
        header("Location: ../loginAdmin.php?error=Admin not exist");
        exit();
    }

    // check wether user login successfully by checking if the password is correct or not
    login($conn, $usernameOrEmail, $column, $password, "Admin");

    $_SESSION['usernameOrEmail'] = $usernameOrEmail;
    $_SESSION['login'] = true;
    $_SESSION['admin'] = true;
    $_SESSION['user_id'] = getUserId($conn, $usernameOrEmail);

    header("Location: ../index.php");
    exit();

} else {
    header("Location: ../login.php");
}
