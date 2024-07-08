<?php

require_once("../includes/db_connection.php");

if (isset($_GET['conditionType'])) {
    $conditionType = $_GET['conditionType'];

    $sql = "SELECT COUNT(*) as count FROM condition_status_tree WHERE condition_type = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $conditionType);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $exists = $count > 0 ? true : false;

    echo json_encode(['exists' => $exists]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing conditionType parameter']);
}

$stmt->close();
$connection->close();
?>
