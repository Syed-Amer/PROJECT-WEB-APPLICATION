<?php
session_start();
?>
<header class="header-main">
  <div class="header-logo"><a href="index.php"><img src="image/ytdl.png" alt=""></a></div>
  <nav class="header-nav">
    <ul>
      <li><a href="./index.php">Home</a></li>

      <!-- If not login -->
      <?php if (!$_SESSION['login']) {
        echo "<li><a href='login.php'>Login</a></li>";
        echo "<li><a href='register.php'>Register</a></li>";
        echo "<li><a href='loginAdmin.php'>Admin</a></li>";
      }
      // if login
      else {

        // if login AND not admin(user)
        if (!$_SESSION['admin']) {
          echo "<li><a href='ytdl.php'>Downloader</a></li>";
          echo "<li><a href='history.php'>History</a></li>";
          echo "<li><a href='manual.php'>Manual</a></li>";
        }

        // login and admin
        else {
          echo "<li><a href='historyAdmin.php'>History</a></li>";
        }
        echo "<li><a href='logout.php'>Logout</a></li>";
      }

      ?>
    </ul>
  </nav>
  <div class="header-sm"><a href="https://www.github.com/Syed-Amer/"><img src="image/github-logo.png" alt=""></a></div>
</header>