<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registerLogin.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Admin</title>
</head>

<body>

    <?php include_once 'header.php'; ?>

    <section class="section">
        <form action="includes/loginAdmin.inc.php" method="post">
            <h2>Admin</h2>
            <?php if (isset($_GET['error']) || isset($_GET['sucess'])) {
                echo '<p class="error">' . $_GET['error'] . '</p>';
            }
            ?>
            <label>Username/Email</label>
            <input type="text" name="username_or_email" placeholder="Enter your Username/Email">

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password">

            <a href="registerAdmin.php">Create new Admin?</a>
            <button type="submit" name="submit">Login</button>
        </form>
    </section>

</body>
<html>