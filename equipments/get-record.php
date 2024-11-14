<?php
// Retrieve data from the database
require_once("../includes/db_connection.php");
    
// Prepare and execute SQL query to fetch data
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

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while($row = $result->fetch_assoc()) {
        $row['id'] = '<a class="clickable-id">' . $row['id'] . '</a>';
        $data[] = $row;
    }
}

// Close database connection
$connection->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
