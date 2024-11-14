<?php
require_once("../../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Read JSON input from PUT request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $logsTypeId = isset($data['id']) ? intval($data['id']) : 0;
    $logsTypeTitle = isset($data['logsTypeTitle']) ? trim($data['logsTypeTitle']) : '';
    $logsTypeDescription = isset($data['logsTypeDescription']) ? trim($data['logsTypeDescription']) : '';

    if (empty($logsTypeTitle) || empty($logsTypeDescription) || $logsTypeId === 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Title and Description are required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Update query
    $sql = "UPDATE logs_type_ref_data SET type_title = ?, type_description = ? WHERE id = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $logsTypeTitle, $logsTypeDescription, $logsTypeId);

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
