<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Downloader</title>
    <link rel="stylesheet" href="css/ytdl.css">
    <link rel="stylesheet" href="css/header.css">
</head>

<body>

    <?php
    include_once 'header.php';
    if (!$_SESSION['login']) {
        header("Location: index.php");
        exit();
    }
    ?>

    <section class="section-ytdl">
        <form action="includes/ytdl.inc.php" method="post">
            <h2>Youtube Video Downloader</h2>
            <?php if (isset($_GET['error']) || isset($_GET['sucess'])) {
                echo '<p class="error">' . $_GET['error'] . '</p>';
            }
            ?>
            <label>Link</label>
            <input type="text" name="link" placeholder="Insert link here">


            <p>Choose download format:</p>

            <table>
                <tr>
                    <td>MP3</td>
                    <td>
                        <input type="radio" id="mp3" name="format" value="mp3" required>
                    </td>
                </tr>

                <tr>
                    <td>MP4</td>
                    <td>
                        <input type="radio" id="mp4" name="format" value="mp4" required>
                    </td>
                </tr>
            </table>

            <?php

            if ($_GET['success']) {
                $filePath = $_SESSION['filePath'];
                echo "<a href='  $filePath' class='download' download>Download</a>";
            }
            ?>
            <button type="submit" name="submit">Submit</button>
        </form>
    </section>
</body>
<html>