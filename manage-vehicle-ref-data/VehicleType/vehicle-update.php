<?php
require_once("../../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Read JSON input from PUT request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $vehicleId = isset($data['id']) ? intval($data['id']) : 0;
    $vehicleTitle = isset($data['vehicleTitle']) ? trim($data['vehicleTitle']) : '';
    $vehicleDescription = isset($data['vehicleDescription']) ? trim($data['vehicleDescription']) : '';

    if (empty($vehicleTitle) || empty($vehicleDescription) || $vehicleId === 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Title and Description are required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Update query
    $sql = "UPDATE vehicle_type_ref_data SET type_title = ?, type_description = ? WHERE id = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $vehicleTitle, $vehicleDescription, $vehicleId);

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(array("message" => "Error: " . $stmt->error));
    } else {
        http_response_code(200);
        echo json_encode([]); // Return an empty JSON object on success
    }
    $stmt->close();
    $connection->close();

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}
