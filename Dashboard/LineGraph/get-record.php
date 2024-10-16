<?php
require_once("../../includes/db_connection.php");
    
$sql = "SELECT 
    YEAR(date_of_apprehension) AS apprehension_year,
    MONTH(date_of_apprehension) AS apprehension_month,
    COUNT(*) AS apprehension_count
FROM inventory
WHERE species_type = 'Coals' AND YEAR(date_of_apprehension) = YEAR(CURDATE())
GROUP BY apprehension_year, apprehension_month
";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
