<?php
include "../dbconnect.php";
// Check if user fill the form
if (isset($_POST['uname']) && isset($_POST['password']) && isset($_POST['email'])) {

    // function to validate user input. Remove unnessary white space
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $email = validate($_POST['email']);
    $passw = validate($_POST['password']);

    // function to check if the user input is already exists in database
    function exists($data, $conn, $tableName, $columnName)
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

    // Give error if User Name is empty
    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    }

    // Give error if Email is empty
    elseif (empty($email)) {
        header("Location: index.php?error=Email is required");
        exit();
    }

    // Give error if password is empty
    elseif (empty($passw)) {
        header("Location: index.php?error=Password is required");
        exit();
    }

    // Run this if all form is filled
    else {
        // Check if the username is already in used
        if (exists($uname, $conn, "Users", "username")) {
            header("Location: index.php?error=User Name already Exists");
            exit();
        }
        // check if email is already in used
        elseif (exists($email, $conn, "Users", "email")) {
            header("Location: index.php?error=Email already Exists");
            exit();
        }

        // sql script
        $sql = "INSERT INTO Users (username, password, email) VALUES (\"$uname\", \"$passw\", \"$email\")";

        // check if new record is create or not
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php?success=New account created successfully");
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the statement and connection
        $conn->close();
    }
} else {
    header("Location: index.php?error");
    exit();
}
