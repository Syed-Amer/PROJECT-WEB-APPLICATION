<?php
if (isset($_POST['submit'])) {
    echo "submit!";

    // include database and function
    include_once 'db.inc.php';
    include_once 'functions.inc.php';

    $uname = validate($_POST['username']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $rePassword = validate($_POST['rePassword']);

    // check if the form has empty field
    if (!empty($empty = emptyInput($uname, $email, $password, $rePassword))) {
        header("Location: ../register.php?error=" . $empty);
        exit();
    }

    // check if the password enter is same or not
    if ($password !== $rePassword) {
        header("Location: ../register.php?error=Password not match");
        exit();
    }

    // check if the username has already taken
    if (exists($conn, $uname, "username")) {
        header("Location: ../register.php?error=Username already taken");
        exit();
    }

    // check if the email has already taken
    if (exists($conn, $email, "email")) {
        header("Location: ../register.php?error=Email already use");
        exit();
    }

    createUser($conn, $uname, $email, $password);
    header("Location: ../register.php?success=Account created successfully");
    exit();

} else {
    header("Location: ../register.php");
}
