<?php
require_once("../includes/db_connection.php");

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $connection->prepare("UPDATE pushednotification SET status = 'seen' WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "Success";
    } else {
        echo "Failed";
    }

    $stmt->close();
}

$connection->close();
?>