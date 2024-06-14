<?php
require_once("includes/db_connection.php");

$inventory_id = $_GET['inventory_id'];

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
echo json_encode($images);
?>
