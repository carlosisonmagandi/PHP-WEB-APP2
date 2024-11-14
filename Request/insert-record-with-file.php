<?php
session_start();
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $requestorName = $_POST['requestor_name'] ?? '';
    $organization = $_POST['organization'] ?? '';
    $phoneNumber = $_POST['phone_number'] ?? '';
    $emailAddress = $_POST['email_address'] ?? '';
    $address = $_POST['address'] ?? '';
    $itemType = $_POST['item_type'] ?? '';
    $quantityNeeded = $_POST['quantity_needed'] ?? 0;
    $itemDescription = $_POST['item_description'] ?? '';
    $purpose = $_POST['purpose'] ?? '';
    $deliveryDate = $_POST['delivery_date'] ?? '';
    $deliveryTime = $_POST['delivery_time'] ?? '';
    $deliveryAddress = $_POST['delivery_address'] ?? '';
    $specialInstructions = $_POST['special_instructions'] ?? '';
    $letter_of_intent = $_POST['letter_of_intent'] ?? '';
    $project_eng_certification = $_POST['project_eng_certification'] ?? '';
    $budget_officer_certification = $_POST['budget_officer_certification'] ?? '';

    $item_name_input = $_POST['item_name_input'] ?? '';
    $item_id = $_POST['item_id'] ?? '';

    $createdBy = $_SESSION['session_username'];
    $approvalStatus = 'Pending for Approval';

    // $lastInsertId = $connection->query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name='request_form' AND table_schema = DATABASE();");
    // $row = $lastInsertId->fetch_assoc();
    // $nextId = $row['AUTO_INCREMENT'];

    $randomNumber = random_int(100000000, 999999999);
    $requestNumber = 'RE' . str_pad($randomNumber, 9, '0', STR_PAD_LEFT);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "INSERT INTO request_form (item_id,name_of_requested_item, request_number,requestor_name, organization_name, phone_number, email, address, type_of_requested_item, quantity, request_description, purpose_of_donation, preferred_delivery_date, preferred_delivery_time, delivery_address, special_instructions, letter_of_intent, project_eng_certification, budget_officer_certification, created_by, approval_status) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("issssssssssssssssssss",$item_id, $item_name_input, $requestNumber, $requestorName, $organization, $phoneNumber, $emailAddress, $address, $itemType, $quantityNeeded, $itemDescription, $purpose, $deliveryDate, $deliveryTime, $deliveryAddress, $specialInstructions, $letter_of_intent, $project_eng_certification, $budget_officer_certification, $createdBy, $approvalStatus);

    if ($stmt->execute()) {
        $record_id = $stmt->insert_id;

        $incident_reports_id = $record_id;
        $action_description = 'Donation request Created';
        $updated_by = $createdBy;

        $query = "INSERT INTO donation_monitoring (incident_reports_id, action_description, created_by, updated_by) 
                  VALUES (?, ?, ?, ?)";
        
        if ($stmt_monitoring = $connection->prepare($query)) {
            $stmt_monitoring->bind_param("isss", $incident_reports_id, $action_description, $createdBy, $updated_by);

            if ($stmt_monitoring->execute()) {
                $response = ['status' => 'success', 'message' => 'Donation request and monitoring record inserted successfully.', 'record_id' => $record_id];
            } else {
                $response = ['status' => 'error', 'message' => 'Error inserting record into donation_monitoring: ' . $stmt_monitoring->error];
            }
            $stmt_monitoring->close();
        } else {
            $response = ['status' => 'error', 'message' => 'Error preparing the donation_monitoring query: ' . $connection->error];
        }

        $upload_directory = 'Uploads/request_documents/';
        if (!is_dir($upload_directory)) {
            mkdir($upload_directory, 0755, true);
        }

        if (isset($_FILES['supporting_documents'])) {
            foreach ($_FILES['supporting_documents']['tmp_name'] as $key => $tmp_name) {
                $file_name = basename($_FILES['supporting_documents']['name'][$key]);
                $file_tmp = $_FILES['supporting_documents']['tmp_name'][$key];
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
                $allowed_types = array_merge(
                    ['jpg', 'jpeg', 'png', 'gif'], 
                    ['doc', 'docx', 'pdf', 'xls', 'xlsx', 'csv', 'txt']
                );
        
                $invalid_file_found = false;

                if (isset($_FILES['supporting_documents']) && !empty($_FILES['supporting_documents']['name'][0])) {
                    foreach ($_FILES['supporting_documents']['tmp_name'] as $key => $tmp_name) {
                        $file_name = basename($_FILES['supporting_documents']['name'][$key]);
                        $file_size = $_FILES['supporting_documents']['size'][$key];
                        $file_tmp = $_FILES['supporting_documents']['tmp_name'][$key];
                        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                
                        if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) {
                            $new_file_name = uniqid() . '.' . $file_ext;
                            $upload_path = $upload_directory . $new_file_name;
                
                            if (move_uploaded_file($file_tmp, $upload_path)) {
                                $stmt_file = $connection->prepare("INSERT INTO request_documents (request_id, file_name, file_path) VALUES (?, ?, ?)");
                                $stmt_file->bind_param('iss', $record_id, $file_name, $upload_path);
                                if (!$stmt_file->execute()) {
                                    $invalid_file_found = true;
                                    $response = ['status' => 'error', 'message' => "Failed to insert file record: " . $stmt_file->error];
                                }
                                $stmt_file->close();
                            } else {
                                $invalid_file_found = true;
                                $response = ['status' => 'error', 'message' => "Failed to upload file: $file_name"];
                            }
                        } else {
                            $invalid_file_found = true;
                            $response = ['status' => 'error', 'message' => "Invalid file: $file_name"];
                        }
                    }
                } else {
                    $response = ['status' => 'error', 'message' => 'No files uploaded or file array is empty.'];
                }

                if (!$invalid_file_found) {
                    $response['status'] = 'success';
                }
            }
        }

        echo json_encode($response);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error inserting record into request_form: ' . $stmt->error]);
    }

    $stmt->close();
    $connection->close();
} else {
    http_response_code(405); 
    echo json_encode(array("message" => "Method not allowed."));
}
?>
