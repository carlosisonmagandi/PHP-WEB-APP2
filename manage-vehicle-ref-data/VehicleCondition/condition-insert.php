<?php
require_once("../../includes/db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $conditionTitle = isset($data['conditionTitle']) ? trim($data['conditionTitle']) : '';
    $conditionDescription = isset($data['conditionDescription']) ? trim($data['conditionDescription']) : '';
    $createdBy = isset($_SESSION['session_username']) ? $_SESSION['session_username'] : '';

    // Check if inputs are empty
    if (empty($conditionTitle) || empty($conditionDescription)) {
        http_response_code(400);
        echo json_encode(array("message" => "Both fields are required."));
        exit;
    }

    // Check for connection error
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Insert into the database
    $sql = "INSERT INTO vehicle_condition_ref_data (condition_title, condition_description, created_by) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sss", $conditionTitle, $conditionDescription, $createdBy);

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
