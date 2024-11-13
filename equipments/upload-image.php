<?php
session_start();
require("../includes/session.php");
require("../includes/authentication.php");
require_once("../includes/db_connection.php");

header('Content-Type: application/json');

// Check if the request method is POST and action is 'upload_image'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'upload_img') {

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $upload_directory = 'Inventory/images/';
    $response = ['status' => 'success'];

    // Create the upload directory if it doesn't exist
    if (!is_dir($upload_directory)) {
        mkdir($upload_directory, 0755, true);
    }

    // Check if record_id is valid
    $record_id = intval($_POST['record_id']);
    if ($record_id <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid record ID.']);
        exit();
    }

    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $invalid_file_found = false;

        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['images']['name'][$key]);
            $file_size = $_FILES['images']['size'][$key];
            $file_tmp = $_FILES['images']['tmp_name'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) {
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = $upload_directory . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $stmt_image = $connection->prepare("INSERT INTO equipments_images (equipment_id, file_name, file_path, date_created) VALUES (?, ?, ?, ?)");
                    if ($stmt_image) {
                        $date_created = date('Y-m-d');
                        $stmt_image->bind_param('isss', $record_id, $file_name, $upload_path, $date_created);
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

        if (!$invalid_file_found) {
            $response['status'] = 'success';
        }
    } else {
        $response = ['status' => 'error', 'message' => 'No files uploaded or file array is empty.'];
    }

    $connection->close();
    echo json_encode($response);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method or action.']);
}
?>
