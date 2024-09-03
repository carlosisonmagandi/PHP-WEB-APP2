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
    $date_of_apprehension = $_POST['date_of_apprehension'] ?? '';
    $sitio = $_POST['sitio'] ?? '';
    $barangay = $_POST['barangay'] ?? '';
    $city_municipality = $_POST['city_municipality'] ?? '';
    $province = $_POST['province'] ?? '';
    $apprehending_officer = $_POST['apprehending_officer'] ?? '';
    $apprehended_items = $_POST['apprehended_items'] ?? '';
    $EMV_forest_product = $_POST['EMV_forest_product'] ?? '';
    $EMV_conveyance_implements = $_POST['EMV_conveyance_implements'] ?? '';
    $involve_personalities = $_POST['involve_personalities'] ?? '';
    $custodian = $_POST['custodian'] ?? '';
    $ACP_status_or_case_no = $_POST['ACP_status_or_case_no'] ?? '';
    $date_of_confiscation_order = $_POST['date_of_confiscation_order'] ?? '';
    $remarks = $_POST['remarks'] ?? '';
    $apprehended_persons = $_POST['apprehended_persons'] ?? '';
    $apprehended_quantity = $_POST['apprehended_quantity'] ?? '';
    $apprehended_volume = $_POST['apprehended_volume'] ?? '';
    $apprehended_vehicle = $_POST['apprehended_vehicle'] ?? '';
    $apprehended_vehicle_type = $_POST['apprehended_vehicle_type'] ?? '';
    $apprehended_vehicle_plate_no = $_POST['apprehended_vehicle_plate_no'] ?? '';
    $date_created = date('Y-m-d');

    // Define allowed file types
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];

    // Adjust SQL query to match your table schema
    $sql = "INSERT INTO inventory (
        date_of_apprehension, sitio, barangay, city_municipality, province, apprehending_officer, 
        apprehended_items, EMV_forest_product, EMV_conveyance_implements, involve_personalities, 
        custodian, ACP_status_or_case_no, date_of_confiscation_order, remarks, apprehended_persons,
        apprehended_quantity, apprehended_volume, apprehended_vehicle, apprehended_vehicle_type,
        apprehended_vehicle_plate_no, date_created
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param('sssssssssssssssdsssss', 
            $date_of_apprehension, 
            $sitio, 
            $barangay, 
            $city_municipality, 
            $province, 
            $apprehending_officer, 
            $apprehended_items, 
            $EMV_forest_product, 
            $EMV_conveyance_implements, 
            $involve_personalities, 
            $custodian, 
            $ACP_status_or_case_no, 
            $date_of_confiscation_order, 
            $remarks, 
            $apprehended_persons, 
            $apprehended_quantity, 
            $apprehended_volume, 
            $apprehended_vehicle, 
            $apprehended_vehicle_type, 
            $apprehended_vehicle_plate_no, 
            $date_created
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

                        $upload_path_with_prefix = 'inventory-tree/' . $upload_path;
            
                        if (move_uploaded_file($file_tmp, $upload_path)) {
                            $stmt_image = $connection->prepare("INSERT INTO inventory_images (inventory_id, file_name, file_path, date_created) VALUES (?, ?, ?, ?)");
                            if ($stmt_image) {
                                $stmt_image->bind_param('isss', $record_id, $file_name, $upload_path_with_prefix, $date_created);
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
