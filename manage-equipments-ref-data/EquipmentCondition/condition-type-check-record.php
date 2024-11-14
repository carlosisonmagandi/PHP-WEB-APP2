<?php

require_once("../../includes/db_connection.php");

if (isset($_GET['conditionTitle'])) {
    $conditionTitle = $_GET['conditionTitle'];

    $sql = "SELECT COUNT(*) as count FROM equipment_condition_ref_data WHERE condition_title = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $conditionTitle);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $exists = $count > 0 ? true : false;

    echo json_encode(['exists' => $exists]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing Status title parameter']);
}

$stmt->close();
$connection->close();
?>
