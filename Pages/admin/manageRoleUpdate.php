<?php
require_once "../../includes/db_connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accountId = isset($_POST['accountId']) ? intval($_POST['accountId']) : 0;
    $newRole = isset($_POST['newRole']) ? $_POST['newRole'] : '';

    // Ensure that the new role is valid: Admin, Staff, or Field Staff
    if ($accountId === 0 || !in_array($newRole, ['Admin', 'Staff', 'Field_Staff'])) {
        http_response_code(400);
        echo json_encode(array("message" => "Invalid data received."));
        exit;
    }

    // Update the role in the database
    $sql = "UPDATE account SET role = ? WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("si", $newRole, $accountId);

    if ($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array("message" => "Role updated successfully."));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Error updating role: " . $stmt->error));
    }
    $stmt->close();
    $connection->close();
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("message" => "Method not allowed."));
}
?>
