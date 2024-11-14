<?php
session_start();
require("../../../includes/session.php");
require("../../../includes/authentication.php");
require_once("../../../includes/db_connection.php");
header('Content-Type: application/json');
$response = [];
$data = [];
$userName = $_SESSION['session_username'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $connection->prepare("SELECT * FROM incident_reports WHERE assigned_to = (SELECT full_name from account where username=?)");
    $stmt->bind_param("s", $userName);  
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row; 
            }
            $response['status'] = 'success';
            $response['message'] = 'Data fetched successfully';
            $response['data'] = $data;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No records found';
        }
        $stmt->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Database query failed';
    }
    $connection->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Inventory ID not provided';  // You can remove this message now
}

echo json_encode($response);
?>
