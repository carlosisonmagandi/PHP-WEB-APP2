<?php
require_once("../includes/db_connection.php");

function deleteVehicleRecord($connection, $vehicle_id) {
    $stmt = $connection->prepare("DELETE FROM vehicles WHERE id = ?");
    $stmt->bind_param("i", $vehicle_id);
    
    $success = $stmt->execute();
    $stmt->close();
    
    return $success;
}

function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if (!isset($_POST['vehicle_id'])) {
    sendResponse(false, 'No vehicle provided.');
}

$vehicle_id = $_POST['vehicle_id'];

$select_stmt = $connection->prepare("SELECT file_path FROM vehicle_images WHERE vehicle_id = ?");
$select_stmt->bind_param("i", $vehicle_id);
$select_stmt->execute();
$select_stmt->store_result(); // Store the result to loop through
$select_stmt->bind_result($file_path);

$files_deleted = true;
while ($select_stmt->fetch()) {
    $full_file_path =$file_path; // Removed the "../"

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
$delete_image_stmt = $connection->prepare("DELETE FROM vehicle_images WHERE vehicle_id = ?");
$delete_image_stmt->bind_param("i", $vehicle_id);
if ($delete_image_stmt->execute()) {
    $delete_image_stmt->close();

    $vehicle_deleted = deleteVehicleRecord($connection, $vehicle_id);
    sendResponse($vehicle_deleted && $files_deleted, $vehicle_deleted ? 'Images and vehicle record deleted successfully.' : 'Failed to delete equipment record from database.');
} else {
    $delete_image_stmt->close();
    sendResponse(false, 'Failed to delete image records from database.');
}

$connection->close();
?>
