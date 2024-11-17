<?php
require_once("../../includes/db_connection.php");

$sql = "SELECT COUNT(*) AS total_quantity FROM request_form WHERE approval_status='Completed'";
$result = $connection->query($sql);

$data = array();

$data['total_quantity'] = 0;

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $data['total_quantity'] = $row['total_quantity'] ?? 0;
}

$connection->close();

// Send the total quantity as a JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
