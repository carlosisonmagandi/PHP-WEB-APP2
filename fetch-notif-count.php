<?php 
require_once("includes/db_connection.php");

$sql = "SELECT COUNT(*) AS unseen_count FROM pushedNotification WHERE status = ? ORDER BY date_created DESC LIMIT 1";
$stmt = mysqli_stmt_init($connection);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL statement preparation failed: " . mysqli_stmt_error($stmt));
}

// Define the status parameter
$status = "unseen";

mysqli_stmt_bind_param($stmt, "s", $status);

if (!mysqli_stmt_execute($stmt)) {
    die("Statement execution failed: " . mysqli_stmt_error($stmt));
}
$result = mysqli_stmt_get_result($stmt);

$row = mysqli_fetch_assoc($result);

echo $row['unseen_count'];

mysqli_stmt_close($stmt);
mysqli_close($connection);
?>
