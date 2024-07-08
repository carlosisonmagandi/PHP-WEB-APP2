<?php

require_once("../includes/db_connection.php");

if (isset($_GET['speciesName'])) {
    $speciesName = $_GET['speciesName'];

    $sql = "SELECT COUNT(*) as count FROM species WHERE species_name = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $speciesName);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $exists = $count > 0 ? true : false;

    echo json_encode(['exists' => $exists]);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Missing speciesName parameter']);
}

$stmt->close();
$connection->close();
?>
