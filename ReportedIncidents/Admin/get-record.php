<?php
require_once("../../includes/db_connection.php");
$sql = "SELECT * FROM incident_reports";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // $row['id'] = '<a class="clickable-id" id="clickableId">' . $row['id'] . '</a>';
        $data[] = $row;
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
