<?php
session_start();
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $request_id = $_POST['request_id'] ?? 0; 
    if ($request_id == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Record ID is required.']);
        exit;
    }

    $upload_directory = 'Uploads/request_documents/';
    if (!is_dir($upload_directory)) {
        mkdir($upload_directory, 0755, true);
    }

    if (isset($_FILES['supporting_documents']) && !empty($_FILES['supporting_documents']['name'][0])) {
        foreach ($_FILES['supporting_documents']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['supporting_documents']['name'][$key]);
            $file_size = $_FILES['supporting_documents']['size'][$key];
            $file_tmp = $_FILES['supporting_documents']['tmp_name'][$key];
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            // Allowed file types
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'pdf', 'xls', 'xlsx', 'csv', 'txt'];

            // Validate file type and size (max 2MB)
            if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) {
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = $upload_directory . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    $stmt_file = $connection->prepare("INSERT INTO request_documents (request_id, file_name, file_path) VALUES (?, ?, ?)");
                    $stmt_file->bind_param('iss', $request_id, $file_name, $upload_path);
                    
                    // If insertion fails, handle the error
                    if (!$stmt_file->execute()) {
                        echo json_encode(['status' => 'error', 'message' => "Failed to insert file record: " . $stmt_file->error]);
                        $stmt_file->close();
                        exit;
                    }
                    $stmt_file->close();
                } else {
                    echo json_encode(['status' => 'error', 'message' => "Failed to upload file: $file_name"]);
                    exit;
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => "Invalid file: $file_name. Allowed types: " . implode(', ', $allowed_types) . ", Max size: 2MB"]);
                exit;
            }
        }

        echo json_encode(['status' => 'success', 'message' => 'Files uploaded successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No files uploaded or file array is empty.']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}
?>
