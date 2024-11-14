<?php
require_once("../includes/db_connection.php");

if (!isset($_POST['image_id'])) {// Check if image_id is provided
    echo json_encode(['success' => false, 'message' => 'No image ID provided.']);
    exit;
}

$image_id = $_POST['image_id'];

$select_stmt = $connection->prepare("SELECT file_path FROM equipments_images WHERE id = ?");//Select file_path value from inventory_images
$select_stmt->bind_param("i", $image_id);
$select_stmt->execute();
$select_stmt->bind_result($file_path);
$select_stmt->fetch();
$select_stmt->close();

if ($file_path) {
    // Construct the full path to the image file
    $full_file_path = '../' . 'equipments/'. $file_path;

    if (file_exists($full_file_path)) {// Remove the file from the server
        if (unlink($full_file_path)) {
            // Proceed to delete the record from the database if the file was successfully deleted
            $delete_stmt = $connection->prepare("DELETE FROM equipments_images WHERE id = ?");
            $delete_stmt->bind_param("i", $image_id);

            if ($delete_stmt->execute()) {
                $delete_stmt->close();
                $connection->close();
                echo json_encode(['success' => true, 'message' => 'Image and record deleted successfully.']);
            } else {
                $delete_stmt->close();
                $connection->close();
                echo json_encode(['success' => false, 'message' => 'Failed to delete image record from database.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete file from server.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'File does not exist.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Image record not found.']);
}
?>
