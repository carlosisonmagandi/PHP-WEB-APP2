<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $inventoryId = isset($_GET['id']) ? intval($_GET['id']) : 0;

    $stmt = $connection->prepare("SELECT * FROM map_coordinates WHERE inventory_id = ? ORDER BY date_created DESC");

    $stmt->bind_param('i', $inventoryId);

    $stmt->execute();

   
    $result = $stmt->get_result();

    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    $stmt->close();
    $connection->close();

    
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Invalid request method']);
}
?>
