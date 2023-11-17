<?php
include_once 'db.inc.php';
include_once 'functions.inc.php';
session_start();

if (isset($_POST['delete'])) {
    $id = $_SESSION['selectId'];
    foreach ($_POST['video'] as $video) {
        deleteVideo($conn, $video);
    }
    if (isset($_SESSION['admin'])) {
        // header("location: ../historyAdmin.php?id=$id");
        header("location: ../historyAdmin.php?id=$id");
        exit();
    }
    header("location: ../history.php");
    exit();
}
