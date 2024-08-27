<?php
require_once "../../includes/db_connection.php";

$id = isset($_GET['id']) ? $_GET['id'] : '';//id parameter
$buttonValue = isset($_GET['buttonValue']) ? $_GET['buttonValue'] : '';

if  ($buttonValue == 'Approve') {
    $sql = "UPDATE account SET status = 'active', activity_date = CURRENT_TIMESTAMP WHERE id = ?";
} elseif($buttonValue == 'Deactivate'){
    $sql = "UPDATE account SET status = 'inactive', activity_date = CURRENT_TIMESTAMP WHERE id = ?";
} 
$stmt = $connection->prepare($sql);
if (!$stmt) {
    die("Preparation failed: " . $connection->error);
}

$stmt->bind_param('i', $id); // 'i' indicates integer type for the id parameter
$stmt->execute();

if ($stmt->affected_rows > 0) {// Check for successful update
    if ($buttonValue == 'Approve') {
         echo "<script>alert('Approved ID: $id' );</script>";
    } elseif ($buttonValue == 'Deactivate') {
        echo "<script>alert('Deactivated ID: $id' );</script>";
    }
} else {
    echo "<script>alert('Failed to update');</script>";
}
$stmt->close();
$connection->close();
?>
