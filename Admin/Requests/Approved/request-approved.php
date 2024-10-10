<?php
require_once("../../../includes/db_connection.php");
require ("../../../vendor/autoload.php");

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Read JSON input from PUT request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $requestId = isset($data['id']) ? intval($data['id']) : 0;
    $requestNumber = isset($data['requestNumber']) ? trim($data['requestNumber']) : '';
    $requestee = isset($data['requestee']) ? trim($data['requestee']) : '';
    $office = isset($data['office']) ? trim($data['office']) : '';
    $forestProductType = isset($data['forestProductType']) ? trim($data['forestProductType']) : '';
    $species = isset($data['species']) ? trim($data['species']) : '';
    $requestStatus='Completed';
    $ownerOfRequest = isset($data['ownerOfRequest']) ? trim($data['ownerOfRequest']) : '';
    $dateCreated = isset($data['dateCreated']) ? trim($data['dateCreated']) : '';


    if ( $requestId === 0) {
        http_response_code(400);
        echo json_encode(array("message" => "Title and Description are required."));
        exit;
    }

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Update query
    $sql = "UPDATE request_form SET approval_status = ?  WHERE id = ?";
    
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $requestStatus, $requestId);

    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode(array("message" => "Error: " . $stmt->error));
    } else {
        http_response_code(200);
        // Pusher configuration
        require_once("../../../includes/pusher.php");

        // Struct the data for Pusher
        $dataToSend = array(
            'requestId' => $requestId, 
            'requestNumber' => $requestNumber, 
            'requestee' => $requestee,
            'office' => $office,
            'forestProductType' => $forestProductType,
            'species' => $species,
            'requestStatus' => $requestStatus,
            'ownerOfRequest' => $ownerOfRequest,
            'dateCreated' => $dateCreated
        );
        $pusher->trigger('completed-channel', 'completed-event', $dataToSend);
        
        echo json_encode([]); // Return an empty JSON object on success
    }
    $stmt->close();
    $connection->close();

} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}
