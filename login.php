<?php
session_start();
include_once 'header.php';
?>

<section class="section-register">
    <form action="includes/login.inc.php" method="post">
        <h2>Login</h2>
        <?php if (isset($_GET['error']) || isset($_GET['sucess'])) {
            echo '<p class="error">' . $_GET['error'] . '</p>';
        }
        ?>
        <?php
            echo '<p>' . $_SESSION['usernameOrEmail'] . '</p>';
        ?>
        <label>Username/Email</label>
        <input type="text" name="username_or_email" placeholder="Enter your Username/Email">

        <label>Password</label>
        <input type="password" name="password" placeholder="Enter your password">

        <a href="register.php">Don't have account?</a>
        <button type="submit" name="submit">Register</button>
    </form>
</section>
</body>
<html>