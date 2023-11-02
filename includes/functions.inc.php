<?php
function validate($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function emptyInput($username, $email, $password, $rePassword)
{
    if (empty($username)) {
        return "Username is required";
    } elseif (empty($email)) {
        return "Email is required";
    } elseif (empty($password)) {
        return "Password is required";
    } elseif (empty($rePassword)) {
        return "Please confirm your password";
    }
    return ""; // No errors
}

function exists($conn, $data, $columnName, $tableName)
{
    // To avoid sql injection
    $userInput = mysqli_real_escape_string($conn, $data);

    // sql script to run
    $query = "SELECT COUNT(*) as count FROM $tableName WHERE $columnName = '$userInput'";

    // Execute the query
    $result = $conn->query($query);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    // Fetch the result
    $row = $result->fetch_assoc();

    // Check if the count is greater than 0, indicating that the input exists
    return $row['count'] > 0;
}

function createUser($conn, $uname, $email, $password, $tableName)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO $tableName (username, email, password) VALUES ('$uname', '$email', '$password');";

    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }
}

function login($conn, $usernameOrEmail, $column, $password, $tableName)
{
    $sql = "SELECT * FROM $tableName WHERE $column = '$usernameOrEmail';";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    if (!password_verify($password, $row['password'])) {
        header("Location: ../login.php?error=wrong password");
        exit();
    }
    return 1;
}

function getUserId($conn, $usernameOrEmail)
{
    $column = (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) ? "email" : "username";

    $sql = "SELECT * FROM Users WHERE $column = '$usernameOrEmail'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    return $row['user_id'];
}

function insertDownloadedVideo($conn, $userId, $link, $title, $format, $path)
{
    $sql = "INSERT INTO Videos (user_id, title, video_url, download_format, filepath) VALUES ('$userId', '$title', '$link', '$format', '$path');";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed: " . $conn->error);
    }
}

function fetchDownloaded($conn, $id)
{
    $sql = "SELECT * FROM Videos WHERE user_id = '$id';";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed");
    }

    $rows = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    foreach ($rows as $row) {
        echo '<tr align="center">';
        echo '<td>' . $row['title'] . '</td>';
        echo '<td>' . $row['download_format'] . '</td>';
        echo '<td><a href="' . $row['filepath'] . '" download>Download</td>';
        echo '<td><input type="checkbox" name="video[]" value="' . $row['video_id'] . '"></td>';
    }
}

function alreadyDownload($conn, $title, $format, $userId)
{
    $sql = "SELECT COUNT(*) as count FROM Videos WHERE title = '$title' AND download_format = '$format' AND user_id = '$userId'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query Failed" . $conn->error);
    }

    $row = $result->fetch_assoc();

    return ($row['count'] > 0);
}

function handleDownloadError($output)
{
    echo "<pre>";
    var_dump($output);
    echo "</pre>";
    exit();
}

function getAllUsersId($conn)
{
    $sql = "SELECT * FROM Users;";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed");
    }

    $rows = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    foreach ($rows as $row) {
        echo '<option value="' . $row['user_id'] . '">' . $row['username'] . '</option>';
    }
}

function deleteVideo($conn, $videoId) {
    $sql = "DELETE FROM Videos WHERE video_id = '$videoId'";
    $result = $conn->query($sql);

    if(!$result) {
        die("Query failed");
    }
}

function alterData($conn, $videoId, $attr, $newData) {
    $sql = "UPDATE Videos SET $attr = '$newData' WHERE video_id = '$videoId';";
    $result = $conn->query($sql);

    if (!$result){
        die();
    }
}