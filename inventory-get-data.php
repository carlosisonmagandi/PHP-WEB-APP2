<?php
// Retrieve data from the database
require_once("includes/db_connection.php");
    
// Prepare and execute SQL query to fetch data
$sql = "SELECT * FROM inventory";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while($row = $result->fetch_assoc()) {
        //to redirect to another page 
        // $row['id'] = '<a href="some_page.php?id=' . $row['id'] . '">' . $row['id'] . '</a>';

        //clickable id
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
