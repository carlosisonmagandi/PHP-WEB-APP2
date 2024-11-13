<?php
session_start();
require("../includes/session.php");
require("../includes/authentication.php");
require_once("../includes/db_connection.php");

header('Content-Type: application/json');

$response = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $connection->prepare("SELECT * FROM equipments ORDER BY created_on");

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $data[] = $row; 
        }

        if (!empty($data)) {
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
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
