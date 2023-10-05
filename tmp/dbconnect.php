<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function getUserId($username, $conn)
{
    $query = "SELECT user_id FROM Users WHERE username = '$username'";
    $result = $conn->query($query);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Fetch the result
    $row = $result->fetch_assoc();
    return $row['user_id'];
}

function insertToDatabase($userId, $conn, $title, $videoLink, $videoFormat, $filePath)
{
    $videoLink = $conn->real_escape_string($videoLink);
    $title = $conn->real_escape_string($title);

    // Use single quotes around string values in the SQL query
    $query = "INSERT INTO Videos (user_id, title, video_url, download_format, filepath) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    // Bind parameters and execute the statement
    $stmt->bind_param("issss", $userId, $title, $videoLink, $videoFormat, $filePath);

    if ($stmt->execute()) {
        // Insertion successful
        return true;
    } else {
        // Insertion failed
        return false;
    }
}

function getDownloadedVideos($conn, $userId)
{
    $query = "SELECT * FROM Videos WHERE user_id = $userId";
    $result = $conn->query($query);

    if (!$result) {
        die();
    }

    $videos = [];

    while ($row = $result->fetch_assoc()) {
        $video = [
            'title' => $row['title'],
            'video_url' => $row['video_url'],
            'filepath' => $row['filepath']
        ];

        $videos[] = $video;
    }

    return $videos;
}

$servername = "localhost"; // Replace with your database server hostname
$username = "root"; // Replace with your database username
$password = "sydamr"; // Replace with your database password
$database = "youtube_downloader"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

/* echo "Connected successfully<br>"; */

$sql = "SELECT * FROM Users";

$result = $conn->query($sql);


/* // Check if there are rows in the result set
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "User ID: " . $row["user_id"] . "<br>";
        echo "Username: " . $row["username"] . "<br>";
        echo "Email: " . $row["email"] . "<br>";
        echo "Registration Date: " . $row["registration_date"] . "<br>";
        echo "<hr>"; // Separator between records
    }
} else {
    echo "No records found in the Users table.";
} */


// Close the connection when done
