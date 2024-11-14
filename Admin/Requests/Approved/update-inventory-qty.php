<?php
require_once("../../../includes/db_connection.php");

$data = json_decode(file_get_contents('php://input'), true);

$requestID = $data['requestID'];
$inventoryId = $data['inventoryId'];
$requestFormQuantity = $data['requestFormQuantity'];  

if (isset($requestID) && isset($inventoryId) && isset($requestFormQuantity)) {

    $sql = "UPDATE inventory SET apprehended_quantity = apprehended_quantity - ? WHERE id = ?";

    if ($stmt = $connection->prepare($sql)) {
        $stmt->bind_param("ii", $requestFormQuantity, $inventoryId);
        
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Quantity updated successfully"]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update inventory quantity"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to prepare SQL query"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
}

$connection->close();
?>
