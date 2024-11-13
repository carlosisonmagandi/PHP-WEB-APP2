<?php
require_once("../includes/db_connection.php");

$vehicle_id = $_GET['vehicle_id'];

// Fetch the apprehended item from the inventory table
$vehicle_stmt = $connection->prepare("SELECT 
id,
vehicle_name,
vehicle_type,
plate_no,
brand,
model,
location,
date_of_compiscation,
vehicle_owner,
vehicle_condition,
remarks,
activity_date,
created_on,
created_by,
updated_by,
vehicle_status,
confiscated_by
FROM vehicles WHERE id = ?");
$vehicle_stmt->bind_param("i", $vehicle_id);
$vehicle_stmt->execute();
$vehicle_result = $vehicle_stmt->get_result();
$vehicle = $vehicle_result->fetch_assoc();
$vehicle_stmt->close();

// Fetching image records from inventory_images table
$images_stmt = $connection->prepare("SELECT id, file_name, file_path FROM vehicle_images WHERE vehicle_id = ?");
$images_stmt->bind_param("i", $vehicle_id); // Updated variable to match $vehicle_id
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
    'id' => $vehicle['id'],
    'vehicle_name' => $vehicle['vehicle_name'],
    'vehicle_type' => $vehicle['vehicle_type'],
    'plate_no' => $vehicle['plate_no'],
    'brand' => $vehicle['brand'],
    'model' => $vehicle['model'],
    'location' => $vehicle['location'],
    'date_of_compiscation' => $vehicle['date_of_compiscation'],
    'vehicle_owner' => $vehicle['vehicle_owner'],
    'vehicle_condition' => $vehicle['vehicle_condition'],
    'remarks' => $vehicle['remarks'],
    'activity_date' => $vehicle['activity_date'],
    'created_on' => $vehicle['created_on'],
    'created_by' => $vehicle['created_by'],
    'updated_by' => $vehicle['updated_by'],
    'vehicle_status' => $vehicle['vehicle_status'],
    'confiscated_by' => $vehicle['confiscated_by'],
    'images' => $images
]);
?>
