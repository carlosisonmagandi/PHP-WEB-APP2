<?php
session_start();
require("../includes/session.php");
require("../includes/authentication.php");
require_once("../includes/db_connection.php");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure this script is only accessed via POST
header('Content-Type: application/json');

// Initialize response array
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debug: Check if the POST data is being received
    file_put_contents('php://stderr', print_r($_POST, TRUE));

    $vehicle_id = intval($_POST['vehicle_id']);
    if ($vehicle_id > 0) {
        // Fetch and sanitize input
        $plate_no = $_POST['plate_no'] ?? '';
        $brand = $_POST['brand'] ?? '';
        $vehicle_type = $_POST['vehicle_type'] ?? '';
        $vehicle_name = $_POST['vehicle_name'] ?? '';
        $model = $_POST['model'] ?? '';
        $vehicle_condition = $_POST['vehicle_condition'] ?? '';
        $vehicle_status = $_POST['vehicle_status'] ?? '';
        $location = $_POST['location'] ?? '';
        $vehicle_owner = $_POST['vehicle_owner'] ?? '';
        $date_of_compiscation = $_POST['date_of_compiscation'] ?? '';
        $confiscated_by = $_POST['confiscated_by'] ?? '';
        $remarks = $_POST['remarks'] ?? '';

        $user_name = $_SESSION['session_username'];

        $stmt = $connection->prepare("UPDATE vehicles SET 
            plate_no=?, 
            brand=?, 
            vehicle_type=?, 
            vehicle_name=?, 
            model=?, 
            vehicle_condition=?, 
            vehicle_status=?, 
            location=?, 
            vehicle_owner=?, 
            date_of_compiscation=?, 
            confiscated_by=?, 
            remarks=?, 
            updated_by=?
            WHERE id=?");

        if ($stmt === false) {
            file_put_contents('php://stderr', "Prepare failed: " . $connection->error . "\n");
        }

        $stmt->bind_param('sssssssssssssi', 
            $plate_no, 
            $brand, 
            $vehicle_type, 
            $vehicle_name, 
            $model, 
            $vehicle_condition, 
            $vehicle_status, 
            $location, 
            $vehicle_owner, 
            $date_of_compiscation, 
            $confiscated_by, 
            $remarks, 
            $user_name, 
            $vehicle_id
        );

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Record updated successfully';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error updating record: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Invalid or missing inventory ID';
    }

    $connection->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
