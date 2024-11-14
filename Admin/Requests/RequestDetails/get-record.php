<?php
require_once("../../../includes/db_connection.php");

// Retrieve the 'id' from the URL query string
$requestId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($requestId > 0) {
    $sql = "SELECT * FROM request_form WHERE id = ? ORDER BY created_on DESC";
    $stmt = $connection->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $requestId);

        $stmt->execute();

        $result = $stmt->get_result();
        
        $data = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $stmt->close();
    } else {
        die("Error preparing statement: " . $connection->error);
    }

    $connection->close();

    // Return the result as a JSON response
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    // If no valid id is provided, return an error response
    header('Content-Type: application/json');
    echo json_encode(array("error" => "Invalid request ID"));
}
?>
