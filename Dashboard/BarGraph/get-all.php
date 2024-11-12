<?php
require_once("../../includes/db_connection.php");
    
$sql = "SELECT  
    YEAR(date_of_completion) AS completion_year,
     MONTH(date_of_completion) AS completion_month,
    COUNT(*) AS donation_count
FROM request_form
WHERE approval_status='Completed' AND YEAR(date_of_completion) = YEAR(CURDATE())
GROUP BY completion_year,completion_month ORDER BY completion_month ASC 
";

// sample output
// completion_year    completion_month         donation_count
// 2024	                 10	                     2
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
