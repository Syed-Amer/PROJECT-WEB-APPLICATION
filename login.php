<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registerLogin.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Login</title>
</head>

<body>

    <?php include_once 'header.php'; ?>

    <section class="section">
        <form action="includes/login.inc.php" method="post">
            <h2>Login</h2>
            <?php if (isset($_GET['error']) || isset($_GET['sucess'])) {
                echo '<p class="error">' . $_GET['error'] . '</p>';
            }
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