<?php
session_start();
require("../../../includes/session.php");
require("../../../includes/authentication.php");
require_once("../../../includes/db_connection.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents("php://input");
    $data = json_decode($jsonData, true);
    
    if ($data === null) {
        $response = [
            'status' => 'error',
            'message' => 'Invalid JSON data received.'
        ];
        echo json_encode($response);
        exit;
    }

    $state = $data['state'] ?? '';
    $assignedTo = $data['assignedTo'] ?? '';
    $isAccepted = 'Pending';
    $reportedBy = $data['reportedBy'] ?? '';
    $location = $data['location'] ?? '';
    $illegal_activity_detail = $data['details'] ?? '';
    $coordinate_lat = $data['coordinate_lat'] ?? '';
    $coordinate_lng = $data['coordinate_lng'] ?? '';
    
    $date_assigned = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['session_username'];
    
    $report_number = generateUniqueReportNumber($connection);
    $assigned_by = $_SESSION['session_username'];
    $date_reported = $data['date_reported'] ?? '';  
    $created_by = $_SESSION['session_username'];

    $stmt = $connection->prepare("INSERT INTO incident_reports (
        state, assigned_to, isAccepted, reported_by, location, illegal_activity_detail, date_assigned,
        updated_by, coordinate_lat, coordinate_lng, report_number, assigned_by, date_reported, created_by
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt === false) {
        file_put_contents('php://stderr', "Prepare failed: " . $connection->error . "\n");
    }

    $stmt->bind_param('ssssssssssssss', 
        $state, $assignedTo, $isAccepted, $reportedBy, $location, $illegal_activity_detail, $date_assigned,
        $updated_by, $coordinate_lat, $coordinate_lng, $report_number, $assigned_by, $date_reported, $created_by
    );

    if ($stmt->execute()) {
        $incident_reports_id = $stmt->insert_id; // Get the last inserted ID

        // Insert into incident_report_monitoring table
        $action_description = 'New report ticket created';
        $created_by_monitoring = $_SESSION['session_username'];
        $updated_by_monitoring = $_SESSION['session_username'];

        $monitoring_stmt = $connection->prepare("INSERT INTO incident_report_monitoring (inc_reports_id, action_description, created_by, updated_by) VALUES (?, ?, ?, ?)");
        if ($monitoring_stmt === false) {
            file_put_contents('php://stderr', "Prepare failed for monitoring: " . $connection->error . "\n");
        }

        $monitoring_stmt->bind_param('isss', $incident_reports_id, $action_description, $created_by_monitoring, $updated_by_monitoring);

        if ($monitoring_stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Record inserted successfully',
                'data' => [
                    'state' => $state,
                    'assignedTo' => $assignedTo,
                    'isAccepted' => $isAccepted,
                    'reportedBy' => $reportedBy,
                    'location' => $location,
                    'details' => $illegal_activity_detail,
                    'date_assigned' => $date_assigned,
                    'updated_by' => $updated_by,
                    'coordinate_lat' => $coordinate_lat,
                    'coordinate_lng' => $coordinate_lng,
                    'report_number' => $report_number,
                    'assigned_by' => $assigned_by,
                    'date_reported' => $date_reported,
                    'created_by' => $created_by,
                    'incident_reports_id' => $incident_reports_id
                ]
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error inserting record into incident_report_monitoring: ' . $monitoring_stmt->error
            ];
        }

        $monitoring_stmt->close();
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error inserting record into incident_reports: ' . $stmt->error
        ];
    }

    $stmt->close();
    $connection->close();
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request method'
    ];
}

echo json_encode($response);

function generateUniqueReportNumber($connection) {
    $unique = false;
    $report_number = '';

    while (!$unique) {
        $random_number = rand(10000000, 99999999);
        $report_number = 'REP' . $random_number;

        $query = "SELECT COUNT(*) FROM incident_reports WHERE report_number = ?";
        $stmt = $connection->prepare($query);
        $stmt->bind_param('s', $report_number);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();

        if ($count == 0) {
            $unique = true;
        }

        $stmt->close();
    }

    return $report_number;
}
?>
