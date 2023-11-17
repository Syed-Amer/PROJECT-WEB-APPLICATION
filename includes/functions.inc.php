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
    $sql = "INSERT INTO Videos (user_id, title, video_url, download_format, filepath) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "stmt failed";
    }
    mysqli_stmt_bind_param($stmt, "issss", $userId, $title, $link, $format, $path);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
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
        echo '<td>' . $row['video_id'] . '</td>';
        echo '<td>' . $row['title'] . '</td>';
        echo '<td>' . $row['download_format'] . '</td>';
        echo '<td><a href="' . $row['filepath'] . '" download="' . $row['title'] . '">Download</td>';
        echo '<td><input type="checkbox" name="video[]" value="' . $row['video_id'] . '"></td>';
    }
}

function alreadyDownload($conn, $title, $format, $userId)
{
    $sql = "SELECT COUNT(*) as count FROM Videos WHERE title =? AND download_format =? AND user_id =?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "SQL statement failed";
    }
    mysqli_stmt_bind_param($stmt, "ssi", $title, $format, $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

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

function deleteVideo($conn, $videoId)
{
    $sql = "DELETE FROM Videos WHERE video_id = '$videoId'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Query failed");
    }
}

function alterData($conn, $videoId, $attr, $newData)
{
    $sql = "UPDATE Videos SET $attr = '$newData' WHERE video_id = '$videoId';";
    $result = $conn->query($sql);

    if (!$result) {
        die();
    }
}

function getUsername($conn, $id)
{
    $sql = "SELECT username FROM Users WHERE user_id = '$id';";
    $result = $conn->query($sql);

    if (!$result) {
        die("Failed");
    }

    $row = $result->fetch_assoc();
    return $row['username'];
}
function getUserEmail($conn, $id)
{
    $sql = "SELECT email FROM Users WHERE user_id = '$id';";
    $result = $conn->query($sql);

    if (!$result) {
        die("Failed");
    }

    $row = $result->fetch_assoc();
    return $row['email'];
}

function handleFormSubmission($conn)
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT * FROM Videos WHERE user_id = '$id';";

        $result = $conn->query($sql);

        if (!$result) {
            die("Query failed: " . $conn->error);
        }

        echo '<table border="1">';
        echo
        '<tr align="center">
        <td>Id</td>
        <td>Username</td>
        <td>Email</td>
        </tr>

        <tr>
        <td>' . $id . '</td>
        <td>' . getUsername($conn, $id) . ' </td>
        <td>' . getUserEmail($conn, $id) . ' </td>
        </tr>';

        echo '</table>';
        echo '<table border="1">';
        echo '<tr align="center"><td>Id</td><td>Title</td><td>Format</td><td>Download</td><td>Delete</td></tr>';
        fetchDownloaded($conn, $id);
        echo '</table>';
    }
}
