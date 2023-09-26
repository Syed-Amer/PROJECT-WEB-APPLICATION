<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <form action="register.php" method="post">
        <h2> Register </h2>
        <?php if (isset($_GET['error']))
            echo '<p class="error">' . $_GET['error'] . '</p>';
        ?>
        <?php if (isset($_GET['success']))
            echo '<p class="success">' . $_GET['success'] . '</p>';
        ?>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name">

        <label>Email Address</label>
        <input type="text" name="email" placeholder="Email">

        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
        <p><a href="../login/index.php">Already have account?</a></p>
        <a href="https://google.com"><img src="../image/click_here.gif"></a>
        <button type="submit">Register</button>
    </form>
</body>

</html>