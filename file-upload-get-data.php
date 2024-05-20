<?php
// Retrieve data from the database
require_once("includes/db_connection.php");
    
// Prepare and execute SQL query to fetch data
$sql = "SELECT * FROM testtbl";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close database connection
$connection->close();

// Return data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
