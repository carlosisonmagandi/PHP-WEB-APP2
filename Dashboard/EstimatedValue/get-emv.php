<?php
require_once("../../includes/db_connection.php");
    
$sql = "SELECT SUM(CAST(EMV_forest_product AS DECIMAL(10, 2))) AS total_emv
FROM inventory
WHERE species_status = 'Confiscated'
AND EMV_forest_product REGEXP '^[0-9]+(\.[0-9]+)?$'; 
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
