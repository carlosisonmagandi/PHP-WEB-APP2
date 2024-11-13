<?php
require_once("../includes/db_connection.php");
session_start();


$sql = "SELECT * FROM request_form WHERE created_by = ? ORDER BY created_on DESC";
$stmt = $connection->prepare($sql);
if ($stmt) {
    $stmt->bind_param("s", $_SESSION['session_username']);
    
    $stmt->execute();

    $result = $stmt->get_result();
    
    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    $stmt->close();
} else {
    die("Error preparing statement: " . $connection->error);
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);

?>
