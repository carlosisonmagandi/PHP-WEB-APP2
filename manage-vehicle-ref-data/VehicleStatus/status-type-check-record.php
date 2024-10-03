<?php

require_once("../../includes/db_connection.php");

if (isset($_GET['statusTitle'])) {
    $statusTitle = $_GET['statusTitle'];

    $sql = "SELECT COUNT(*) as count FROM vehicle_status_ref_data WHERE status_title = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $statusTitle);
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
