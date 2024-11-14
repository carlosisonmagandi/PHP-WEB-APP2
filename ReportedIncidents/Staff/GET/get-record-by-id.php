<?php
session_start();
require("../../../includes/session.php");
require("../../../includes/authentication.php");
require_once("../../../includes/db_connection.php");
header('Content-Type: application/json');
$response = [];
$data = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reported_id'])) {
    $id = intval($_GET['reported_id']);
    $stmt = $connection->prepare("SELECT * FROM incident_reports WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response['status'] = 'success';
            $response['message'] = 'Data fetched successfully';
            $response['data'] = $data;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No records found';
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Database query failed';
    }
    $connection->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Inventory ID not provided';
}
echo json_encode($response);
?>
