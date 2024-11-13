<?php 
require_once("includes/db_connection.php");

$sql = "SELECT * FROM pushedNotification ORDER BY date_created DESC, time_created DESC;";
$stmt = mysqli_stmt_init($connection);

if (!mysqli_stmt_prepare($stmt, $sql)) {
    die("SQL statement preparation failed: " . mysqli_stmt_error($stmt));
}

if (!mysqli_stmt_execute($stmt)) {
    die("Statement execution failed: " . mysqli_stmt_error($stmt));
}

$result = mysqli_stmt_get_result($stmt);

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$json_data = json_encode($data);

echo $json_data;
mysqli_stmt_close($stmt);

mysqli_close($connection);
?>
