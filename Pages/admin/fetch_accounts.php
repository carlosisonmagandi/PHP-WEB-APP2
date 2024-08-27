<?php
require_once "../../includes/db_connection.php";
function fetchAccounts($connection) {
    $query = "SELECT id, username, created_on, status FROM account WHERE role = ? ORDER BY created_on DESC";
    $statement = $connection->prepare($query);
    $role = 'Staff'; 
    $statement->bind_param("s", $role);
    $statement->execute();
    $result = $statement->get_result();
    $accounts = array();
    while ($row = $result->fetch_assoc()) {
        $accounts[] = $row;
    }
    $statement->close();
    return $accounts;
}
$accountsData = fetchAccounts($connection);// Fetch accounts data
header('Content-Type: application/json');// Return accounts data as JSON
echo json_encode($accountsData);
