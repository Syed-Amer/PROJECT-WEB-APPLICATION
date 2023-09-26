<?php
session_start();
include "../dbconnect.php";

// Check if user filled the form
if (isset($_POST['uname']) && isset($_POST['password'])) {

    //function to validate user input. and remove unnessary white space
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $uname = validate($_POST['uname']);
    $passw = validate($_POST['password']);

    $_SESSION['uname'] = $uname;

    //function to check if the input is exist or not
    function matches($uname, $passw, $conn)
    {
        // Avoid mysql injection
        $uname = mysqli_real_escape_string($conn, $uname);
        $passw = mysqli_real_escape_string($conn, $passw);

        // sql script to run
        $query = "SELECT COUNT(*) as count FROM Users WHERE username = '$uname' AND password = '$passw'";
        
        // execute
        $result = $conn->query($query);

        if(!$result) {
            die("Query failed" . $conn->error);
        }

        //fetch result
        $row = $result->fetch_assoc();
        
        // return 
        return $row['count'] > 0;
    }

    

    // Give error if User Name is empty
    if (empty($uname)) {
        header("Location: index.php?error=User Name is required");
        exit();
    } 
    
    // Give error if password is empty
    elseif (empty($passw)) {
        header("Location: index.php?error=Password is required");
        exit();
    } 

    // Run this if form is filled
    else{
        if(!matches($uname, $passw, $conn)){
            header("Location: index.php?error=Wrong username or password");
            exit();
        }
        else {

            header("Location: ../ytdl/index.php");
            exit();
        }
    }
}
