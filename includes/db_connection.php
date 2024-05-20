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
?>