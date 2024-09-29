
<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Fetch files associated with the request ID
    $stmt = $connection->prepare("SELECT * FROM request_documents WHERE request_id = ?");
    $stmt->bind_param('i', $request_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $files = array();
    while ($row = $result->fetch_assoc()) {
        $files[] = $row;
    }

    echo json_encode(['status' => 'success', 'files' => $files]);

    $stmt->close();
    $connection->close();
} else {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed.']);
}
