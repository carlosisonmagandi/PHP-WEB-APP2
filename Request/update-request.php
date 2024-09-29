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

    // Fetch and sanitize input
    $request_id = intval($_POST['request_id']);
    if ($request_id > 0) {
        $requestorName = $_POST['requestor_name'] ?? '';
        $organization = $_POST['organization'] ?? '';
        $phoneNumber = $_POST['phone_number'] ?? '';
        $emailAddress = $_POST['email_address'] ?? '';
        $address = $_POST['address'] ?? '';
        $quantityNeeded = $_POST['quantity_needed'] ?? '';
        $itemDescription = $_POST['item_description'] ?? '';
        $purpose = $_POST['purpose'] ?? '';
        $deliveryDate = $_POST['delivery_date'] ?? '';
        $deliveryTime = $_POST['delivery_time'] ?? '';
        $deliveryAddress = $_POST['delivery_address'] ?? '';
        $specialInstructions = $_POST['special_instructions'] ?? '';
        $reason = $_POST['reason'] ?? '';
        $previousDonations = $_POST['previous_donations'] ?? '';
        $additionalComments = $_POST['additional_comments'] ?? '';

        $item_type=$_POST['item_type'] ?? '';
        $item_name=$_POST['item_name'] ?? '';

        $stmt = $connection->prepare("UPDATE request_form SET 
            requestor_name=?,
            organization_name=?,
            phone_number=?, 
            email=?, 
            address=?, 
            quantity=?, 
            request_description=?, 
            purpose_of_donation=?, 
            preferred_delivery_date=?, 
            preferred_delivery_time=?, 
            delivery_address=?, 
            special_instructions=?, 
            reason_of_request=?, 
            previous_donations=?, 
            additional_comments=?,
            type_of_requested_item=?,
            name_of_requested_item=?
            WHERE id=?");
            //type_of_requested_item

        if ($stmt === false) {
            file_put_contents('php://stderr', "Prepare failed: " . $connection->error . "\n");
        }

        $stmt->bind_param('sssssssssssssssssi',
            $requestorName, 
            $organization, 
            $phoneNumber, 
            $emailAddress, 
            $address, 
            $quantityNeeded, 
            $itemDescription, 
            $purpose, 
            $deliveryDate, 
            $deliveryTime, 
            $deliveryAddress, 
            $specialInstructions, 
            $reason, 
            $previousDonations, 
            $additionalComments,
            $item_type, 
            $item_name,
            $request_id
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
        $response['message'] = 'Invalid or missing request ID';
    }

    $connection->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
