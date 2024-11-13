<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$host = 'localhost';
$user = 'root';
$password = 'root';
$database = 'php_app_db';

$connection = mysqli_connect($host, $user, $password, $database);// Create a connection

if (!$connection) {// Check the connection
    die("Database connection failed: " . mysqli_connect_error());
}
?>