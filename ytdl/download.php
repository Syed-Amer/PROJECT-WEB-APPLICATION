<?php
include "../dbconnect.php";
session_start();
$username = $_SESSION['uname'];

echo "$username<br>";
$download = "";

// Function to get user id
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

function insertToDatabase($userId, $conn, $title, $videoLink, $videoFormat)
{
    $videoLink = $conn->real_escape_string($videoLink);
    $title = $conn->real_escape_string($title);

    // Use single quotes around string values in the SQL query
    $query = "INSERT INTO Videos (user_id, title, video_url, download_format) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    // Bind parameters and execute the statement
    $stmt->bind_param("isss", $userId, $title, $videoLink, $videoFormat);

    if ($stmt->execute()) {
        // Insertion successful
        return true;
    } else {
        // Insertion failed
        return false;
    }
}
// get user id
$userId = getUserId($username, $conn);
echo "$userId";

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
                if (insertToDatabase($userId, $conn, $title, $videoLink, $videoFormat)) {
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
