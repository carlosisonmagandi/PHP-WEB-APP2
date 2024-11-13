<?php
session_start();
require("../includes/session.php");
require("../includes/authentication.php");
require_once("../includes/db_connection.php");

// Ensure this script is only accessed via AJAX
header('Content-Type: application/json');

$response = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['image_id'])) {
    // Validate and sanitize the input
    $image_id = intval($_GET['image_id']);

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $connection->prepare("SELECT file_path FROM inventory_images WHERE id = ? ");
    $stmt->bind_param("i", $image_id);

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
