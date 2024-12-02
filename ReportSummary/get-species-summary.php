<?php
require_once("../includes/db_connection.php");

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';  
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';  

$sql = "SELECT species_type, COUNT(*) AS type_count, SUM(EMV_forest_product) AS total_value
        FROM inventory";

if ($startDate && $endDate) {
    // $sql .= " WHERE DATE_FORMAT(date_created, '%Y-%m') BETWEEN '$startDate' AND '$endDate'";
    $sql .= " WHERE DATE_FORMAT(date_of_apprehension, '%Y-%m') BETWEEN '$startDate' AND '$endDate'";
}

$sql .= " GROUP BY species_type";

$result = $connection->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Format value as currency with commas and no decimal places
        $total_value = number_format($row['total_value'], 0, '.', ','); 
        
        $data[] = array(
            'species_type' => $row['species_type'],
            'type_count' => $row['type_count'],
            'total_value' => $total_value 
        );
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>  
