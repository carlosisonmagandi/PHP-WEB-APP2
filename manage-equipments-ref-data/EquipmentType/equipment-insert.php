<?php
require_once("../../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $equipmentTitle = isset($data['equipmentTitle']) ? trim($data['equipmentTitle']) : '';
    $equipmentDescription = isset($data['equipmentDescription']) ? trim($data['equipmentDescription']) : '';

    // Check if inputs are empty
    if (empty($equipmentTitle) || empty($equipmentDescription)) {
        http_response_code(400);
        echo json_encode(array("message" => "Both fields are required."));
        exit;
    }

    // Check for connection error
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Insert into the database
    $sql = "INSERT INTO equipment_type_ref_data (type_title, type_description) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $equipmentTitle, $equipmentDescription);

    if ($stmt->execute()) {
        http_response_code(201); 
        echo json_encode(array("message" => "Record inserted successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error: " . $stmt->error));
    }

    // Close connection
    $stmt->close();
    $connection->close();

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}
