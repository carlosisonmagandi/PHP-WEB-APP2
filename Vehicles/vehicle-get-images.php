<?php
require_once("../includes/db_connection.php");

$equipment_id = $_GET['equipment_id'];

// Fetch the apprehended item from the inventory table
$equipment_stmt = $connection->prepare("SELECT id,equipment_name,
    equipment_type,
    serial_no,
    brand,
    model,
    equipment_status,
    location,
    date_of_compiscation,
    equipment_owner,
    equipment_condition,
    remarks,
    created_on
    FROM equipments WHERE id = ?");
$equipment_stmt->bind_param("i", $equipment_id);
$equipment_stmt->execute();
$equipment_result = $equipment_stmt->get_result();
$equipment = $equipment_result->fetch_assoc();
$equipment_stmt->close();


// Fetching image records from inventory_images table
$images_stmt = $connection->prepare("SELECT id, file_name, file_path FROM equipments_images WHERE equipment_id = ?");
$images_stmt->bind_param("i", $equipment_id);
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
    'equipment_name' => $equipment['equipment_name'],
    'equipment_type' => $equipment['equipment_type'],
    'serial_no' => $equipment['serial_no'],
    'brand' => $equipment['brand'],
    'model' => $equipment['model'],
    'equipment_status' => $equipment['equipment_status'],
    'location' => $equipment['location'],
    'date_of_compiscation' => $equipment['date_of_compiscation'],
    'equipment_owner' => $equipment['equipment_owner'],
    'equipment_condition' => $equipment['equipment_condition'],
    'remarks' => $equipment['remarks'],
    'created_on' => $equipment['created_on'],

    'images' => $images
]);
?>
