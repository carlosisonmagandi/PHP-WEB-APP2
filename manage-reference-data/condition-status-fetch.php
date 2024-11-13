<!-- unused PHP file -->

<?php
require_once("../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id === 0) {
        http_response_code(400);
        echo json_encode(array("message" => "ID parameter is required."));
        exit;
    }

    if ($connection->connect_error) {
        http_response_code(500);
        echo json_encode(array("message" => "Database connection failed: " . $connection->connect_error));
        exit;
    }
    $sql = "SELECT condition_type, condition_description FROM condition_status_tree WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($conditionType, $conditionDescription);

    if ($stmt->fetch()) {
        $data = array(
            "conditionType" => $conditionType,
            "conditionDescription" => $conditionDescription
        );
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "Record not found."));
    }

    $stmt->close();
    $connection->close();

} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
