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
    
    file_put_contents('php://stderr', print_r($_POST, TRUE));

    $id=$_POST['id'] ?? '';
    $state = $_POST['state'] ?? '';
    $assignedTo = $_POST['assignedTo'] ?? '';
    $isAccepted = $_POST['isAccepted'] ?? '';
    $reportedBy = $_POST['reportedBy'] ?? '';
    $location = $_POST['location'] ?? '';
    $illegal_activity_detail = $_POST['details'] ?? '';
    
    $date_assigned = date('Y-m-d H:i:s');
    $updated_by = $_SESSION['session_username'];
    $coordinate_lat = $_POST['coordinate_lat'] ?? '';
    $coordinate_lng = $_POST['coordinate_lng'] ?? '';
    
    $stmt = $connection->prepare("UPDATE incident_reports SET 
        state=?,
        assigned_to=?,
        isAccepted=?,
        reported_by=?,
        location=?,
        illegal_activity_detail=?,
        date_assigned=?,
        updated_by=?,
        coordinate_lat=?,
        coordinate_lng=?
        WHERE id=?");
    if ($stmt === false) {
        file_put_contents('php://stderr', "Prepare failed: " . $connection->error . "\n");
    }
    $stmt->bind_param('ssssssssssi',
        $state,
        $assignedTo,
        $isAccepted,
        $reportedBy,
        $location,
        $illegal_activity_detail,
        $date_assigned,
        $updated_by,
        $coordinate_lat,
        $coordinate_lng,
        $id
    );
    if ($stmt->execute()) {
        $response = [
            'status' => 'success',
            'message' => 'Record updated successfully',
            'data' => [
                'id' => $id,
                'state' => $state,
                'assignedTo' => $assignedTo,
                'isAccepted' => $isAccepted,
                'reportedBy' => $reportedBy,
                'location' => $location,
                'details' => $illegal_activity_detail,
                'date_assigned' => $date_assigned,
                'updated_by' => $updated_by,
                'coordinate_lat' => $coordinate_lat,
                'coordinate_lng' => $coordinate_lng
            ]
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Error updating record: ' . $stmt->error
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
?>
