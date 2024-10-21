<?php
require_once("../../../includes/db_connection.php");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$sql = "SELECT * FROM request_form WHERE approval_status='Completed' AND id = ? ORDER BY created_on DESC";

$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id); 

$stmt->execute();
$result = $stmt->get_result();

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $response = [
        'status' => 'success',
        'data' => $data
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'No record found'
    ];
}

$stmt->close();
$connection->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
