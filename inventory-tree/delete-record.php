<?php
require_once("../includes/db_connection.php");

function deleteInventoryRecord($connection, $inventory_id) {
    $stmt = $connection->prepare("DELETE FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $inventory_id);
    
    $success = $stmt->execute();
    $stmt->close();
    
    return $success;
}

function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if (!isset($_POST['inventory_id'])) {
    sendResponse(false, 'No inventory ID provided.');
}

$inventory_id = $_POST['inventory_id'];

$select_stmt = $connection->prepare("SELECT file_path FROM inventory_images WHERE inventory_id = ?");
$select_stmt->bind_param("i", $inventory_id);
$select_stmt->execute();
$select_stmt->store_result(); // Store the result to loop through
$select_stmt->bind_result($file_path);

$files_deleted = true;
while ($select_stmt->fetch()) {
    $full_file_path = '../' . $file_path; // Get the full path

    if (file_exists($full_file_path)) {
        if (!unlink($full_file_path)) {
            $files_deleted = false;
            sendResponse(false, "Failed to delete file: $full_file_path from server.");
        }
    } else {
        $files_deleted = false;
        sendResponse(false, "File does not exist: $full_file_path.");
    }
}
$select_stmt->close();

// Delete all image records from inventory_images table
$delete_image_stmt = $connection->prepare("DELETE FROM inventory_images WHERE inventory_id = ?");
$delete_image_stmt->bind_param("i", $inventory_id);
if ($delete_image_stmt->execute()) {
    $delete_image_stmt->close();

    $inventory_deleted = deleteInventoryRecord($connection, $inventory_id);
    sendResponse($inventory_deleted && $files_deleted, $inventory_deleted ? 'Images and inventory record deleted successfully.' : 'Failed to delete inventory record from database.');
} else {
    $delete_image_stmt->close();
    sendResponse(false, 'Failed to delete image records from database.');
}

$connection->close();
?>
