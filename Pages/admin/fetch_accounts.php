<?php
// Establish a database connection
require_once "../../includes/db_connection.php";

// Function to fetch accounts with role_id of 2
function fetchAccounts($connection) {
    $query = "SELECT id, username, created_on, status FROM account WHERE role = ? ORDER BY created_on DESC";
    $statement = $connection->prepare($query);
    $role = 'Staff'; // Assuming role_id of 2
    $statement->bind_param("s", $role); // Assuming role_id is a string
    $statement->execute();
    $result = $statement->get_result();
    $accounts = array();
    while ($row = $result->fetch_assoc()) {
        $accounts[] = $row;
    }
    $statement->close();
    return $accounts;
}


// Fetch accounts data
$accountsData = fetchAccounts($connection);

// Return accounts data as JSON
header('Content-Type: application/json');
echo json_encode($accountsData);
