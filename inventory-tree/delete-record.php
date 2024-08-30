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

// Fetch the file path for the given inventory ID
$select_stmt = $connection->prepare("SELECT file_path FROM inventory_images WHERE inventory_id = ?");
$select_stmt->bind_param("i", $inventory_id);
$select_stmt->execute();
$select_stmt->bind_result($file_path);
$select_stmt->fetch();
$select_stmt->close();

if ($file_path) {
    $full_file_path = '../' . $file_path;//get the full path

    if (file_exists($full_file_path)) {
        if (unlink($full_file_path)) {
            $delete_image_stmt = $connection->prepare("DELETE FROM inventory_images WHERE inventory_id = ?");
            $delete_image_stmt->bind_param("i", $inventory_id);

            if ($delete_image_stmt->execute()) {
                $delete_image_stmt->close();
                $inventory_deleted = deleteInventoryRecord($connection, $inventory_id);
                sendResponse($inventory_deleted, $inventory_deleted ? 'Image and inventory record deleted successfully.' : 'Failed to delete inventory record from database.');
            } else {
                $delete_image_stmt->close();
                sendResponse(false, 'Failed to delete image record from database.');
            }
        } else {
            sendResponse(false, 'Failed to delete file from server.');
        }
    } else {
        // No image record found, directly proceed to delete the inventory record
        $inventory_deleted = deleteInventoryRecord($connection, $inventory_id);
        sendResponse($inventory_deleted, $inventory_deleted ? 'Inventory record deleted successfully. No associated image found.' : 'Failed to delete inventory record from database.');
    }
} else {
    // No image record found, directly proceed to delete the inventory record
    $inventory_deleted = deleteInventoryRecord($connection, $inventory_id);
    sendResponse($inventory_deleted, $inventory_deleted ? 'Inventory record deleted successfully. No associated image found.' : 'Failed to delete inventory record from database.');
}

$connection->close();
?>
