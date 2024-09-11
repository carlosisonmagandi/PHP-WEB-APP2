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
                <legend>Equipment Details:</legend>
                <div class="form-group">
                    <label for="equipmentName">Equipment Name</label>
                    <input type="text" class="form-control" id="equipmentName" name="equipmentName">
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" class="form-control" id="type" name="type">
                </div>
                <div class="form-group">
                    <label for="serialNo">Serial Number</label>
                    <input type="text" class="form-control" id="serialNo" name="serialNo">
                </div>
                <div class="form-group">
                    <label for="brand">Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand">
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model">
                </div>
                <div class="form-group">
                    <label for="condition">Condition</label>
                    <input type="text" class="form-control" id="condition" name="condition">
                </div>
            </fieldset>

            <fieldset>
                <legend>Ownership and Legal Information:</legend>
                <div class="form-group">
                    <label for="owner">Owner</label>
                    <input type="text" class="form-control" id="owner" name="owner">
                </div>
                <div class="form-group">
                    <label for="dateOfConfiscation">Date of Confiscation</label>
                    <input type="date" class="form-control" id="dateOfConfiscation" name="dateOfConfiscation">
                </div>

                <fieldset>
                    <legend>Additional Information:</legend>
                    <div class="form-group">
                        <label for="status">Equipment Status</label>
                        <input type="text" class="form-control" id="status" name="status">
                    </div>
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location">
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <input type="text" class="form-control" id="remarks" name="remarks">
                    </div>
                </fieldset>

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
                url: '/equipments/get-record-by-id.php',
                type: 'GET',
                data: { equipment_id:id},
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        let record = data.data;
                        // Populate form fields with the fetched data
                        $('#equipmentName').val(record.equipment_name);
                        $('#type').val(record.equipment_type);
                        $('#serialNo').val(record.serial_no);
                        $('#brand').val(record.brand);
                        $('#model').val(record.model);
                        $('#condition').val(record.equipment_condition);
                        $('#owner').val(record.equipment_owner);
                        $('#dateOfConfiscation').val(record.date_of_compiscation);
                        $('#status').val(record.equipment_status);
                        $('#location').val(record.location);
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
        $('#update').on('click', function() {
            updateRecord(id);
        });
        function updateRecord(id) {
            const formData = new FormData();
            formData.append('action', 'update_record');
            formData.append('equipment_id', id); // Function to get 'id' from the URL
            formData.append('equipmentName', $('#equipmentName').val());
            formData.append('type', $('#type').val());
            formData.append('serialNo', $('#serialNo').val());
            formData.append('brand', $('#brand').val());
            formData.append('model', $('#model').val());
            formData.append('condition', $('#condition').val());
            formData.append('owner', $('#owner').val());
            formData.append('dateOfConfiscation', $('#dateOfConfiscation').val());
            formData.append('status', $('#status').val());
            formData.append('location', $('#location').val());
            formData.append('remarks', $('#remarks').val());
            //  console.log('Sending request with ID:', id);
            //  console.log('Form data:', formData.serialNo);

            $.ajax({
                url: '/equipments/update-record.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    //console.log('Response received:', response);
                    
                    if (response.status === 'success') {
                        //console.log('Success:', response);

                        Swal.fire('Success!', 'Your record has been updated successfully.', 'success').then(() => {
                        let queryString = id;
                        let viewType = sessionStorage.getItem('viewType');//get session value
                        
                            if(viewType=='card'){
                                window.location.href = '/equipments/equipment-card-view.php?' + queryString;//redirect to card view
                                sessionStorage.removeItem('viewType');
                            }else{
                                window.location.href = '/equipments/equipment-table-view.php?' + queryString;//redirect to table view 
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
            formData.append('equipment_id', id); // Function to get 'id' from the URL
            formData.append('equipmentName', $('#equipmentName').val());
            formData.append('type', $('#type').val());
            formData.append('serialNo', $('#serialNo').val());
            formData.append('brand', $('#brand').val());
            formData.append('model', $('#model').val());
            formData.append('condition', $('#condition').val());
            formData.append('owner', $('#owner').val());
            formData.append('dateOfConfiscation', $('#dateOfConfiscation').val());
            formData.append('status', $('#status').val());
            formData.append('location', $('#location').val());
            formData.append('remarks', $('#remarks').val());

            let images = $('#images')[0].files;
            for (let i = 0; i < images.length; i++) {
                formData.append('images[]', images[i]);
            }

            $.ajax({
                url: '/equipments/add-record.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.status === 'success') {
                        Swal.fire('Success!', 'Your record has been submitted.', 'success').then(() => {
                            window.location.href = '/equipments/equipment-table-view.php';
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
