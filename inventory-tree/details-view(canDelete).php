<?php
session_start();
require("../includes/session.php");
require("../includes/authentication.php");
require_once("../includes/db_connection.php");

// Ensure this script is only accessed via AJAX
header('Content-Type: application/json');

$response = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['inventory_id'])) {
    $inventory_id = intval($_GET['inventory_id']);
    $sql = "SELECT id, sitio, barangay, city_municipality, province, apprehending_officer, apprehended_items, EMV_forest_product, EMV_conveyance_implements, involve_personalities, custodian, ACP_status_or_case_no, date_of_confiscation_order, remarks, apprehended_persons FROM inventory WHERE id=$inventory_id";
    
    if ($result = $connection->query($sql)) {
        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            $response['status'] = 'success';
            $response['message'] = 'Data fetched successfully';
            $response['data'] = $data;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No records found';
        }
        $result->free();
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
