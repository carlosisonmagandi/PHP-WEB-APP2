<?php
// Get the JSON data from the request body
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

//database connection
require_once("includes/db_connection.php");

// Prepare and bind SQL statement
$stmt = $connection->prepare("INSERT INTO testtbl (Car, Truck, Jeepney) VALUES (?, ?, ?)");

// Bind parameters and execute the statement for each row in the JSON data
foreach ($data as $row) {
    $stmt->bind_param("sss", $car, $truck, $jeepney);
    $car = $row['Car'];
    $truck = $row['Truck'];
    $jeepney = $row['Jeepney'];
    $stmt->execute();
}

// Close statement and database connection
$stmt->close();
$connection->close();
echo "<script>alert('Data inserted successfully.');</script>";
?>
