<?php
include "../dbconnect.php";
session_start();

// get user variable session
$userId = $_SESSION['userId'];
$username = $_SESSION['username'];

// check if form is filled
if (isset($_POST['video_format']) && isset($_POST['video_link'])) {
    $videoFormat = $_POST['video_format'];
    $videoLink = $_POST['video_link'];

    // Validate video link
    if (filter_var($videoLink, FILTER_VALIDATE_URL)) {

        // get video title
        $title = exec("yt-dlp --print \"%(title)s\" -I 1 \"$videoLink\"");

        // encode the title
        $encodedTitle = rawurlencode("$title");

        // filepath
        $filePath = "/projectWeb/downloads/" . $encodedTitle;

        // run this if the video format is mp3
        if ($videoFormat == "mp3") {
            // command to download 
            exec("yt-dlp -f bestaudio --extract-audio --audio-format mp3 -o \"/srv/http/projectWeb/downloads/$title\" -I 1 --add-metadata --embed-thumbnail \"$videoLink\" 2>&1", $output, $returnCode);

            // check if download successful 
            if ($returnCode === 0) {

                // update to database
                if (insertToDatabase($userId, $conn, $title, $videoLink, $videoFormat, $filePath .'.mp3')) {
                    $encodePath = rawurlencode($filePath);
                    header("Location: index.php?download=$encodedTitle.mp3");
                    exit();
                } else {
                    echo "Error inserting video.";
                }
            } else {
                echo "Error downloading MP3";
            }
        }

        // run this if the video format is mp4
        elseif ($videoFormat == "mp4") {
            // command to download 
            exec("yt-dlp -f \"bestvideo[height<=1080][ext=mp4]+bestaudio[ext=m4a]/best[height<=1080][ext=mp4]/best[height<=1080]\" --add-metadata --embed-thumbnail -o \"/srv/http/projectWeb/downloads/$title\" -I 1 \"$videoLink\" 2>&1", $output, $returnCode);

            // give download link
            echo '<a href="' . "$filePath.mp4" . '" download="' . $title . '">Download File</a>';
        }
    } else {
        echo "fucinking url";
    }
} else {
    echo "no data";
}
