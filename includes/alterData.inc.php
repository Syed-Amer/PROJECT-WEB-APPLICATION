<?php
include_once 'db.inc.php';
include_once 'functions.inc.php';

if (isset($_POST['update'])) {
    if (!empty($_POST['video_id'])) {
        $videoId = $_POST['video_id'];
        $sql = "SELECT COUNT(*) as count FROM Videos Where video_id = '$videoId';";
        $result = $conn->query($sql);

        if (!$result) {
            die();
        }

        $row = $result->fetch_assoc();

        if ($row['count'] <= 0) {
            echo "not exit";
            exit();
        }

        if (!empty($_POST['title'])) {
            $newTitle = $_POST['title'];
            alterData($conn, $videoId, "title", $newTitle);
        }
        if (!empty($_POST['format'])) {
            echo "run!";
            $newFormat = $_POST['format'];
            echo "format:$newFormat";
            alterData($conn, $videoId, "download_format", $newFormat);
        }
        if (!empty($_POST['filepath'])) {
            $newPath = $_POST['filepath'];
            alterData($conn, $videoId, "filepath", $newPath);
        }
    }
}
