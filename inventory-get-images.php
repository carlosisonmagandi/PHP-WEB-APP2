<?php
require_once("includes/db_connection.php");

$inventory_id = $_GET['inventory_id'];

// Fetch the apprehended item from the inventory table
$inventory_stmt = $connection->prepare("SELECT apprehended_items FROM inventory WHERE id = ?");
$inventory_stmt->bind_param("i", $inventory_id);
$inventory_stmt->execute();
$inventory_result = $inventory_stmt->get_result();
$inventory = $inventory_result->fetch_assoc();
$inventory_stmt->close();

// Extracting the part of apprehended_items before the first comma so it will fetch only the title from apprehended_items column
$apprehended_item_full = $inventory['apprehended_items'];
$apprehended_item_parts = explode(',', $apprehended_item_full);
$apprehended_item = $apprehended_item_parts[0];

//fetching imag record from inventory_table
$images_stmt = $connection->prepare("SELECT file_name, file_path FROM inventory_images WHERE inventory_id = ?");
$images_stmt->bind_param("i", $inventory_id);
$images_stmt->execute();
$images_result = $images_stmt->get_result();

$images = [];
while ($row = $images_result->fetch_assoc()) {
    $images[] = $row;
}
$images_stmt->close();
$connection->close();

header('Content-Type: application/json');
echo json_encode([
    'apprehended_items' => $apprehended_item,
    'images' => $images
]);
?>
