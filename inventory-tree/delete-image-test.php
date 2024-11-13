<?php
require_once("../includes/db_connection.php");

// Check if image_id is provided
if (!isset($_POST['image_id'])) {
    echo json_encode(['success' => false, 'message' => 'No image ID provided.']);
    exit;
}

$image_id = $_POST['image_id'];

// Prepare and execute the delete statement
$delete_stmt = $connection->prepare("DELETE FROM inventory_images WHERE id = ?");
$delete_stmt->bind_param("i", $image_id);

if ($delete_stmt->execute()) {
    $delete_stmt->close();
    $connection->close();
    echo json_encode(['success' => true, 'message' => 'Image deleted successfully.']);
} else {
    $delete_stmt->close();
    $connection->close();
    echo json_encode(['success' => false, 'message' => 'Failed to delete image.']);
}
?>
