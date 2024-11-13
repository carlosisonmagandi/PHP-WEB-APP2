<?php
require_once("../includes/db_connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $requestId = isset($_GET['requestId']) ? intval($_GET['requestId']) : 0;

    if ($connection->connect_error) {
        die(json_encode(array("message" => "Connection failed: " . $connection->connect_error)));
    }

    $sql = "SELECT * FROM request_form WHERE id = ? ORDER BY created_on DESC";
    $stmt = $connection->prepare($sql);

    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(array("message" => "Prepare statement failed: " . $connection->error));
        exit;
    }

    $stmt->bind_param("i", $requestId); // "i" denotes the parameter is an integer

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
           
            $row = $result->fetch_assoc();
            http_response_code(200);
            echo json_encode($row);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "No record found for the given ID."));
        }

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
