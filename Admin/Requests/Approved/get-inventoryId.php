<?php
require_once("../../../includes/db_connection.php");

$requestId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($requestId == 0) {
    echo json_encode(["error" => "Invalid ID parameter"]);
    exit();
}

$sql = "SELECT * FROM request_form WHERE id=$requestId";
$result = $connection->query($sql);

if (!$result) {
    echo json_encode(["error" => "Database query failed: " . $connection->error]);
    exit();
}

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
