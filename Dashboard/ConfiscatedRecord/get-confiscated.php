<?php
require_once("../../includes/db_connection.php");
    
$sql = "SELECT 
    ( 
        (SELECT COUNT(*) FROM inventory) + 
        (SELECT COUNT(*) FROM equipments) + 
        (SELECT COUNT(*) FROM vehicles)
    ) AS total_count;
";
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
