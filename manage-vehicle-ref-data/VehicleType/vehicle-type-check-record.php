<?php
require_once("../../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $vehicleTitle = isset($_GET['vehicleTitle']) ? trim($_GET['vehicleTitle']) : '';

    if (empty($vehicleTitle)) {
        http_response_code(400);
        echo json_encode(array("message" => "Vehicle title is required."));
        exit;
    }

    $sql = "SELECT COUNT(*) as count FROM vehicle_type_ref_data WHERE type_title = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $vehicleTitle);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    $stmt->close();
    $connection->close();

    // Return the check result as JSON
    echo json_encode(array("exists" => $count > 0));
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
