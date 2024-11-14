<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Read JSON input from PUT request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $conditionId = isset($data['id']) ? intval($data['id']) : 0;
    $conditionType = isset($data['conditionType']) ? trim($data['conditionType']) : '';
    $conditionDescription = isset($data['conditionDescription']) ? trim($data['conditionDescription']) : '';

    if (empty($conditionType) || empty($conditionDescription) || $conditionId === 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Condition ID, Type, and Description are required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Update query
    $sql = "UPDATE condition_status_tree SET condition_type = ?, condition_description = ?, activity_date = CURDATE() WHERE id = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $conditionType, $conditionDescription, $conditionId);

    if ($stmt->execute()) {
        http_response_code(200); 
        // echo json_encode(array("message" => "Record updated successfully."));
        echo json_encode(array("message" => "Record updated successfully.".$conditionType));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error: " . $stmt->error));
    }

    $stmt->close();
    $connection->close();

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}

?>
