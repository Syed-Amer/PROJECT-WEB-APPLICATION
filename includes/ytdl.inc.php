<?php
session_start();
if (isset($_POST['submit'])) {
    include_once 'db.inc.php';
    include_once 'functions.inc.php';

    // get SESSION variables
    $usernameOrEmail = $_SESSION['usernameOrEmail'];

    // get userid 
    $id = getUserId($conn, $usernameOrEmail);

    $_SESSION['id'] = $id;

    $videoUrl = $_POST['link'];
    $downloadFormat = $_POST['format'];

    echo "$videoUrl<br>$downloadFormat";

    if (!filter_var($videoUrl, FILTER_VALIDATE_URL)) {
        header("Location: ../ytdl.php?error=not a link");
        exit();
    }

    $title = exec("yt-dlp --print \"%(title)s\" -I 1 \"$videoUrl\"");
    $encodedTitle = rawurlencode("$title");


    if ($downloadFormat === "mp3") {
        $filePath = "/Youtube Downloader/Downloads/" . rawurlencode("$title.mp3");
        $_SESSION['filePath'] = $filePath;

        if (!alreadyDownload($conn, $title, $downloadFormat, $id)) {

            exec("yt-dlp -f bestaudio --extract-audio --audio-format mp3 -o \"/srv/http/Youtube Downloader/Downloads/$title\" -I 1 --add-metadata --embed-thumbnail \"$videoUrl\" 2>&1", $output, $returnCode);

            // print error if get any
            if ($returnCode) {
                handleDownloadError($output);
            }
        } else {
            header("Location: ../ytdl.php?success=1");
            exit();
        }
    } elseif ($downloadFormat === "mp4") {
        $filePath = "/Youtube Downloader/Downloads/" . rawurlencode("$title.mp4");
        $_SESSION['filePath'] = $filePath;

        if (!alreadyDownload($conn, $title, $downloadFormat, $id)) {

            exec("yt-dlp -f \"bestvideo[height<=1080][ext=mp4]+bestaudio[ext=m4a]/best[height<=1080][ext=mp4]/best[height<=1080]\" --add-metadata --embed-thumbnail -o \"/srv/http/Youtube Downloader/Downloads/$title\" -I 1 \"$videoUrl\" 2>&1", $output, $returnCode);

            // print error if get any
            if ($returnCode) {
                handleDownloadError($output);
            }
        } else {
            header("Location: ../ytdl.php?success=1");
            exit();
        }
    }
    // insert to databse
    insertDownloadedVideo($conn, $id, $videoUrl, $title, $downloadFormat, $filePath);
    $_SESSION['filePath'] = $filePath;
    header("Location: ../ytdl.php?success=1");
    exit();
}
