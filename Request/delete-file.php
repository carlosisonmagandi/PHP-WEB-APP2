<?php
session_start();
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'] ?? 0;

    if ($request_id == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Record ID is required.']);
        exit;
    }

    $stmt = $connection->prepare("SELECT file_path FROM request_documents WHERE id = ?");
    $stmt->bind_param('i', $request_id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $file_path = $row['file_path'];

                if (file_exists($file_path)) {
                    if (!unlink($file_path)) {
                        echo json_encode(['status' => 'error', 'message' => "Failed to delete file: $file_path"]);
                        exit;
                    }
                } else {
                    echo json_encode(['status' => 'error', 'message' => "File not found: $file_path"]);
                    exit;
                }
            }

            $stmt_delete = $connection->prepare("DELETE FROM request_documents WHERE id = ?");
            $stmt_delete->bind_param('i', $request_id);
            
            if ($stmt_delete->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Files and records deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to delete file records from the database.']);
            }

            $stmt_delete->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No files found for the given request ID.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch files from the database.']);
    }
} else {
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
