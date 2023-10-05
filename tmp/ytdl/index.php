<?php
session_start();

if (!isset($_SESSION['authenticated'])) {
    // Redirect the user to the login page if not authenticated
    header("Location: ../login/index.php");
    exit();
}
if (isset($_GET['history'])) {
    // Redirect to the history page
    $_SESSION['test'] = 'asd';
    header("Location: ../history/index.php");
    exit(); // Make sure to exit to prevent further script execution
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YouTube Video Downloader</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <form action="download.php" method="post">
        <h1>YouTube Video Downloader</h1>
        <label>Enter Link:<br>
            <input type="text" id="video_link" name="video_link" required><br>
        </label><br>

        <label>
            Choose Video Format:
        </label><br>

        <label for="mp3">
            <input type="radio" id="mp3" name="video_format" value="mp3" required>MP3
        </label><br>

        <label for="mp4">
            <input type="radio" id="mp4" name="video_format" value="mp4" required>MP4
        </label><br>

        <button type="submit">Submit</button><br>
        <?php
        // Check if the 'download' parameter exists
        if (isset($_GET['download'])) {
            $downloadedFileName = $_GET['download'];
        }
        ?>
        <a href="/projectWeb/downloads/<?php echo $downloadedFileName; ?>" class="button" download=" <?php echo $downloadedFileName; ?>">Download </a>
        <a href="?history=1">history</a>
        <a href="logout.php">logout</a>
    </form><br>

</body>

</html>