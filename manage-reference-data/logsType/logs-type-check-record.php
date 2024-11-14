<?php

require_once("../../includes/db_connection.php");

if (isset($_GET['logsTypeTitle'])) {
    $logsTypeTitle = $_GET['logsTypeTitle'];

    $sql = "SELECT COUNT(*) as count FROM logs_type_ref_data WHERE type_title = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $logsTypeTitle);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $exists = $count > 0 ? true : false;

    echo json_encode(['exists' => $exists]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing record type parameter']);
}

$stmt->close();
$connection->close();
?>
