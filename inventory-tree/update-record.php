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

    $inventory_id = intval($_POST['inventory_id']);
    if ($inventory_id > 0) {
        // Fetch and sanitize input
        $sitio = $_POST['sitio'] ?? '';
        $barangay = $_POST['barangay'] ?? '';
        $city_municipality = $_POST['city_municipality'] ?? '';
        $province = $_POST['province'] ?? '';
        $date_of_apprehension = $_POST['date_of_apprehension'] ?? '';
        $apprehending_officer = $_POST['apprehending_officer'] ?? '';
        $apprehended_items = $_POST['apprehended_items'] ?? '';
        $apprehended_quantity = !empty($_POST['apprehended_quantity']) ? intval($_POST['apprehended_quantity']) : 0;
        // $apprehended_volume = !empty($_POST['apprehended_volume']) ? floatval($_POST['apprehended_volume']) : 0.0;
        $apprehended_volume = $_POST['apprehended_volume'] ?? '';
        $apprehended_vehicle = $_POST['apprehended_vehicle'] ?? '';
        $apprehended_vehicle_type = $_POST['apprehended_vehicle_type'] ?? '';
        $apprehended_vehicle_plate_no = $_POST['apprehended_vehicle_plate_no'] ?? '';
        $EMV_forest_product = $_POST['EMV_forest_product'] ?? '';
        $EMV_conveyance_implements = $_POST['EMV_conveyance_implements'] ?? '';
        $involve_personalities = $_POST['involve_personalities'] ?? '';
        $custodian = $_POST['custodian'] ?? '';
        $ACP_status_or_case_no = $_POST['ACP_status_or_case_no'] ?? '';
        $date_of_confiscation_order = $_POST['date_of_confiscation_order'] ?? '';
        $remarks = $_POST['remarks'] ?? '';
        // $apprehended_persons = $_POST['apprehended_persons'] ?? '';

        $depository_sitio = $_POST['depository_sitio'] ?? '';
        $depository_barangay = $_POST['depository_barangay'] ?? '';
        $depository_city = $_POST['depository_city'] ?? '';
        $depository_province = $_POST['depository_province'] ?? '';

        $user_name = $_SESSION['session_username'];
        $linear_mtrs =  $_POST['linear_mtrs'] ?? '';

        $species_type =  $_POST['species_type'] ?? '';
        $species_status =  $_POST['species_status'] ?? '';

        $stmt = $connection->prepare("UPDATE inventory SET
            sitio=?, 
            barangay=?, 
            city_municipality=?, 
            province=?, 
            date_of_apprehension=?, 
            apprehending_officer=?, 
            apprehended_items=?, 
            apprehended_quantity=?, 
            apprehended_volume=?, 
            apprehended_vehicle=?, 
            apprehended_vehicle_type=?, 
            apprehended_vehicle_plate_no=?, 
            EMV_forest_product=?, 
            EMV_conveyance_implements=?, 
            involve_personalities=?, 
            custodian=?, 
            ACP_status_or_case_no=?, 
            date_of_confiscation_order=?, 
            remarks=?, 
            -- apprehended_persons=?,
            update_by=?,
            depository_sitio=?,
            depository_barangay=?,
            depository_city=?,
            depository_province=?,
            linear_mtrs=?,
            species_type=?,
            species_status=?
            WHERE id=?");

        if ($stmt === false) {
            file_put_contents('php://stderr', "Prepare failed: " . $connection->error . "\n");
        }

        $stmt->bind_param('sssssssssssssssssssssssssssi',
            $sitio, 
            $barangay, 
            $city_municipality, 
            $province, 
            $date_of_apprehension,
            $apprehending_officer, 
            $apprehended_items, 
            $apprehended_quantity, 
            $apprehended_volume,
            $apprehended_vehicle, 
            $apprehended_vehicle_type, 
            $apprehended_vehicle_plate_no,
            $EMV_forest_product, 
            $EMV_conveyance_implements, 
            $involve_personalities,
            $custodian, 
            $ACP_status_or_case_no, 
            $date_of_confiscation_order,
            $remarks, 
            // $apprehended_persons,
            $user_name, 
            $depository_sitio,
            $depository_barangay,
            $depository_city,
            $depository_province,
            $linear_mtrs,
            $species_type,
            $species_status,
            $inventory_id
            
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
