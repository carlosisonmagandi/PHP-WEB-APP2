<?php
require_once("../includes/db_connection.php");

$sql = "SELECT type_title FROM equipment_type_ref_data ORDER BY created_on DESC";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = array('type_title' => $row['type_title']);
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
