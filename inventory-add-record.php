<?php
session_start();
require("includes/session.php");
require("includes/darkmode.php");
require("includes/authentication.php");
require_once("includes/db_connection.php");

// Action after logout button
if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}

if (isset($_POST['submit'])) {
    // Retrieve form data
    $date_of_apprehension = $_POST['date_of_apprehension'];
    $sitio = $_POST['sitio'];
    $barangay = $_POST['barangay'];
    $city_municipality = $_POST['city_municipality'];
    $province = $_POST['province'];
    $apprehending_officer = $_POST['apprehending_officer'];
    $apprehended_items = $_POST['apprehended_items'];
    $EMV_forest_product = $_POST['EMV_forest_product'];
    $EMV_conveyance_implements = $_POST['EMV_conveyance_implements'];
    $involve_personalities = $_POST['involve_personalities'];
    $custodian = $_POST['custodian'];
    $ACP_status_or_case_no = $_POST['ACP_status_or_case_no'];
    $date_of_confiscation_order = $_POST['date_of_confiscation_order'];
    $remarks = $_POST['remarks'];
    $apprehended_persons = $_POST['apprehended_persons'];
    $date_created = date('Y-m-d');

    // Handle file uploads
    $upload_directory = 'Inventory/images/'; // Directory to save uploaded images
    $allowed_types = array('jpg', 'png', 'jpeg', 'gif');
    $invalid_file_found = false;

    if (!empty(array_filter($_FILES['images']['name']))) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($_FILES['images']['name'][$key]);
            $file_size = $_FILES['images']['size'][$key];
            $file_tmp = $_FILES['images']['tmp_name'][$key];
            $file_type = $_FILES['images']['type'][$key];
            $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $date_created = date('Y-m-d');

            // Check if the file type is allowed
            if (in_array($file_ext, $allowed_types) && $file_size <= 2097152) { // Limit file size to 2MB
                $new_file_name = uniqid() . '.' . $file_ext;
                $upload_path = $upload_directory . $new_file_name;

                if (move_uploaded_file($file_tmp, $upload_path)) {
                    // Insert image information into the database
                    $stmt_image = $connection->prepare("INSERT INTO inventory_images (inventory_id, file_name, file_path, date_created) VALUES (?, ?, ?, ?)");
                    $stmt_image->bind_param('isss', $record_id, $file_name, $upload_path, $date_created);
                    $stmt_image->execute();
                    $stmt_image->close();
                }
            } else {
                // Set flag to true if an invalid file is found
                $invalid_file_found = true;
                echo "Invalid file: $file_name<br>";
            }
        }
    }

    // Check if any invalid file was found
    if (!$invalid_file_found) {
        // Prepare the SQL statement
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
            apprehended_persons,
            date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind the parameters to the SQL query
        $stmt->bind_param('ssssssssssssssss', $date_of_apprehension, $sitio, $barangay, $city_municipality, $province, $apprehending_officer, $apprehended_items, $EMV_forest_product, $EMV_conveyance_implements, $involve_personalities, $custodian, $ACP_status_or_case_no, $date_of_confiscation_order, $remarks, $apprehended_persons, $date_created);

        // Execute the statement
        if ($stmt->execute()) {
            $record_id = $stmt->insert_id; // Get the ID of the inserted record
            echo "Success";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle the case where invalid files were found
        echo "Invalid file(s) found. Aborting insertion into inventory table.";
       
    }
}

// Close the connection
$connection->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apprehension Form</title>

</head>
<body>
    <!-- nav-bar template -->

    <?php 
    include ("templates/nav-bar.php");
    ?>
    <div class="container " style="padding:60px;">
        <h2>Apprehension Record</h2>
        <form method="post" action='' enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" name="images[]" multiple>
            </div>
            <div class="form-group">
                <label for="date_of_apprehension">Date of Apprehension</label>
                <input type="text" class="form-control datepicker" id="date_of_apprehension" name="date_of_apprehension">
            </div>
            <div class="form-group">
                <label for="sitio">Sitio</label>
                <input type="text" class="form-control" id="sitio" name="sitio">
            </div>
            <div class="form-group">
                <label for="barangay">Barangay</label>
                <input type="text" class="form-control" id="barangay" name="barangay">
            </div>
            <div class="form-group">
                <label for="city_municipality">City/Municipality</label>
                <input type="text" class="form-control" id="city_municipality" name="city_municipality">
            </div>
            <div class="form-group">
                <label for="province">Province</label>
                <input type="text" class="form-control" id="province" name="province">
            </div>
            <div class="form-group">
                <label for="apprehending_officer">Apprehending Officer</label>
                <input type="text" class="form-control" id="apprehending_officer" name="apprehending_officer">
            </div>
            <div class="form-group">
                <label for="apprehended_items">Apprehended Items</label>
                <textarea class="form-control" id="apprehended_items" name="apprehended_items"></textarea>
            </div>
            <div class="form-group">
                <label for="EMV_forest_product">EMV Forest Product</label>
                <input type="text" class="form-control" id="EMV_forest_product" name="EMV_forest_product">
            </div>
            <div class="form-group">
                <label for="EMV_conveyance_implements">EMV Conveyance Implements</label>
                <input type="text" class="form-control" id="EMV_conveyance_implements" name="EMV_conveyance_implements">
            </div>
            <div class="form-group">
                <label for="involve_personalities">Involved Personalities</label>
                <textarea class="form-control" id="involve_personalities" name="involve_personalities"></textarea>
            </div>
            <div class="form-group">
                <label for="custodian">Custodian</label>
                <input type="text" class="form-control" id="custodian" name="custodian">
            </div>
            <div class="form-group">
                <label for="ACP_status_or_case_no">ACP Status or Case No.</label>
                <input type="text" class="form-control" id="ACP_status_or_case_no" name="ACP_status_or_case_no">
            </div>
            <div class="form-group">
                <label for="date_of_confiscation_order">Date of Confiscation Order</label>
                <input type="text" class="form-control datepicker" id="date_of_confiscation_order" name="date_of_confiscation_order">
            </div>
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks"></textarea>
            </div>
            <div class="form-group">
                <label for="apprehended_persons">Apprehended Persons</label>
                <textarea class="form-control" id="apprehended_persons" name="apprehended_persons"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>


    <?php
    include  "templates/nav-bar2.php"; 
    ?>
</body>
</html>
