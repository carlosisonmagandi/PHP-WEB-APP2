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
    <!-- <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css"> -->
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

            <?php if (!$hasId): ?>
                <fieldset>
                <legend>Images:</legend>
                    <div class="form-group">
                        <input type="file" name="images[]" id="images" multiple>
                    </div>
                </fieldset>
            <?php endif; ?>

            <fieldset>
                <legend>Conveyance Description:</legend>
                <div class="form-group">
                    <label for="plate_no">Plate Number</label>
                    <input type="text" class="form-control" id="plate_no" name="plate_no">
                </div>
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand">
                </div>
                <div class="form-group">
                    <label for="vehicle_type">Type</label>
                    <select class="form-control" id="vehicle_type" name="vehicle_type">
                        <option value="">Select Type</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="vehicle_name">Model Name</label>
                    <input type="text" class="form-control" id="vehicle_name" name="vehicle_name">
                </div>
                <div class="form-group">
                    <label for="model">Year Model</label>
                    <input type="text" class="form-control" id="model" name="model">
                </div>
                <div class="form-group">
                    <label for="vehicle_condition">Condition</label>
                    <select class="form-control" id="vehicle_condition" name="vehicle_condition">
                        <option value="">Select Condition</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="vehicle_status">Status</label>
                    <select class="form-control" id="vehicle_status" name="vehicle_status">
                        <option value="">Select Condition</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control" id="location" name="location">
                </div>
            </fieldset>

            <fieldset>
                <legend>Ownership</legend>
                <div class="form-group">
                    <label for="vehicle_owner">Name of Respondent/Claimant/Owner</label>
                    <input type="text" class="form-control" id="vehicle_owner" name="vehicle_owner">
                </div>
                <div class="form-group">
                    <label for="date_of_compiscation">Date of Apprehension</label>
                    <input type="date" class="form-control" id="date_of_compiscation" name="date_of_compiscation">
                </div>
                <div class="form-group">
                    <label for="confiscated_by">Apprehending Officer</label>
                    <input type="text" class="form-control" id="confiscated_by" name="confiscated_by">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <input type="text" class="form-control" id="remarks" name="remarks">
                </div>
            </fieldset>

            
            <?php if ($hasId): ?>
                <button type="button" id="vehicleUpdate" class="btn btn-primary">Update</button>
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
                url: '/vehicles/get-record-by-id.php',
                type: 'GET',
                data: { vehicle_id:id},
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        let record = data.data;
                        // Populate form fields with the fetched data
                        $('#plate_no').val(record.plate_no);
                        $('#brand').val(record.brand);
                        $('#vehicle_type').val(record.vehicle_type);
                        $('#vehicle_name').val(record.vehicle_name);
                        $('#model').val(record.model);
                        $('#vehicle_condition').val(record.vehicle_condition);
                        $('#vehicle_status').val(record.vehicle_status);
                        $('#location').val(record.location);
                        $('#vehicle_owner').val(record.vehicle_owner);
                        $('#date_of_compiscation').val(record.date_of_compiscation);
                        $('#confiscated_by').val(record.confiscated_by);
                        $('#remarks').val(record.remarks);
                        
                    } else {
                        Swal.fire('Error!', data.message || 'An error occurred while fetching the record.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire('Error!', 'An error occurred while fetching the record.', 'error');
                }
            });
        }
        //Button Update
        $('#vehicleUpdate').on('click', function() {
            updateRecord(id);
        });
        function updateRecord(id) {
            const formData = new FormData();
            formData.append('action', 'update_record');
            formData.append('vehicle_id', id); // Function to get 'id' from the URL
            formData.append('plate_no', $('#plate_no').val());
            formData.append('brand', $('#brand').val());
            formData.append('vehicle_type', $('#vehicle_type').val());
            formData.append('vehicle_name', $('#vehicle_name').val());
            formData.append('model', $('#model').val());
            formData.append('vehicle_condition', $('#vehicle_condition').val());
            formData.append('vehicle_status', $('#vehicle_status').val());
            formData.append('location', $('#location').val());
            formData.append('vehicle_owner', $('#vehicle_owner').val());
            formData.append('date_of_compiscation', $('#date_of_compiscation').val());
            formData.append('confiscated_by', $('#confiscated_by').val());
            formData.append('remarks', $('#remarks').val());
            //  console.log('Sending request with ID:', id);
            //  console.log('Form data:', formData.serialNo);

            $.ajax({
                url: '/vehicles/update-record.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    //console.log('Response received:', response);
                    
                    if (response.status === 'success') {
                        // console.log('Success:', response);

                        Swal.fire('Success!', 'Your record has been updated successfully.', 'success').then(() => {
                        let queryString = id;
                        let viewType = sessionStorage.getItem('viewType');//get session value
                        
                            if(viewType=='card'){
                                window.location.href = '/vehicles/vehicle-card-view.php?' + queryString;//redirect to card view
                                sessionStorage.removeItem('viewType');
                            }else{
                                window.location.href = '/vehicles/vehicle-table-view.php?' + queryString;//redirect to table view 
                                sessionStorage.removeItem('viewType');  
                            }
                        });
                    } else {
                        Swal.fire('Error!', response.message || 'An error occurred while updating the record.', 'error');
                    }
                },
                error: function(xhr, status, error) {
                    // console.log('AJAX Error:', status, error);
                    // console.log('Response text:', xhr.responseText);
                    Swal.fire('Error!', 'An error occurred while updating the record.', 'error');
                }
            });
         }

        //Button Send
        $('#send').on('click', function() {
            addRecord();
        });

        function addRecord() {
            const formData = new FormData();
            formData.append('action', 'add_record');
            formData.append('vehicle_id', id); // Function to get 'id' from the URL
            formData.append('plate_no', $('#plate_no').val());
            formData.append('brand', $('#brand').val());
            formData.append('vehicle_type', $('#vehicle_type').val());
            formData.append('vehicle_name', $('#vehicle_name').val());
            formData.append('model', $('#model').val());
            formData.append('vehicle_condition', $('#vehicle_condition').val());
            formData.append('vehicle_status', $('#vehicle_status').val());
            formData.append('location', $('#location').val());
            formData.append('vehicle_owner', $('#vehicle_owner').val());
            formData.append('date_of_compiscation', $('#date_of_compiscation').val());
            formData.append('confiscated_by', $('#confiscated_by').val());
            formData.append('remarks', $('#remarks').val());

            let images = $('#images')[0].files;
            for (let i = 0; i < images.length; i++) {
                formData.append('images[]', images[i]);
            }

            $.ajax({
                url: '/vehicles/add-record.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        Swal.fire('Success!', 'Your record has been submitted.', 'success').then(() => {
                            window.location.href = '/vehicles/vehicle-table-view.php';
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

        //Get Condition
        $.ajax({
            url: '/vehicles/get-condition.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
    
                var conditionDropdown = $('#vehicle_condition');
                conditionDropdown.empty();
                
                if (!id) {
                    conditionDropdown.append('<option value="">Select Condition Type</option>');
                } else {
                    // Call session inventory status
                    let vehicle_condition = sessionStorage.getItem('vehicle_condition');
                    
                    if (vehicle_condition) {
                        conditionDropdown.append('<option selected value="' + vehicle_condition + '">' + vehicle_condition + '</option>');
                    }
                }
                $.each(data, function(index, vehicle) {
                    var vehicleCondition = vehicle.condition_title;
                    if (!conditionDropdown.find('option[value="' + vehicleCondition + '"]').length) {
                        conditionDropdown.append('<option value="' + vehicleCondition + '">' + vehicleCondition + '</option>');
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get Type
        $.ajax({
            url: '/vehicles/get-type.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var typeDropdown = $('#vehicle_type');
                typeDropdown.empty();
                
                if (!id) {
                    typeDropdown.append('<option value="">Select Type</option>');
                } else {
                    // Call session inventory status
                    let vehicle_type = sessionStorage.getItem('vehicle_type');
                    
                    if (vehicle_type) {
                        typeDropdown.append('<option selected value="' + vehicle_type + '">' + vehicle_type + '</option>');
                    }
                }

                $.each(data, function(index, vehicle) {
                    var vehicleType = vehicle.type_title;
                    if (!typeDropdown.find('option[value="' + vehicleType + '"]').length) {
                        typeDropdown.append('<option value="' + vehicleType + '">' + vehicleType + '</option>');
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

        //Get Status
        $.ajax({
            url: '/vehicles/get-status.php',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var statusDropdown = $('#vehicle_status');
                statusDropdown.empty();
                
                if (!id) {
                    statusDropdown.append('<option value="">Select Status</option>');
                } else {
                    // Call session inventory status
                    let vehicle_status = sessionStorage.getItem('vehicle_status');
                    
                    if (vehicle_status) {
                        statusDropdown.append('<option selected value="' + vehicle_status + '">' + vehicle_status + '</option>');
                    }
                }

                $.each(data, function(index, vehicle) {
                    var vehicleStatus = vehicle.status_title;
                    if (!statusDropdown.find('option[value="' + vehicleStatus + '"]').length) {
                        statusDropdown.append('<option value="' + vehicleStatus + '">' + vehicleStatus + '</option>');
                    }
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching condition data: ', error);
            }
        });

    });

</script>


</body>
</html>
