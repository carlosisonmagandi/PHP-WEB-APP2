<?php
require_once("../../includes/db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $vehicleTitle = isset($data['vehicleTitle']) ? trim($data['vehicleTitle']) : '';
    $vehicleDescription = isset($data['vehicleDescription']) ? trim($data['vehicleDescription']) : '';
    $createdBy = isset($_SESSION['session_username']) ? $_SESSION['session_username'] : '';

    // Check if inputs are empty
    if (empty($vehicleTitle) || empty($vehicleDescription)) {
        http_response_code(400);
        echo json_encode(array("message" => "Both fields are required."));
        exit;
    }

    // Check for connection error
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "INSERT INTO vehicle_type_ref_data (type_title, type_description, created_by) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $vehicleTitle, $vehicleDescription,$createdBy);

    if ($stmt->execute()) {
        http_response_code(201); 
        echo json_encode(array("message" => "Record inserted successfully."));
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
