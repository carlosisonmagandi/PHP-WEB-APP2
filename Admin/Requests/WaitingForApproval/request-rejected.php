<?php
require_once("../../../includes/db_connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $requestId = isset($_POST['requestId']) ? intval($_POST['requestId']) : 0;
    $rejectionReason = isset($_POST['reason']) ? trim($_POST['reason']) : '';
    $rejected_By = $_SESSION['session_username'];

    if (empty($rejectionReason)) {
        http_response_code(400);
        echo json_encode(array("message" => "Reason for rejection is required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "INSERT INTO admin_donation_rejected_req (request_id, reject_reason, rejected_by) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("iss", $requestId, $rejectionReason, $rejected_By);

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
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
