<?php
require_once "../../includes/db_connection.php";

// Get the ID parameter from the URL
$id = isset($_GET['id']) ? $_GET['id'] : '';
$buttonValue = isset($_GET['buttonValue']) ? $_GET['buttonValue'] : '';

if  ($buttonValue == 'Approve') {
    // Prepare the SQL update query
    $sql = "UPDATE account SET status = 'active', activity_date = CURRENT_TIMESTAMP WHERE id = ?";
} elseif($buttonValue == 'Deactivate'){
    $sql = "UPDATE account SET status = 'inactive', activity_date = CURRENT_TIMESTAMP WHERE id = ?";
} 

// Prepare and execute the query
$stmt = $connection->prepare($sql);
if (!$stmt) {
    die("Preparation failed: " . $connection->error);
}

$stmt->bind_param('i', $id); // 'i' indicates integer type for the id parameter
$stmt->execute();

// Check for successful update
if ($stmt->affected_rows > 0) {
    // Output the appropriate message along with the ID
    if ($buttonValue == 'Approve') {
         echo "<script>alert('Approved ID: $id' );</script>";
    } elseif ($buttonValue == 'Deactivate') {
        echo "<script>alert('Deactivated ID: $id' );</script>";
    }
} else {
    echo "<script>alert('Failed to update');</script>";
}

// Close statement and connection
$stmt->close();
$connection->close();
?>
