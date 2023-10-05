<?php
session_start();
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

function exists($conn, $data, $columnName)
    {
        // To avoid sql injection
        $userInput = mysqli_real_escape_string($conn, $data);

        // sql script to run
        $query = "SELECT COUNT(*) as count FROM Users WHERE $columnName = '$userInput'";

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

function createUser($conn, $uname, $email, $password)
{
    $password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO Users (username, email, password) VALUES ('$uname', '$email', '$password');";

    $result = $conn->query($sql);

    if(!$result) {
        die("Query failed: " . $conn->error);
    }
}

function login($conn, $usernameOrEmail, $column, $password)
{
    $sql = "SELECT * FROM Users WHERE $column = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=stmtError");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $usernameOrEmail);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($result)) {


        if (password_verify($password, $row['password'])) {
            return 1;
        }
        return 0;
    }
}
