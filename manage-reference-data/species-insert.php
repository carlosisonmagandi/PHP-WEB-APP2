<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $speciesName = isset($data['speciesName']) ? trim($data['speciesName']) : '';//sanitize input data received via a POST request from frontend
    $speciesDescription = isset($data['speciesDescription']) ? trim($data['speciesDescription']) : '';

    if (empty($speciesName) || empty($speciesDescription)) {
        http_response_code(400);
        echo json_encode(array("message" => "Both Condition Type and Description are required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO species (species_name, species_description) VALUES (?, ?)";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $speciesName, $speciesDescription);

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


?>
