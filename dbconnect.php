<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

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
?>
