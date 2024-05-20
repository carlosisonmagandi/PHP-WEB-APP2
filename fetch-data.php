<?php
//Fetching data from form
error_reporting(E_ALL);
ini_set('display_errors', '1');

$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'php_app_db';

// Create a connection
$connection = mysqli_connect($host, $user, $password, $database);

// Check the connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// SQL query to select all values from the account table
$sql = "SELECT username, password FROM account";

// Execute the query
$result = mysqli_query($connection, $sql);

// Check if the query was successful
if ($result) {
    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            echo "Username: " . $row["username"]. " - Password: " . $row["password"]. "<br>";
        }
    } else {
        echo "No results found";
    }
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the connection
mysqli_close($connection);
?>
