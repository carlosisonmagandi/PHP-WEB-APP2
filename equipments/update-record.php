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

    $equipment_id = intval($_POST['equipment_id']);
    if ($equipment_id > 0) {
        // Fetch and sanitize input
        $equipmentName = $_POST['equipmentName'] ?? '';
        $type = $_POST['equipment_type'] ?? '';
        $serialNo = $_POST['serialNo'] ?? '';
        $brand = $_POST['brand'] ?? '';
        $model = $_POST['model'] ?? '';
        $condition = $_POST['condition'] ?? '';
        $owner = $_POST['owner'] ?? '';
        $dateOfConfiscation = $_POST['dateOfConfiscation'] ?? '';
        $status = $_POST['status'] ?? '';
        $location = $_POST['location'] ?? '';
        $remarks = $_POST['remarks'] ?? '';
        $user_name = $_SESSION['session_username'];
       

        $stmt = $connection->prepare("UPDATE equipments SET 
            equipment_name=?,
            equipment_type=?,
            serial_no=?, 
            brand=?, 
            model=?,
            equipment_status=?,
            location=?,
            date_of_compiscation=?,
            equipment_owner=?,
            equipment_condition=?,
            remarks=?,
            updated_by=?
            WHERE id=?");

        if ($stmt === false) {
            file_put_contents('php://stderr', "Prepare failed: " . $connection->error . "\n");
        }

        $stmt->bind_param('ssssssssssssi',
            $equipmentName, 
            $type, 
            $serialNo, 
            $brand, 
            $model,
            $status,
            $location,
            $dateOfConfiscation,
            $owner,
            $condition,
            $remarks,
            $user_name,
            $equipment_id
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
