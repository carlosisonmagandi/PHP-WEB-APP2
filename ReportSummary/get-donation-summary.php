<?php
require_once("../includes/db_connection.php");

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';  
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';  

$sql = "SELECT type_of_requested_item, COUNT(*) AS total_count, SUM(quantity) AS total_quantity
        FROM request_form
        WHERE approval_status = 'Completed'";

if ($startDate && $endDate) {
    $sql .= " AND DATE_FORMAT(created_on, '%Y-%m') BETWEEN '$startDate' AND '$endDate'";
}

$sql .= " GROUP BY type_of_requested_item";

$result = $connection->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Format quantity as number with commas (if necessary)
        $total_quantity = number_format($row['total_quantity'], 0, '.', ',');

        $data[] = array(
            'type_of_requested_item' => $row['type_of_requested_item'],
            'total_count' => $row['total_count'],
            'total_quantity' => $total_quantity 
        );
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
