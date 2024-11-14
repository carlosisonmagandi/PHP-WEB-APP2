<?php
require_once("../../../../includes/db_connection.php");

$sql = "
    SELECT 
        incident_reports.*, 
        CONCAT( 
            '<ul>',
            GROUP_CONCAT(
                CONCAT(
                    '<li><i class=\"fas fa-history\" style=\"color:', 
                    CASE
                        WHEN incident_report_monitoring.action_description LIKE 'New%' THEN '#007bff'
                        WHEN incident_report_monitoring.action_description LIKE 'Accepted%' THEN '#ffc107'
                        WHEN incident_report_monitoring.action_description LIKE 'Completed%' THEN '#28a745'
                        ELSE 'inherit'
                    END,
                    ';\"></i> ',
                    CASE
                        WHEN incident_report_monitoring.action_description LIKE 'New%' THEN 
                            CONCAT('<span style=\"color:#007bff;\">', incident_report_monitoring.action_description, '</span>')
                        WHEN incident_report_monitoring.action_description LIKE 'Accepted%' THEN 
                            CONCAT('<span style=\"color:#ffc107;\">', incident_report_monitoring.action_description, '</span>')
                        WHEN incident_report_monitoring.action_description LIKE 'Completed%' THEN 
                            CONCAT('<span style=\"color:#28a745;\">', incident_report_monitoring.action_description, '</span>')
                        ELSE incident_report_monitoring.action_description
                    END,
                    '</li>'
                ) 
                ORDER BY incident_report_monitoring.id ASC
            ),
            '</ul>'
        ) AS ACTIONS
    FROM 
        incident_reports
    LEFT JOIN 
        incident_report_monitoring ON incident_report_monitoring.inc_reports_id = incident_reports.id
    GROUP BY 
        incident_reports.id
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
