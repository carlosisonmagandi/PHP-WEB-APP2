<?php
require_once("../includes/db_connection.php");

$sql = "SELECT status_title FROM equipment_status_ref_data ORDER BY created_on DESC";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row['status_title'];
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
