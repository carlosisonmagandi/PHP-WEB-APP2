<?php
require_once("../../../includes/db_connection.php");

$inventoryId = isset($data['inventoryId']) ? intval($data['inventoryId']) : 0;
$quantity=isset($data['quantity']) ? intval($data['quantity']) : 0;
$item_id = isset($data['item_id']) ? intval($data['item_id']) : '';

$sql = "SELECT * FROM inventory where id=$inventoryId";
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
