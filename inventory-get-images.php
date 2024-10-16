<?php
require_once("includes/db_connection.php");

$inventory_id = $_GET['inventory_id'];

$inventory_stmt = $connection->prepare("SELECT 
    apprehended_items, 
    date_of_apprehension, 
    sitio, 
    barangay, 
    city_municipality, 
    province, 
    apprehending_officer, 
    EMV_forest_product, 
    EMV_conveyance_implements, 
    involve_personalities, 
    custodian, 
    ACP_status_or_case_no, 
    date_of_confiscation_order, 
    remarks, 
    apprehended_persons, 
    apprehended_quantity, 
    apprehended_volume, 
    apprehended_vehicle, 
    apprehended_vehicle_type, 
    apprehended_vehicle_plate_no, 
    depository_sitio,
    depository_barangay, 
    depository_city, 
    depository_province,
    linear_mtrs,
    species_status,
    species_type
    FROM inventory WHERE id = ?");
$inventory_stmt->bind_param("i", $inventory_id);
$inventory_stmt->execute();
$inventory_result = $inventory_stmt->get_result();
$inventory = $inventory_result->fetch_assoc();
$inventory_stmt->close();

// Extracting the part of apprehended_items before the first comma so it will fetch only the title from apprehended_items column
$apprehended_item_full = $inventory['apprehended_items'];
$apprehended_item_parts = explode(',', $apprehended_item_full);
$apprehended_item = $apprehended_item_parts[0];

// Fetching image records from inventory_images table
$images_stmt = $connection->prepare("SELECT id, file_name, file_path FROM inventory_images WHERE inventory_id = ?");
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
    'date_of_apprehension' => $inventory['date_of_apprehension'],
    'sitio' => $inventory['sitio'],
    'barangay' => $inventory['barangay'],
    'city_municipality' => $inventory['city_municipality'],
    'province' => $inventory['province'],
    'apprehending_officer' => $inventory['apprehending_officer'],
    'EMV_forest_product' => $inventory['EMV_forest_product'],
    'EMV_conveyance_implements' => $inventory['EMV_conveyance_implements'],
    'involve_personalities' => $inventory['involve_personalities'],
    'custodian' => $inventory['custodian'],
    'ACP_status_or_case_no' => $inventory['ACP_status_or_case_no'],
    'date_of_confiscation_order' => $inventory['date_of_confiscation_order'],
    'remarks' => $inventory['remarks'],
    'apprehended_persons' => $inventory['apprehended_persons'],
    'apprehended_quantity' => $inventory['apprehended_quantity'],
    'apprehended_volume' => $inventory['apprehended_volume'],
    'apprehended_vehicle' => $inventory['apprehended_vehicle'],
    'apprehended_vehicle_type' => $inventory['apprehended_vehicle_type'],
    'apprehended_vehicle_plate_no' => $inventory['apprehended_vehicle_plate_no'],

    'depository_sitio' => $inventory['depository_sitio'],
    'depository_barangay' => $inventory['depository_barangay'],
    'depository_city' => $inventory['depository_city'],
    'depository_province' => $inventory['depository_province'],
    'linear_mtrs' => $inventory['linear_mtrs'],
    'species_type' => $inventory['species_type'],
    
    'images' => $images
]);
?>
