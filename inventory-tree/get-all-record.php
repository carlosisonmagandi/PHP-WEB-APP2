<?php
session_start();
require("../includes/session.php");
require("../includes/authentication.php");
require_once("../includes/db_connection.php");

// Ensure this script is only accessed via AJAX
header('Content-Type: application/json');

$response = [];
$data = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Prepare the SQL statement to prevent SQL injection
    $stmt = $connection->prepare("SELECT * FROM inventory ORDER BY date_created");

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Fetch all rows and store them in an array
        while ($row = $result->fetch_assoc()) {
            $data[] = $row; // Append each row to the data array
        }

        if (!empty($data)) {
            $response['status'] = 'success';
            $response['message'] = 'Data fetched successfully';
            $response['data'] = $data; // Return the array of all records
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
    $response['message'] = 'Invalid request method';
}

echo json_encode($response);
?>
