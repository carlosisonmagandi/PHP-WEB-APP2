<?php
require_once("../includes/db_connection.php");
$sql = "SELECT * FROM vehicles";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // $row['id'] = '<a class="clickable-vehicle-id">' . $row['id'] . '</a>';
        $data[] = $row;
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
