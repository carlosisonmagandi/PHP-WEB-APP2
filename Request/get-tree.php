<?php
require_once("../includes/db_connection.php");

$sql = "SELECT id,apprehended_items, apprehended_quantity FROM inventory";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while($row = $result->fetch_assoc()) {
        $data[] = array(
            'id' => $row['id'],
            'item' => $row['apprehended_items'],
            'quantity' => $row['apprehended_quantity']
        );
    }
}
$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
