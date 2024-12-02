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

$requestUri = $_SERVER['REQUEST_URI'];
$parsedUrl = parse_url($requestUri);
$queryString = isset($parsedUrl['query']) ? $parsedUrl['query'] : '';

$id = $queryString;
$hasId = !empty($id);
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
     <!-- loader -->
     <link rel="stylesheet" href="/Styles/loader.css">
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

            <?php if (!$hasId): ?>
                <fieldset>
                <legend>Images:</legend>
                    <div class="form-group">
                        <input type="file" name="images[]" id="images" multiple>
                    </div>
                </fieldset>
            <?php endif; ?>

            <fieldset>
                <legend>Apprehension Site:</legend>
                <div class="form-group">
                    <label for="sitio">Sitio</label>
                    <input type="text" class="form-control" id="sitio" name="sitio">
                </div>
                <div class="form-group">
                    <label for="barangay">Barangay</label>
                    <input type="text" class="form-control" id="barangay" name="barangay" >
                </div>
                <div class="form-group">
                    <label for="city_municipality">City/Municipality</label>
                    <input type="text" class="form-control" id="city_municipality" name="city_municipality" >
                </div>
                <div class="form-group">
                    <label for="province">Province</label>
                    <input type="text" class="form-control" id="province" name="province" >
                </div>
            </fieldset>

            <fieldset>
                <legend>Depository Site:</legend>
                <div class="form-group">
                    <label for="depository_sitio">Sitio</label>
                    <input type="text" class="form-control" id="depository_sitio" name="depository_sitio">
                </div>
                <div class="form-group">
                    <label for="depository_barangay">Barangay</label>
                    <input type="text" class="form-control" id="depository_barangay" name="depository_barangay">
                </div>
                <div class="form-group">
                    <label for="depository_city">City/Municipality</label>
                    <input type="text" class="form-control" id="depository_city" name="depository_city">
                </div>
                <div class="form-group">
                    <label for="depository_province">Province</label>
                    <input type="text" class="form-control" id="depository_province" name="depository_province">
                </div>
            </fieldset>

            <fieldset>
                <legend>Apprehension Details:</legend>
                
                <!-- <div class="form-group">
                    <label for="apprehending_officer">Apprehending Officer</label>
                    <input type="text" class="form-control" id="apprehending_officer" name="apprehending_officer">
                </div> -->

                <div class="form-group">
                    <label for="apprehended_items">Species</label>
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
                    <label for="linear_mtrs">Linear mtrs.</label>
                    <input type="text" class="form-control" id="linear_mtrs" name="linear_mtrs">
                </div>
                <div class="form-group">
                    <label for="EMV_forest_product">EMV Forest Product</label>
                    <input type="number" min="0" class="form-control" id="EMV_forest_product" name="EMV_forest_product">
                </div>

                <div class="form-group">
                    <label for="species_type">Species Type</label>
                    <select class="form-control" id="species_type" name="species_type">
                        <option value="">Select Species Type</option>
                    </select>
                </div>
              
                <div class="form-group">
                    <label for="species_status">Species Status</label>
                    <select class="form-control" id="species_status" name="species_status">
                        <option value="">Select Species Type</option>
                    </select>
                </div>
               
                
                <!--Conveyance  -->
                <fieldset>
                    <legend>Conveyance details:</legend>
                    
                    <div class="form-group">
                        <label for="apprehended_vehicle">Vehicle</label>
                        <input type="text" class="form-control" id="apprehended_vehicle" name="apprehended_vehicle">
                    </div>
                    <div class="form-group">
                        <label for="apprehended_vehicle_type">Vehicle Type</label>
                        <input type="text" class="form-control" id="apprehended_vehicle_type" name="apprehended_vehicle_type">
                    </div>
                    <div class="form-group">
                        <label for="apprehended_vehicle_plate_no">Vehicle Plate No.</label>
                        <input type="text" class="form-control" id="apprehended_vehicle_plate_no" name="apprehended_vehicle_plate_no">
                    </div>
                    <div class="form-group">
                        <label for="EMV_conveyance_implements">Conveyance Estimate Value (P)</label>
                        <input type="text" class="form-control" id="EMV_conveyance_implements" name="EMV_conveyance_implements">
                    </div>
                </fieldset>

            </fieldset>

            <fieldset>
                <legend>Case Information:</legend>
                <div class="form-group">
                    <label for="involve_personalities">Name of respondents/Claimants/Owner</label>
                    <textarea class="form-control" id="involve_personalities" name="involve_personalities"></textarea>
                </div>
                <div class="form-group">
                    <label for="custodian">Custodian</label>
                    <input type="text" class="form-control" id="custodian" name="custodian">
                </div>
                <div class="form-group">
                    <label for="ACP_status_or_case_no">Administrative Status</label>
                    <input type="text" class="form-control" id="ACP_status_or_case_no" name="ACP_status_or_case_no">
                </div>
                <div class="form-group">
                    <label for="date_of_apprehension">Date of Apprehension</label>
                    <input type="date" class="form-control" id="date_of_apprehension" name="date_of_apprehension">
                </div>

                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks"></textarea>
                </div>
                <div class="form-group">
                    <label for="apprehending_officer">Apprehending Officers</label>
                    <!-- <textarea class="form-control" id="apprehending_officer" name="apprehending_officer"></textarea> -->

                    <select class="form-control" id="apprehending_officer" name="apprehending_officer">
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
            </fieldset>
            
            <?php if ($hasId): ?>
                <button type="button" id="update" class="btn btn-primary">Update</button>
            <?php else: ?>
                <button type="button" id="send" class="btn btn-primary">Submit</button>
            <?php endif; ?>
        </form>
    </div>
    <?php
    include "../templates/nav-bar2.php"; 
    ?>
<script>
    $(document).ready(function() {
      
        var id = "<?php echo $id; ?>";
        if (id) {
            $.ajax({
                url: '/inventory-tree/get-record.php',
                type: 'GET',
                data: { inventory_id:id},
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        let record = data.data;
                        // Populate form fields with the fetched data
                        $('#sitio').val(record.sitio);
                        $('#barangay').val(record.barangay);
                        $('#city_municipality').val(record.city_municipality);
                        $('#province').val(record.province);

                        $('#date_of_apprehension').val(record.date_of_apprehension);
                        $('#apprehending_officer').val(record.apprehending_officer);
                        $('#apprehended_items').val(record.apprehended_items);
                        $('#apprehended_quantity').val(record.apprehended_quantity);
                        $('#apprehended_volume').val(record.apprehended_volume);
                        $('#apprehended_vehicle').val(record.apprehended_vehicle);
                        $('#apprehended_vehicle_type').val(record.apprehended_vehicle_type);
                        $('#apprehended_vehicle_plate_no').val(record.apprehended_vehicle_plate_no);
                        $('#EMV_forest_product').val(record.EMV_forest_product);
                        $('#EMV_conveyance_implements').val(record.EMV_conveyance_implements);
                        $('#involve_personalities').val(record.involve_personalities);
                        $('#custodian').val(record.custodian);
                        $('#ACP_status_or_case_no').val(record.ACP_status_or_case_no);
                        $('#date_of_confiscation_order').val(record.date_of_confiscation_order);
                        $('#remarks').val(record.remarks);

                        $('#depository_sitio').val(record.depository_sitio);
                        $('#depository_barangay').val(record.depository_barangay);
                        $('#depository_city').val(record.depository_city);
                        $('#depository_province').val(record.depository_province);
                        $('#linear_mtrs').val(record.linear_mtrs);

                        $('#species_status').val(record.species_status);
                        $('#species_type').val(record.species_type);
                    } else {
                        Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                }
            });
        }
        // Get account by field staff
        $.ajax({
                url: '/inventory-tree/get-account.php',
                type: 'GET',
                success: function(response) {
                    var assignedToDropdown = $('#apprehending_officer');
                    assignedToDropdown.empty();
                    if (!id) {
                        assignedToDropdown.append('<option value="">Select Apprehending Officer</option>');
                    } else {
                        // Retrieve from session storage if available
                        let field_staff_session = sessionStorage.getItem('assignedTo');
                        if (field_staff_session) {
                            assignedToDropdown.append('<option selected value="' + field_staff_session + '">' + field_staff_session + '</option>');
                        }
                    }
                    // Iterate through the response data (array of accounts)
                    $.each(response, function(index, fieldStaff) {
                        var fullName = fieldStaff.full_name;
                        if (!assignedToDropdown.find('option[value="' + fullName + '"]').length) {
                            assignedToDropdown.append('<option value="' + fullName + '">' + fullName + '</option>');
                        }
                    });
                },
                error: function() {
                    console.error("An error occurred ");
                }
            });

         // display values to species_type dropdown
        $.ajax({
            url: '/manage-reference-data/logsType/type-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var speciesTypeDropdown = $('#species_type');
                speciesTypeDropdown.empty(); 

                if (!id) {
                    speciesTypeDropdown.append('<option value="">Select Species Type</option>');
                } else {
                    // Call session inventory status
                    let species_type = sessionStorage.getItem('species_type');
                    
                    if (species_type) {
                        speciesTypeDropdown.append('<option selected value="' + species_type + '">' + species_type + '</option>');
                    }
                }

                $.each(response, function(index, species) {
                    var speciesTitle = species.type_title;
                    
                    if (!speciesTypeDropdown.find('option[value="' + speciesTitle + '"]').length) {
                        speciesTypeDropdown.append('<option value="' + speciesTitle + '">' + speciesTitle + '</option>');
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching species types:', error);
            }
        });


        $.ajax({
            url: '/manage-reference-data/condition-status-list.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                var speciesStatusDropdown = $('#species_status');
                speciesStatusDropdown.empty(); 

                if (!id) {
                    speciesStatusDropdown.append('<option value="">Select Species Status</option>');
                
                } else {
                    // Call session inventory status
                    let species_status = sessionStorage.getItem('species_status');
                    // console.log('Species Status from sessionStorage:', species_status);  // Debugging: log the status

                    if (species_status) {
                        speciesStatusDropdown.append('<option selected value="' + species_status + '">' + species_status + '</option>');
                    }
                }

                $.each(response, function(index, species) {
                    var speciesStatus = species.condition_type;
                    if (!speciesStatusDropdown.find('option[value="' + speciesStatus + '"]').length) {
                        speciesStatusDropdown.append('<option value="' + speciesStatus + '">' + speciesStatus + '</option>');
                    }
                });

                
            },
            error: function(xhr, status, error) {
                console.error('Error fetching species status:', error);
            }
        });


        //Button Update
        $('#update').on('click', function() {
            updateRecord(id);
        });
        function updateRecord(id) {
            const formData = new FormData();
            formData.append('action', 'update_record');
            formData.append('inventory_id', id); // Function to get 'id' from the URL
            formData.append('date_of_apprehension', $('#date_of_apprehension').val());
            formData.append('sitio', $('#sitio').val());
            formData.append('barangay', $('#barangay').val());
            formData.append('city_municipality', $('#city_municipality').val());
            formData.append('province', $('#province').val());

            formData.append('apprehending_officer', $('#apprehending_officer').val());
            formData.append('apprehended_items', $('#apprehended_items').val());
            formData.append('apprehended_quantity', $('#apprehended_quantity').val());
            formData.append('apprehended_volume', $('#apprehended_volume').val());
            formData.append('apprehended_vehicle', $('#apprehended_vehicle').val());
            formData.append('apprehended_vehicle_type', $('#apprehended_vehicle_type').val());
            formData.append('apprehended_vehicle_plate_no', $('#apprehended_vehicle_plate_no').val());
            formData.append('EMV_forest_product', $('#EMV_forest_product').val());
            formData.append('EMV_conveyance_implements', $('#EMV_conveyance_implements').val());
            formData.append('involve_personalities', $('#involve_personalities').val());
            formData.append('custodian', $('#custodian').val());
            formData.append('ACP_status_or_case_no', $('#ACP_status_or_case_no').val());
            formData.append('date_of_confiscation_order', $('#date_of_confiscation_order').val());
            formData.append('remarks', $('#remarks').val());
            // formData.append('apprehended_persons', $('#apprehended_persons').val());

            formData.append('depository_sitio', $('#depository_sitio').val());
            formData.append('depository_barangay', $('#depository_barangay').val());
            formData.append('depository_city', $('#depository_city').val());
            formData.append('depository_province', $('#depository_province').val());

            formData.append('linear_mtrs', $('#linear_mtrs').val());

            formData.append('species_type', $('#species_type').val());
            formData.append('species_status', $('#species_status').val());
            // console.log('Sending request with ID:', id);
            // console.log('Form data:', formData.species_type);

            $.ajax({
                url: '/inventory-tree/update-record.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    //console.log('Response received:', response);
                    
                    if (response.status === 'success') {
                        Swal.fire('Success!', 'Your record has been updated successfully.', 'success').then(() => {
                        let queryString = id;
                        let viewType = sessionStorage.getItem('viewType');//get session value
                        
                            if(viewType=='card'){
                                window.location.href = '/inventory-card-view.php?' + queryString;//redirect to inventory table view
                                sessionStorage.removeItem('viewType');
                            }else{
                                window.location.href = '/inventory.php?' + queryString;//redirect to inventory table view 
                                sessionStorage.removeItem('viewType');  
                            }
                        });
                    } else {
                        Swal.fire('Error!', response.message || 'An error occurred while updating the record.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', status, error);
                    console.log('Response text:', xhr.responseText);
                    Swal.fire('Error!', 'An error occurred while updating the record.', 'error');
                }
            });
        }

        //Button Send
        $('#send').on('click', function() {
            // added loader
            Swal.fire({
                title: "Loading please wait",
                html: '<br><center><div class="spinner"></div></center>',
                icon: "info",
                timer: 20000,  
                showConfirmButton: false 
            });
            addRecord();
        });

        function addRecord() {
            const formData = new FormData();
            formData.append('action', 'add_record');
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
            // formData.append('apprehended_persons', $('#apprehended_persons').val());
            formData.append('apprehended_quantity', $('#apprehended_quantity').val());
            formData.append('apprehended_volume', $('#apprehended_volume').val());
            formData.append('apprehended_vehicle', $('#apprehended_vehicle').val());
            formData.append('apprehended_vehicle_type', $('#apprehended_vehicle_type').val());
            formData.append('apprehended_vehicle_plate_no', $('#apprehended_vehicle_plate_no').val());

            formData.append('depository_sitio', $('#depository_sitio').val());
            formData.append('depository_barangay', $('#depository_barangay').val());
            formData.append('depository_city', $('#depository_city').val());
            formData.append('depository_province', $('#depository_province').val());
            formData.append('linear_mtrs', $('#linear_mtrs').val());
            formData.append('species_type', $('#species_type').val());
            formData.append('species_status', $('#species_status').val());

            let images = $('#images')[0].files;
            for (let i = 0; i < images.length; i++) {
                formData.append('images[]', images[i]);
            }

            $.ajax({
                url: '/inventory-tree/add-record.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        Swal.fire('Success!', 'Your record has been submitted.', 'success').then(() => {
                            window.location.href = '/inventory.php';
                        });
                    } else {
                        Swal.fire('Error!', data.message || 'An error occurred while submitting the form.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.messageText);
                    Swal.fire('Error!', 'An error occurred while submitting the form.', 'error');
                }
            });
        }

        

    });
</script>


</body>
</html>
