<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $conditionType = isset($data['conditionType']) ? trim($data['conditionType']) : '';//sanitize input data received via a POST request from frontend
    $conditionDescription = isset($data['conditionDescription']) ? trim($data['conditionDescription']) : '';

    if (empty($conditionType) || empty($conditionDescription)) {
        http_response_code(400);
        echo json_encode(array("message" => "Both Condition Type and Description are required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO condition_status_tree (condition_type, condition_description) VALUES (?, ?)";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $conditionType, $conditionDescription);

    if ($stmt->execute()) {
        http_response_code(201); 
        echo json_encode(array("message" => "Record inserted successfully."));
    } else {
        // Return error response
        http_response_code(500); // Internal Server Error
        echo json_encode(array("message" => "Error: " . $stmt->error));
    }

    // Close statement and connection
    $stmt->close();
    $connection->close();

} else {
    // Handle invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}


?>
