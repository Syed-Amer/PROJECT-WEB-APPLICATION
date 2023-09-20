<?php
// Initialize variables
$format = '';
$resolutionRequired = false;

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the selected format from the form
    $format = $_POST["format"];

    // Determine if resolution selection should be required
    $resolutionRequired = ($format === "mp4");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Format and Resolution Selection</title>
    <style>
        .nested-radio {
            margin-left: 20px;
            /* Adjust the indentation as needed */
        }
    </style>
</head>

<body>
    <form method="post">
        <label>
            <input type="radio" name="format" value="mp3" <?php echo ($format === "mp3") ? "checked" : ""; ?>> MP3
        </label><br>

        <label>
            <input type="radio" name="format" value="mp4" <?php echo ($format === "mp4") ? "checked" : ""; ?>> MP4
        </label><br>

        <div class="nested-radio">
            <label>
                <input type="radio" name="resolution" value="720p" <?php echo ($resolutionRequired) ? "required" : ""; ?>> 720p
            </label><br>

            <label>
                <input type="radio" name="resolution" value="1080p" <?php echo ($resolutionRequired) ? "required" : ""; ?>> 1080p
            </label><br>
        </div>

        <button type="submit">Download</button>
    </form>
</body>

</html>