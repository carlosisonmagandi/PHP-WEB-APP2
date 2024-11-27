<?php
require_once("../includes/db_connection.php");

$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';  
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';        

$sql = "SELECT city_municipality, COUNT(*) AS activity_count 
        FROM inventory";

if ($startDate && $endDate) {
    $sql .= " WHERE DATE_FORMAT(date_created, '%Y-%m') BETWEEN '$startDate' AND '$endDate'";
}

$sql .= " GROUP BY city_municipality";

$result = $connection->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = array(
            'city_municipality' => $row['city_municipality'],
            'activity_count' => $row['activity_count']
        );
    }
}
$connection->close();
header('Content-Type: application/json');
echo json_encode($data);
?>
