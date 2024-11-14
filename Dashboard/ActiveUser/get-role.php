<?php
require_once("../../includes/db_connection.php");
    
$sql = "SELECT 
    (SELECT COUNT(*) FROM account WHERE role = 'Admin' and status='active') AS role_admin,
    (SELECT COUNT(*) FROM account WHERE role = 'Staff' and status='active') AS role_staff,
    (SELECT COUNT(*) FROM account WHERE role = 'Field_Staff' and status='active') AS role_field_staff
";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
