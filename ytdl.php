<?php
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
        <label>Link</label>
        <input type="text" name="link" placeholder="Insert link here">


        <p>Choose download format:</p>

        <div class="radio-button">
            <div>
                <label for="option1">Option 1</label>
                <input type="radio" id="option1" name="options" value="option1">
            </div>

            <div>
                <label for="option2">Option 2</label>
                <input type="radio" id="option2" name="options" value="option2">
            </div>
        </div>

        <a href="register.php">Don't have account?</a>
        <button type="submit" name="submit">Register</button>
    </form>
</section>
</body>
<html>