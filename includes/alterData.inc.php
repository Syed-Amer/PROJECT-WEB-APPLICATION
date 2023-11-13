<?php
include_once 'db.inc.php';
include_once 'functions.inc.php';
session_start();

if (isset($_POST['update'])) {

    $selectedId = $_SESSION['selectId'];
    if (empty($_POST['video_id'])) {
        if ($_SESSION['admin']) {
            header("location: ../historyAdmin.php?error=EmptyForm&id=$selectedId");
            exit();
        }
        header("location: ../history.php?error=EmptyForm");
        exit();
    }

    $videoId = $_POST['video_id'];
    $sql = "SELECT COUNT(*) as count FROM Videos Where video_id = '$videoId';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }

    $row = $result->fetch_assoc();

    if ($row['count'] <= 0) {
        if ($_SESSION['admin']) {
            header("location: ../historyAdmin.php?error=NotExist&id=$selectedId");
            exit();
        }
        header("location: ../history.php?error=NotExist");
        exit();
    }

    if (!empty($_POST['title'])) {
        $newTitle = $_POST['title'];
        alterData($conn, $videoId, "title", $newTitle);
    }
    if (!empty($_POST['filepath'])) {
        $newPath = $_POST['filepath'];
        alterData($conn, $videoId, "filepath", $newPath);
    }

    if ($_SESSION['admin']) {
        header("location: ../historyAdmin.php?update=updated&id=$selectedId");
        exit();
    }

    header("location: ../history.php?update=updated");
} else {
    if ($_SESSION['admin']) {
        echo "admin";
        echo "form empty";
    }
}
