<?php
require_once("../../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $statusTitle = isset($data['statusTitle']) ? trim($data['statusTitle']) : '';
    $statustDescription = isset($data['statustDescription']) ? trim($data['statustDescription']) : '';

    // Check if inputs are empty
    if (empty($statusTitle) || empty($statustDescription)) {
        http_response_code(400);
        echo json_encode(array("message" => "Both fields are required."));
        exit;
    }

    // Check for connection error
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Insert into the database
    $sql = "INSERT INTO equipment_status_ref_data (status_title, status_description) VALUES (?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $statusTitle, $statustDescription);

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
