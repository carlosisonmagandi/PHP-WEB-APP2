<?php
require_once("includes/db_connection.php");

$sql = "SELECT id,
    date_of_apprehension,
    sitio,
    barangay,
    city_municipality,
    province,
    apprehending_officer,
    apprehended_items,
    EMV_forest_product,
    EMV_conveyance_implements,
    involve_personalities,
    custodian,
    ACP_status_or_case_no,
    date_of_confiscation_order,
    remarks,
    apprehended_persons,
    date_created,
    species_status
   FROM inventory WHERE species_status='Confiscated' ORDER BY id";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Fetch data from the result set
    while($row = $result->fetch_assoc()) {
        //to redirect to another page 
        // $row['id'] = '<a href="some_page.php?id=' . $row['id'] . '">' . $row['id'] . '</a>';

        //clickable id
        $row['id'] = '<a class="clickable-id">' . $row['id'] . '</a>';
        $data[] = $row;
    }
}
$connection->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
