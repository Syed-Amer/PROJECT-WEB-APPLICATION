<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/registerLogin.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>

    <?php
    include_once 'header.php';
    ?>

    <section class="section">
        <form action="includes/register.inc.php" method="post">
            <h2>Register</h2>
            <?php if (isset($_GET['error']) || isset($_GET['sucess']))
                echo '<p class="error">' . $_GET['error'] . '</p>';
            echo '<p class="success">' . $_GET['success'] . '</p>';
            ?>
            <label>Username</label>
            <input type="text" name="username" placeholder="Enter your Username">

            <label>Email Address</label>
            <input type="text" name="email" placeholder="Enter your email address">

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">

            <label>Confirm Password</label>
            <input type="password" name="rePassword" placeholder="Re-Enter your password">

            <a href="login.php">Already have account?</a>
            <button type="submit" name="submit" class="register">Register</button>
        </form>
    </section>
</body>
<html>