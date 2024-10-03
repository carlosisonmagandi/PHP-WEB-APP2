<?php
session_start();
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Read JSON input from POST request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Extract form fields from the JSON data
    $requestorName = isset($data['requestor_name']) ? trim($data['requestor_name']) : '';
    $organization = isset($data['organization']) ? trim($data['organization']) : '';
    $phoneNumber = isset($data['phone_number']) ? trim($data['phone_number']) : '';
    $emailAddress = isset($data['email_address']) ? trim($data['email_address']) : '';
    $address = isset($data['address']) ? trim($data['address']) : '';
    $itemType = isset($data['item_type']) ? trim($data['item_type']) : '';
    $quantityNeeded = isset($data['quantity_needed']) ? (int)$data['quantity_needed'] : 0;
    $itemDescription = isset($data['item_description']) ? trim($data['item_description']) : '';
    $purpose = isset($data['purpose']) ? trim($data['purpose']) : '';
    $deliveryDate = isset($data['delivery_date']) ? trim($data['delivery_date']) : '';
    $deliveryTime = isset($data['delivery_time']) ? trim($data['delivery_time']) : '';
    $deliveryAddress = isset($data['delivery_address']) ? trim($data['delivery_address']) : '';
    $specialInstructions = isset($data['special_instructions']) ? trim($data['special_instructions']) : '';
    $letter_of_intent = isset($data['letter_of_intent']) ? trim($data['letter_of_intent']) : '';
    $project_eng_certification = isset($data['project_eng_certification']) ? trim($data['project_eng_certification']) : '';
    $budget_officer_certification = isset($data['budget_officer_certification']) ? trim($data['budget_officer_certification']) : '';

    $createdBy=$_SESSION['session_username'];
    $approvalStatus='Pending';

    // Validate required fields
    // if (empty($requestorName) || empty($phoneNumber) || empty($emailAddress) || empty($address) || empty($itemType) || empty($quantityNeeded) || empty($itemDescription) || empty($purpose)) {
    //     http_response_code(400);
    //     echo json_encode(array("message" => "All required fields must be filled."));
    //     exit;
    // }

    // Check for connection error
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Insert into the database
    $sql = "INSERT INTO request_form 
            (requestor_name, organization_name, phone_number, email, address, type_of_requested_item, 
            quantity, request_description, purpose_of_donation, preferred_delivery_date, preferred_delivery_time, 
            delivery_address, special_instructions, reason_of_request, previous_donations, additional_comments,created_by,approval_status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssssssssssssssss", 
        $requestorName, $organization, $phoneNumber, $emailAddress, $address, 
        $itemType, $quantityNeeded, $itemDescription, $purpose, $deliveryDate, 
        $deliveryTime, $deliveryAddress, $specialInstructions, $reason, 
        $previousDonations, $additionalComments,$createdBy,$approvalStatus);

    if ($stmt->execute()) {
        http_response_code(201); 
        echo json_encode(array("message" => "Record inserted successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error: " . $stmt->error));
    }

    // Close connection
    $stmt->close();
    $connection->close();

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}

