<?php
//
//Do not modify this, this is use by AJAX inserting record of excel file
// Get the JSON data from the request body
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

//database connection
require_once("includes/db_connection.php");

// Prepare and bind SQL statement
$stmt = $connection->prepare("INSERT INTO inventory (
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
    apprehended_persons
    ) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

// Bind parameters and execute the statement for each row in the JSON data
foreach ($data as $row) {
    // Parse date strings into desired format
    $v_date_of_apprehension = date('Y-m-d', strtotime($row['date_of_apprehension']));
    $v_date_of_confiscation_order = date('Y-m-d', strtotime($row['date_of_confiscation_order']));

    // Bind parameters
    $stmt->bind_param("sssssssssssssss", 
        $v_date_of_apprehension, 
        $v_sitio,
        $v_barangay,
        $v_city_municipality,
        $v_province,
        $v_apprehending_officer,
        $v_apprehended_items,
        $v_EMV_forest_product,
        $v_EMV_conveyance_implements,
        $v_involve_personalities,
        $v_custodian,
        $v_ACP_status_or_case_no,
        $v_date_of_confiscation_order,
        $v_remarks,
        $v_apprehended_persons
    );

    // Set other values
    $v_sitio = $row['sitio'];
    $v_barangay = $row['barangay'];
    $v_city_municipality = $row['city_municipality'];
    $v_province = $row['province'];
    $v_apprehending_officer = $row['apprehending_officer'];
    $v_apprehended_items = $row['apprehended_items'];
    $v_EMV_forest_product = $row['EMV_forest_product'];
    $v_EMV_conveyance_implements = $row['EMV_conveyance_implements'];
    $v_involve_personalities = $row['involve_personalities'];
    $v_custodian = $row['custodian'];
    $v_ACP_status_or_case_no = $row['ACP_status_or_case_no'];
    $v_remarks = $row['remarks'];
    $v_apprehended_persons = $row['apprehended_persons'];

    // Execute statement
    $stmt->execute();
}



// Close statement and database connection
$stmt->close();
$connection->close();
echo "<script>alert('Data inserted successfully.');</script>";


?>
