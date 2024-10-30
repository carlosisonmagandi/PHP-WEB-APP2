<?php
require_once "../../includes/db_connection.php";

function fetchAccounts($connection) {
    $query = "SELECT id, username, created_on, status, full_name FROM account WHERE role IN (?, ?) ORDER BY created_on DESC";
    $statement = $connection->prepare($query);
    
    $role1 = 'Staff';
    $role2 = 'Field_Staff';
    
    // Bind both roles as parameters
    $statement->bind_param("ss", $role1, $role2);
    $statement->execute();
    
    $result = $statement->get_result();
    $accounts = array();
    
    while ($row = $result->fetch_assoc()) {
        $accounts[] = $row;
    }
    
    $statement->close();
    return $accounts;
}

$accountsData = fetchAccounts($connection);
header('Content-Type: application/json'); 
echo json_encode($accountsData);
