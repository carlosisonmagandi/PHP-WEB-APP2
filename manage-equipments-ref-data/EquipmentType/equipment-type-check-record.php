<?php

require_once("../../includes/db_connection.php");

if (isset($_GET['equipmentTitle'])) {
    $equipmentTitle = $_GET['equipmentTitle'];

    $sql = "SELECT COUNT(*) as count FROM equipment_type_ref_data WHERE type_title = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $equipmentTitle);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $exists = $count > 0 ? true : false;

    echo json_encode(['exists' => $exists]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing equipment type parameter']);
}

$stmt->close();
$connection->close();
?>
