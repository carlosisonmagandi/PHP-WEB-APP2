<?php
require_once("../../../includes/db_connection.php");
require ("../../../vendor/autoload.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $requestId = isset($data['requestId']) ? intval($data['requestId']) : 0;
    $updatedBy = isset($_SESSION['session_username']) ? $_SESSION['session_username'] : null;
    
    $requestStatus = 'Rejected';

    if ($requestId === 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid request ID."));
        exit;
    }

    if ($connection->connect_error) {
        http_response_code(500);
        echo json_encode(array("message" => "Connection failed: " . $connection->connect_error));
        exit;
    }

    $sql = "UPDATE request_form SET approval_status = ?, updated_by = ? WHERE id = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("ssi", $requestStatus, $updatedBy, $requestId);

        if ($stmt->execute()) {
           //Push the event
           require_once("../../../includes/pusher.php");

            $pusher->trigger('rejected-channel', 'rejected-event', []);

            // Return success response
            http_response_code(200);
            echo json_encode(array("message" => "Status updated and event triggered successfully."));
        } else {
            http_response_code(500);
            echo json_encode(array("message" => "Error: " . $stmt->error));
        }

        $stmt->close();
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to prepare the statement."));
    }

    $connection->close();

} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
