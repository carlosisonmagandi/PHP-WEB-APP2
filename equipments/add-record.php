<?php
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");
require_once("../includes/db_connection.php");

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_record') {
    $response = ['status' => 'success'];
    
    // Collect POST data
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
    $category_type='equipment';
    $user_name = $_SESSION['session_username'];

    // Define allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    // Adjust SQL query to match your table schema
    $sql = "INSERT INTO equipments (
        equipment_name,
        equipment_type,
        serial_no,
        brand,
        model,
        equipment_status,
        location,
        date_of_compiscation,
        equipment_owner,
        equipment_condition,
        remarks,
        category_type,
        created_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('sssssssssssss', 
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
        $category_type,
        $user_name
        );

        if ($stmt->execute()) {
            $record_id = $stmt->insert_id;
            $response['record_id'] = $record_id;

            
            $upload_directory = 'Inventory/images/';
            if (!is_dir($upload_directory)) {
                mkdir($upload_directory, 0755, true);
            }

            $invalid_file_found = false;

            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                    $file_name = basename($_FILES['images']['name'][$key]);
                    $file_size = $_FILES['images']['size'][$key];
                    $file_tmp = $_FILES['images']['tmp_name'][$key];
                    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            
                    
                    if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) {
                        $new_file_name = uniqid() . '.' . $file_ext;
                        $upload_path = $upload_directory . $new_file_name;
            
                        if (move_uploaded_file($file_tmp, $upload_path)) {
                            $stmt_image = $connection->prepare("INSERT INTO equipments_images (equipment_id, file_name, file_path) VALUES (?, ?, ?)");
                            if ($stmt_image) {
                                $stmt_image->bind_param('iss', $record_id, $file_name, $upload_path);
                                if (!$stmt_image->execute()) {
                                    $invalid_file_found = true;
                                    $response = ['status' => 'error', 'message' => "Failed to insert file record: " . $stmt_image->error];
                                }
                                $stmt_image->close();
                            } else {
                                $invalid_file_found = true;
                                $response = ['status' => 'error', 'message' => "Failed to prepare file insert statement."];
                            }
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
        } else {
            $response = ['status' => 'error', 'message' => $stmt->error];
        }

        $stmt->close();
    } else {
        $response = ['status' => 'error', 'message' => "Failed to prepare SQL statement."];
    }

    $connection->close();
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or action.']);
}
?>
