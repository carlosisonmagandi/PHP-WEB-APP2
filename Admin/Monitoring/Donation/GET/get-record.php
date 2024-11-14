<?php
require_once("../../../../includes/db_connection.php");

$sql = "
    SELECT 
        request_form.*, 
        CONCAT( 
            '<ul>',
            GROUP_CONCAT(
                CONCAT(
                    '<li><i class=\"fas fa-history\" style=\"color:', 
                    CASE
                        WHEN donation_monitoring.action_description LIKE 'Donation%' THEN '#007bff'
                        WHEN donation_monitoring.action_description LIKE 'Approved%' THEN '#ffc107'
                        WHEN donation_monitoring.action_description LIKE 'Completed%' THEN '#28a745'
                        ELSE 'inherit'
                    END,
                    ';\"></i> ',
                    CASE
                        WHEN donation_monitoring.action_description LIKE 'Donation%' THEN 
                            CONCAT('<span style=\"color:#007bff;\">', donation_monitoring.action_description, '</span>')
                        WHEN donation_monitoring.action_description LIKE 'Approved%' THEN 
                            CONCAT('<span style=\"color:#ffc107;\">', donation_monitoring.action_description, '</span>')
                        WHEN donation_monitoring.action_description LIKE 'Completed%' THEN 
                            CONCAT('<span style=\"color:#28a745;\">', donation_monitoring.action_description, '</span>')
                        ELSE donation_monitoring.action_description
                    END,
                    '</li>'
                ) 
                ORDER BY donation_monitoring.id ASC
            ),
            '</ul>'
        ) AS ACTIONS
    FROM 
        request_form
    LEFT JOIN 
        donation_monitoring ON donation_monitoring.incident_reports_id = request_form.id
    GROUP BY 
        request_form.id
";


$result = $connection->query($sql);

if ($result === false) {
    die("Error executing query: " . $connection->error);
}

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
