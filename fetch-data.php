<?php
require_once("includes/db_connection.php");

error_reporting(E_ALL);
ini_set('display_errors', '1');

$sql = "SELECT username, password FROM account";

$result = mysqli_query($connection, $sql);
if ($result) {
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "Username: " . $row["username"]. " - Password: " . $row["password"]. "<br>";
        }
    } else {
        echo "No results found";
    }
} else {
    echo "Error: " . mysqli_error($connection);
}
mysqli_close($connection);
?>
