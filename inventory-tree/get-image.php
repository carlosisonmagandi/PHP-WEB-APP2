<?php
// Retrieve data from the database
require_once("../includes/db_connection.php");

// Prepare and execute SQL query to fetch data from the inventory table
$sql = "SELECT id,
    date_of_apprehension,
    sitio,
    barangay,
    city_municipality,
    province,
    apprehending_officer,
    apprehended_items,
    apprehended_quantity, 
    apprehended_volume, 
    apprehended_vehicle, 
    apprehended_vehicle_type, 
    apprehended_vehicle_plate_no,
    EMV_forest_product,
    EMV_conveyance_implements,
    involve_personalities,
    custodian,
    ACP_status_or_case_no,
    date_of_confiscation_order,
    remarks,
    apprehended_persons,
    date_created,
    depository_sitio,
    depository_barangay,
    depository_city,
    depository_province,
    linear_mtrs
    FROM inventory";

$result = $connection->query($sql);

if (!$result) {
    die('Error in SQL query: ' . $connection->error);
}

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while ($row = $result->fetch_assoc()) {
        // Get the inventory_id for each record
        $inventory_id = $row['id'];

        // Prepare and execute SQL query to fetch file_path
        $sqlGetImage = "SELECT file_path FROM inventory_images WHERE inventory_id = ? LIMIT 1";
        $stmt = $connection->prepare($sqlGetImage);
        if (!$stmt) {
            die('Error in prepare statement: ' . $connection->error);
        }

        $stmt->bind_param("i", $inventory_id);
        $stmt->execute();
        $imageResult = $stmt->get_result();

        if (!$imageResult) {
            die('Error in getting result: ' . $stmt->error);
        }

        // Add file_path to the row if it exists, otherwise set to null
        if ($imageResult->num_rows > 0) {
            $imageRow = $imageResult->fetch_assoc();
            $row['file_path'] = $imageRow['file_path'];
        } else {
            $row['file_path'] = null; // Ensure file_path is always set
        }

        // Append the row to the data array
        $data[] = $row;

        // Close the statement
        $stmt->close();
    }
}

// Close database connection
$connection->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
