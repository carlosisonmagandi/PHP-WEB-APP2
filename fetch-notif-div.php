<?php 

//database connection
require_once("includes/db_connection.php");

// Prepare the query
$sql = "SELECT * FROM pushedNotification ORDER BY date_created,time_created DESC";

// Initialize a statement
$stmt = mysqli_stmt_init($connection);

// Prepare the statement
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL statement preparation failed: " . mysqli_stmt_error($stmt));
}

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    die("Statement execution failed: " . mysqli_stmt_error($stmt));
}

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Fetch data from the result and store it in the array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Convert the array to JSON
$json_data = json_encode($data);

// Output the JSON
echo $json_data;
// Close the statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($connection);
?>
