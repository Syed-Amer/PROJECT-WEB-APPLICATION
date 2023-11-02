<?php
include_once 'db.inc.php';
include_once 'functions.inc.php';
session_start();

if (isset($_POST['delete'])) {
    $id = $_SESSION['id'];
    if (isset($_POST['video'])) {
        foreach ($_POST['video'] as $video) {
            deleteVideo($conn, $video);
        }
        header("location: ../historyAdmin.php?id=$id");
        exit();
    }
    deleteVideo($conn, $video);
    header("location: ../history.php");
    exit();
}
