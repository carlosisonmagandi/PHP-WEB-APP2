<?php
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");


//action after logout button
if(isset($_POST['Logout'])){
    session_destroy();
    header("Location: ../../index.php");
    exit;
};
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apprehension Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php 
    include ("../templates/nav-bar.php");
    ?>

    <style>
        fieldset {
            border: 2px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        legend {
            font-weight: bold;
            font-size: 16px;
            background-color: #a0a0a0;
            padding: 3px;
            border-radius: 3px;
            color: #FFF;
        }
    </style>
    <div class="container" style="padding:60px;">
        <h2>Apprehension Record</h2>
        <form id="apprehension-form" method="post">
            <input type="hidden" name="action" value="add_record">

            <fieldset>
                <legend>Images:</legend>
                <div class="form-group">
                    <input type="file" name="images[]" id="images" multiple>
                </div>
            </fieldset>

            <fieldset>
                <legend>Apprehension Site:</legend>
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
            </fieldset>

            <fieldset>
                <legend>Apprehension Details:</legend>
                <div class="form-group">
                    <label for="date_of_apprehension">Date of Apprehension</label>
                    <input type="date" class="form-control" id="date_of_apprehension" name="date_of_apprehension">
                </div>
                <div class="form-group">
                    <label for="apprehending_officer">Apprehending Officer</label>
                    <input type="text" class="form-control" id="apprehending_officer" name="apprehending_officer">
                </div>

                <fieldset>
                    <legend>Apprehended Items:</legend>
                    <div class="form-group">
                        <label for="apprehended_items">Name</label>
                        <input type="text" class="form-control" id="apprehended_items" name="apprehended_items">
                    </div>
                    <div class="form-group">
                        <label for="apprehended_quantity">Quantity (pcs)</label>
                        <input type="text" class="form-control" id="apprehended_quantity" name="apprehended_quantity">
                    </div>
                    <div class="form-group">
                        <label for="apprehended_volume">Volume</label>
                        <input type="text" class="form-control" id="apprehended_volume" name="apprehended_volume">
                    </div>
                    <div class="form-group">
                        <label for="apprehended_vehicle_name">Vehicle</label>
                        <input type="text" class="form-control" id="apprehended_vehicle_name" name="apprehended_vehicle_name">
                    </div>
                    <div class="form-group">
                        <label for="apprehended_vehicle_type">Vehicle Type</label>
                        <input type="text" class="form-control" id="apprehended_vehicle_type" name="apprehended_vehicle_type">
                    </div>
                    <div class="form-group">
                        <label for="apprehended_vehicle_plate">Vehicle Plate No.</label>
                        <input type="text" class="form-control" id="apprehended_vehicle_plate" name="apprehended_vehicle_plate">
                    </div>
                </fieldset>

                <div class="form-group">
                    <label for="EMV_forest_product">EMV Forest Product</label>
                    <input type="text" class="form-control" id="EMV_forest_product" name="EMV_forest_product">
                </div>
                <div class="form-group">
                    <label for="EMV_conveyance_implements">EMV Conveyance Implements</label>
                    <input type="text" class="form-control" id="EMV_conveyance_implements" name="EMV_conveyance_implements">
                </div>
            </fieldset>

            <fieldset>
                <legend>Case Information:</legend>
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
                    <input type="date" class="form-control" id="date_of_confiscation_order" name="date_of_confiscation_order">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                </div>
                <div class="form-group">
                    <label for="apprehended_persons">Apprehended Persons</label>
                    <textarea class="form-control" id="apprehended_persons" name="apprehended_persons"></textarea>
                </div>
            </fieldset>
            
            <button type="button" id="send" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <?php
    include "../templates/nav-bar2.php"; 
    ?>

<script>
    $('#send').on('click', function() {
        addRecord();
    });

    function addRecord() {
    const formData = new FormData();

    // Append all form data
    formData.append('action', 'add_record'); // Ensure this matches the PHP script expectation
    formData.append('date_of_apprehension', $('#date_of_apprehension').val());
    formData.append('sitio', $('#sitio').val());
    formData.append('barangay', $('#barangay').val());
    formData.append('city_municipality', $('#city_municipality').val());
    formData.append('province', $('#province').val());
    formData.append('apprehending_officer', $('#apprehending_officer').val());
    formData.append('apprehended_items', $('#apprehended_items').val());
    formData.append('EMV_forest_product', $('#EMV_forest_product').val());
    formData.append('EMV_conveyance_implements', $('#EMV_conveyance_implements').val());
    formData.append('involve_personalities', $('#involve_personalities').val());
    formData.append('custodian', $('#custodian').val());
    formData.append('ACP_status_or_case_no', $('#ACP_status_or_case_no').val());
    formData.append('date_of_confiscation_order', $('#date_of_confiscation_order').val());
    formData.append('remarks', $('#remarks').val());
    formData.append('apprehended_persons', $('#apprehended_persons').val());
    formData.append('apprehended_quantity', $('#apprehended_quantity').val());
    formData.append('apprehended_volume', $('#apprehended_volume').val());
    formData.append('apprehended_vehicle_name', $('#apprehended_vehicle_name').val());
    formData.append('apprehended_vehicle_type', $('#apprehended_vehicle_type').val());
    formData.append('apprehended_vehicle_plate', $('#apprehended_vehicle_plate').val());

    // Append files
    let images = $('#images')[0].files;
    console.log(images);
    for (let i = 0; i < images.length; i++) {
        formData.append('images[]', images[i]);
    }

    // Make AJAX request
    $.ajax({
        url: '/inventory-tree/add-record.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(data) {
            console.log("Success response:", data);
            if (data.status === 'success') {
                Swal.fire('Success!', 'Your record has been submitted.', 'success');
            } else {
                Swal.fire('Error!', data.message || 'An error occurred while submitting the form.', 'error');
            }
        },
        error: function(xhr, status, error) {
            console.log("AJAX Error:", status, error);
            console.log("Response:", xhr.responseText);
            Swal.fire('Error!', 'An error occurred while submitting the form.', 'error');
        }
    });

}


</script>

</body>
</html>
