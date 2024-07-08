<?php
require_once("../../includes/db_connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if ($connection->connect_error) {
        http_response_code(500);
        echo json_encode(array("message" => "Database connection failed: " . $connection->connect_error));
        exit;
    }

    // Construct the SQL query to fetch required data
    $sql = "SELECT id, username, role FROM account WHERE status = 'active'";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            // Prepare action buttons HTML
            $roleEditButton = '<button class="btn btn-sm edit-btn" data-id="' . $row['id'] . '"><i class="fas fa-edit"></i></button>';
            $roleDeleteButton = '<button class="btn btn-sm delete-btn" data-id="' . $row['id'] . '"><i class="fas fa-trash-alt"></i></button>';

            // Add row data to $data array
            $data[] = array(
                "id" => $row['id'],
                "username" => $row['username'],
                "role" => $row['role'],
                "actions" => $roleEditButton . ' ' . $roleDeleteButton
            );
        }
        http_response_code(200);
        echo json_encode($data);
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "No records found."));
    }

    $connection->close();

} else {
    // Method not allowed
    http_response_code(405);
    echo json_encode(array("message" => "Method not allowed."));
}
?>
