<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Read JSON input from PUT request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $speciesId = isset($data['id']) ? intval($data['id']) : 0;
    $speciesName = isset($data['speciesName']) ? trim($data['speciesName']) : '';
    $speciesDescription = isset($data['speciesDescription']) ? trim($data['speciesDescription']) : '';

    if (empty($speciesName) || empty($speciesDescription) || $speciesId === 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Condition ID, Type, and Description are required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Update query
    $sql = "UPDATE species SET species_name = ?, species_description = ?, activity_date = CURDATE() WHERE id = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssi", $speciesName, $speciesDescription, $speciesId);

    if ($stmt->execute()) {
        http_response_code(200); 
        echo json_encode(array("message" => "Record updated successfully.".$speciesName));
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
