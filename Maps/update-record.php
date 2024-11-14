<?php
require_once("../includes/db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $inventory_id = isset($data['inventory_id']) ? trim($data['inventory_id']) : 0;
    $longitude = isset($data['longitude']) ? trim($data['longitude']) : '';
    $latitude = isset($data['latitude']) ? trim($data['latitude']) : '';
    $createdBy = $_SESSION['session_username'];
    $updatedBy = $_SESSION['session_username'];


    // Check if inputs are empty
    if (empty($longitude) || empty($latitude)) {
        http_response_code(400);
        echo json_encode(array("message" => "Both fields are required."));
        exit;
    }

    // Check for connection error
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Update the database
    $sql = "UPDATE map_coordinates SET longitude = ?, latitude = ?, created_by = ?, updated_by = ? WHERE inventory_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssi", $longitude, $latitude, $createdBy,$updatedBy, $inventory_id);

    if ($stmt->execute()) {
        http_response_code(200); 
        echo json_encode(array(
            "message" => "Record updated successfully.",
            "longitude" => $longitude,
            "latitude" => $latitude
        ));
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
