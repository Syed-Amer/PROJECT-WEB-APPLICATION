<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$serverName = "localhost";
$username= "root";
$password = "sydamr";
$databaseName = "youtube_downloader";

$conn = mysqli_connect($serverName, $username, $password, $databaseName);

if($conn) {
    echo "db connect sucess";
}
