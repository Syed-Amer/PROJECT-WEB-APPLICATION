<?php
include "../dbconnect.php";
session_start();
if (isset($_SESSION['userId'])) {
    $userId = $_SESSION['userId'];
    echo "$userId";
    echo "log in!<br>";


    $downloadedVideos = getDownloadedVideos($conn, $userId);

    foreach ($downloadedVideos as $video) {
    echo "Title: " . $video['title'] . "<br>";
    echo "Video URL: " . $video['video_url'] . "<br>";
    echo "Filepath: " . $video['filepath'] . "<br>";
    echo "<br>";
}
    
} else {
    echo "not login";
}
