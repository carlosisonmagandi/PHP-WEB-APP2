<?php
require_once("../../includes/db_connection.php");
    
$sql = "SELECT COUNT(*) AS equipment_count FROM equipments";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
