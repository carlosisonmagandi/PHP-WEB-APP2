<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $id = isset($data['id']) ? intval($data['id']) : 0;

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid ID parameter."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "DELETE FROM species WHERE id = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        http_response_code(200); // OK
        echo json_encode(array("message" => "Record deleted successfully."));
    } else {
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
