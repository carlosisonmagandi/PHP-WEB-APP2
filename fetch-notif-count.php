<?php 

//database connection
require_once("includes/db_connection.php");

// Prepare the query with a parameter
$sql = "SELECT COUNT(*) AS unseen_count FROM pushedNotification WHERE status = ? ORDER BY date_created DESC LIMIT 1";

// Initialize a statement
$stmt = mysqli_stmt_init($connection);

// Prepare the statement
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL statement preparation failed: " . mysqli_stmt_error($stmt));
}

// Define the status parameter
$status = "unseen";

// Bind parameters to the statement
mysqli_stmt_bind_param($stmt, "s", $status);

// Execute the statement
if (!mysqli_stmt_execute($stmt)) {
    die("Statement execution failed: " . mysqli_stmt_error($stmt));
}

// Get the result
$result = mysqli_stmt_get_result($stmt);

// Fetch the row
$row = mysqli_fetch_assoc($result);

// Output the count
echo $row['unseen_count'];


// Close the statement
mysqli_stmt_close($stmt);

// Close connection
mysqli_close($connection);
?>
