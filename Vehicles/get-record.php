<?php
// Retrieve data from the database
require_once("../includes/db_connection.php");
    
// Prepare and execute SQL query to fetch data
$sql = "SELECT * FROM vehicles";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while($row = $result->fetch_assoc()) {
        $row['id'] = '<a class="clickable-vehicle-id">' . $row['id'] . '</a>';
        $data[] = $row;
    }
}

// Close database connection
$connection->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
