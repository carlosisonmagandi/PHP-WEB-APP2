<?php
session_start();
require("../../../includes/session.php");
require("../../../includes/authentication.php");
require_once("../../../includes/db_connection.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    
    $input = file_get_contents('php://input');
    
    $data = json_decode($input, true);  // True converts to an associative array
    
    $id = $data['id'] ?? '';
    if (!$id) {
        $response = [
            'status' => 'error',
            'message' => 'ID is missing from request'
        ];
        echo json_encode($response);
        exit;
    }

    $isAccepted = 'Accepted';
    
    // Prepare the SQL statement
    $stmt = $connection->prepare("UPDATE incident_reports SET isAccepted=? WHERE id=?");
    if ($stmt === false) {
        file_put_contents('php://stderr', "Prepare failed: " . $connection->error . "\n");
    }
    
    $stmt->bind_param('si', $isAccepted, $id);
    
    if ($stmt->execute()) {
        $response = [
            'status' => 'success',
            'message' => 'Record updated successfully',
            'data' => [
                'id' => $id,
                'isAccepted' => $isAccepted,
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
