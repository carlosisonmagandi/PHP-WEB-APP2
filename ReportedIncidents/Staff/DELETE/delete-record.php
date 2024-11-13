<?php
session_start();
require("../../../includes/session.php");
require("../../../includes/authentication.php");
require_once("../../../includes/db_connection.php");
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $inputData = json_decode(file_get_contents('php://input'), true);
    if (isset($inputData['id'])) {
        $id = intval($inputData['id']); 

        $stmt = $connection->prepare("DELETE FROM incident_reports WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $response['status'] = 'success';
                $response['message'] = 'Record deleted successfully';
            } else {
                $response['status'] = 'error';
                $response['message'] = 'No records found to delete';
            }
            $stmt->close();
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Database query failed';
        }
        $connection->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Reported ID not provided';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}
echo json_encode($response);
?>
