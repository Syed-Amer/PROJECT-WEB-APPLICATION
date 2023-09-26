<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../register/style.css">
</head>

<body>
    <form action="login.php" method="post">
        <h2>Login</h2>
        <?php if (isset($_GET['error']))
            echo '<p class="error">' . $_GET['error'] . '</p>';
        ?>
        <?php if (isset($_GET['success']))
            echo '<p class="success">' . $_GET['success'] . '</p>';
        ?>
        <label>User Name</label>
        <input type="text" name="uname" placeholder="User Name">

        <label>Password</label>
        <input type="password" name="password" placeholder="Password">
        <p><a href="../register/index.php"> Don't have account?</a></p>
        <button type="submit">Login</button>
    </form>
</body>

</html>