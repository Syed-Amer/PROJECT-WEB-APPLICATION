<!DOCTYPE html>
<html>

<head>
    <title>YouTube Video Downloader</title>
</head>

<body>
    <h1>YouTube Video Downloader</h1>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label>Enter Link
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

        <button type="submit">Download</button><br>
    </form>

        <p>
            asdasd
        </p>
        


    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get the user input (video link) from the form
        $videoLink = $_POST["video_link"];
        $video_format = $_POST["video_format"];

        // get video title
        $title = exec("yt-dlp --print \"%(title)s\" -I 1 \"$videoLink\"");
        $encodedFileName = rawurlencode("$title"); // Encode the file name
        $filePath = "/projectWeb/downloads/" . $encodedFileName; // Construct the file path

        // Validate the input (you can add more thorough validation)
        if (filter_var($videoLink, FILTER_VALIDATE_URL)) {

            // if user choose mp3
            if ($video_format == "mp3") {
                exec("yt-dlp -f bestaudio --extract-audio --audio-format mp3 -o \"downloads/$title\" --add-metadata --embed-thumbnail \"$videoLink\" 2>&1", $output, $returnCode);
                echo '<a href="' . "$filePath.mp3" . '" download="' . $title . '">Download File</a>';
            } elseif ($video_format == "mp4") {
                exec("yt-dlp -f \"bestvideo[height<=1080][ext=mp4]+bestaudio[ext=m4a]/best[height<=1080][ext=mp4]/best[height<=1080]\" --add-metadata --embed-thumbnail -o \"downloads/$title\" -I 1 \"$videoLink\" 2>&1", $output, $returnCode);
                echo "$title";
                echo '<a href="' . "$filePath.mp4" . '" download="' . $title . '">Download File</a>';

            }

            if ($returnCode == 0) {
                echo "Video downloaded successfully";
            } else {
                echo "Error download<br>";
                echo "$title<br>";
                foreach ($output as $line) {
                    echo $line . "<br>";
                }
            }
        } else {
            print("$video_format");
            echo "Invalid video link. Please enter a valid URL.";
            echo "$format";
        }
    }
    ?>

</body>

</html>
