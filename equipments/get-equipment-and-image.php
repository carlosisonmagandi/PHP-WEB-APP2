<?php
// Retrieve data from the database
require_once("../includes/db_connection.php");

// Prepare and execute SQL query to fetch data from the inventory table
$sql = "SELECT id,equipment_name,
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
    FROM equipments";

$result = $connection->query($sql);

if (!$result) {
    die('Error in SQL query: ' . $connection->error);
}

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while ($row = $result->fetch_assoc()) {
        // Get the inventory_id for each record
        $equipment_id = $row['id'];

        // Prepare and execute SQL query to fetch file_path
        $sqlGetImage = "SELECT file_path FROM equipments_images WHERE equipment_id = ? LIMIT 1";
        $stmt = $connection->prepare($sqlGetImage);
        if (!$stmt) {
            die('Error in prepare statement: ' . $connection->error);
        }

        $stmt->bind_param("i", $equipment_id);
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
        $stmt->close();
    }
}
$connection->close();
header('Content-Type: application/json');
echo json_encode($data);
?>
