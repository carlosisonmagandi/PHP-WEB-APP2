<?php 
session_start();

require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");

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
    <title>Donation Request Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" type="text/css" href="/Styles/breadCrumbs.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- bootstrap -->

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            font-size:12px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input, textarea, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
        }
        .checkbox-group input {
            width: auto;
            margin-right: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            cursor: pointer;
            float:right;
        }
        .cancelButton{
            padding: 10px 20px;
            background-color: #666;
            color: #fff;
            border: none;
            cursor: pointer;
            float:right;
            margin-right:10px;
            text-decoration: none;
        }
        /* Responsive Flex Layout */
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding:25px;
        }
        .form-column {
            flex: 1;
            min-width: 300px;
        }
        legend {
            color: #666;
            font-size: 14px; 
            font-style:italic;
            font-weight:bold;
        }
        fieldset{
            padding:25px;
            margin:15px;
            border-width: 1px; 
            border-style: solid;
        }
        /* Tooltip CSS */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 300px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
        form{
            padding: 15px;
        }
        span{
            color:#666;
        }
        .star{
            color:red;
            font-size:18px;
        }
        
    </style>
</head>
<body>
    
<br>
<div class="container">
    <?php if ($_SESSION['mode'] == 'light'): ?>
        <div class="breadcrumb flat">
            <a href="#">Request</a>
            <a href="/Request/my-request.php">My request</a>
            <a href="/Request/requestForm.php">Create Request</a>
            
        </div>
    <?php else: ?>
        <div class="breadcrumb">
            <a href="#">Request</a>
            <a href="/Request/my-request.php">My request</a>
            <a href="/Request/requestForm.php">Create Request</a>
        
        </div>
    <?php endif; ?>
</div>
    <form action="" method="post" enctype="multipart/form-data" id="requestForm">
        <h3>Donation Request Form</h3>
        <div class="form-container">    
            <!-- Requestor Information -->
            <div class="form-column">
                <fieldset>
                    <legend>Requestor Information</legend>
                    <div class="form-group">
                        <label for="requestor_name"><i class="star" >*</i> Requestee <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Full name of the requestor.</span></span></label>
                        <input type="text" id="requestor_name" name="requestor_name" required>
                    </div>
                    <div class="form-group">
                        <label for="organization">Office (if applicable) <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext"> Name of the organization making the request.</span></span></label>
                        <input type="text" id="organization" name="organization">
                    </div>
                    <div class="form-group">
                        <label><i class="star" >*</i> Contact Information <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Contact information of the requestor.</span></span></label>
                        <input type="tel" id="phone_number" name="phone_number" placeholder="Phone Number" required>
                        <input type="email" id="email_address" name="email_address" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <label for="address"><i class="star" >*</i> Address <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Location address of the requestor.</span></span></label>
                        <input type="text" id="address" name="address" required>
                    </div>
                </fieldset>
            </div>
            <!-- Donation Request Details -->
            <div class="form-column">
                <fieldset>
                    <legend>Donation Request Details</legend>
                    <div class="form-group">
                        <!-- <label for="item_type"><i class="star" >*</i> Type of Item Requested <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Type of item needed (e.g., logs, trees,coals etc..).</span></span></label>
                        <input type="text" id="item_type" name="item_type" > -->

                        <table >
                            <tr >
                                <?php if ($hasId): ?>
                                    <td><input type="text"  id="item_type_value" disabled /></td>
                                <?php else: ?>
                                    <label for="item_type" ><i class="star" >*</i>Type of requested forest products <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Type of item needed (e.g., logs, trees,coals etc..).</span></span></label>
                                <?php endif; ?>
                                
                                <td>
                                    
                                    <select class="form-control" id="item_type" name="item_type" required >
                                        <option value="">Select Type</option>
                                    </select>
                                    
                                </td>
                            </tr>
                            <tr>
                                <?php if ($hasId): ?>
                                    <td><input type="text" id="item_name_value" disabled /></td>
                                <?php endif; ?>
                                <td>
                                    <?php if ($hasId): ?>
                                    <?php else: ?>
                                        <label for="item_name_input" ><i class="star" id="star" style="display: none;">*</i><span id="labelName" style="display: none;">Species</span> </label>
                                    <?php endif; ?>
                                    <select class="form-control" id="item_name_input" name="item_name_input" style="display: none;">
                                        <option value="">Select available flitches</option>
                                    </select>
                                    
                                    <?php if ($hasId): ?>
                                    <?php else: ?>
                                        <label for="equipment_name" ><i class="star" id="equipmentStar" style="display: none;" >*</i><span id="equipmentLabelName" style="display: none;" >Species</span> </label>
                                    <?php endif; ?>
                                    
                                    <select class="form-control" id="equipment_name" name="equipment_name" style="display: none;">
                                        <option value="">Select available equipment</option>
                                    </select>    
                                </td>
                            </tr>            
                        </table>
                    </div>

                    <table>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="item_description"><i class="star" >*</i> Description of Items Requested <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Detailed description of the logs or trees (e.g., type of wood, size, condition, species of trees, age)</span></span></label>
                                    <textarea id="item_description" name="item_description" required></textarea>
                                </div>
                            </td>
                            
                            <td>
                                <div class="form-group" style="margin-left:20px;">
                                    <label for="quantity_needed"><i class="star" >*</i> Quantity Needed <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext"> Number of items needed.</span></span></label>
                                    <input type="number" id="quantity_needed" name="quantity_needed" min=1 required >
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                    <div class="form-group">
                        <label for="purpose"><i class="star" >*</i> Purpose of Request <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Explanation of how the donated items will be used (e.g., community project, reforestation, firewood).</span></span></label>
                        <textarea id="purpose" name="purpose" required></textarea>
                    </div>
                    
                </fieldset>
            </div>
        </div>
        
        <div class="form-container">
            <!-- Collection/Delivery Information -->
            <div class="form-column">
                <fieldset>
                    <legend>Collection/Delivery Information</legend>
                    <div class="form-group">
                        <label for="delivery_date">Preferred Delivery Date <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Date when the requestor needs the items to be delivered.</span></span></label>
                        <input type="date" id="delivery_date" name="delivery_date" >
                    </div>
                    <div class="form-group">
                        <label for="delivery_time"> Preferred Delivery Time <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Time slot for delivery.</span></span></label>
                        <input type="time" id="delivery_time" name="delivery_time" >
                    </div>
                    <div class="form-group">
                        <label for="delivery_address"><i class="star" >*</i> Delivery Address <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Address where the items should be delivered.</span></span></label>
                        <input type="text" id="delivery_address" name="delivery_address" required>
                    </div>
                    <div class="form-group">
                        <label for="special_instructions">Special Instructions <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Any specific instructions regarding the delivery of the items</span></span></label>
                        <textarea id="special_instructions" name="special_instructions"></textarea>
                    </div>
                </fieldset>
            </div>

            <!-- Additional Information -->
            <script>
            function updateTextInput(checkboxId, textInputId) {
                var checkbox = document.getElementById(checkboxId);
                var textInput = document.getElementById(textInputId);

                if (checkbox && textInput) {
                    // Update text value based on checkbox state
                    textInput.value = checkbox.checked ? "Yes" : "No";
                }
            }

            // Initialize the text inputs to "No" on page load
            window.onload = function() {
                updateTextInput('Li-yes-no-cb', 'Li-yes-no');
                updateTextInput('Cpe-yes-no-cb', 'Cpe-yes-no');
                updateTextInput('Cbo-yes-no-cb', 'Cbo-yes-no');
            };
        </script>

        <div class="form-column">
            <fieldset>
                <legend>Document Submitted</legend>
                <div class="form-group">
                    <label for="Li-yes-no">Letter of Intent</label>
                    <input type="checkbox" id="Li-yes-no-cb" name="Li-yes-no-cb" onchange="updateTextInput('Li-yes-no-cb', 'Li-yes-no')">
                    <input type="hidden" id="Li-yes-no" name="Li-yes-no" value="No" readonly >
                </div>
                <div class="form-group">
                    <label for="Cpe-yes-no">Certification by the project engineer</label>
                    <input type="checkbox" id="Cpe-yes-no-cb" name="Cpe-yes-no-cb" onchange="updateTextInput('Cpe-yes-no-cb', 'Cpe-yes-no')">
                    <input type="hidden" id="Cpe-yes-no" name="Cpe-yes-no" value="No" readonly><br>
                </div>
                <div class="form-group">
                    <label for="Cbo-yes-no">Certification by the budget officer </label>
                    <input type="checkbox" id="Cbo-yes-no-cb" name="Cbo-yes-no-cb" onchange="updateTextInput('Cbo-yes-no-cb', 'Cbo-yes-no')">
                    <input type="hidden" id="Cbo-yes-no" name="Cbo-yes-no" value="No" readonly><br>
                </div>
                <div class="form-group" style="border:1px solid #e0e0e0;padding:10px;box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);">
                    <label for="supporting_documents">Supporting Documents <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Option to upload any supporting documents (e.g., proof of need, project plans, photos).</span></span></label>
                    <input type="file" id="supporting_documents" name="supporting_documents[]" multiple>
                    <div id="file-list"></div>
                </div>
            </fieldset>
        </div>

        </div>
        
        <!-- Acknowledgment and Consent -->
        <!-- <fieldset>
            <legend>Acknowledgment and Consent</legend>
            <div class="form-group checkbox-group">
                <input type="checkbox" id="terms_conditions" name="terms_conditions" required>
                <label for="terms_conditions"><i class="star" >*</i> I agree to the terms and conditions <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Checkbox or signature field for the requestor's agreement</span></span></label>
            </div>
            <div class="form-group checkbox-group">
                <input type="checkbox" id="consent_contact" name="consent_contact" required>
                <label for="consent_contact"><i class="star" >*</i> I consent to being contacted by potential donors <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Checkbox for the requestor to consent to being contacted by potential donors.</span></span></label>
            </div>
        </fieldset> -->

        <!-- Verification -->
        <fieldset>
            <?php if ($hasId): ?>
                <button type="submit" name="updateRequestButton" id="updateRequestButton" >Update</button>
                <a class="cancelButton" href="/Request/my-request.php">Cancel</a>
            <?php else: ?>
                <button type="submit" name="submit">Submit Request</button>
            <?php endif; ?>
        <input type="text" id="status" disabled />
        </fieldset>
        
    </form>
    
    <script>
        $(document).ready(function(){

            fetchFiles(id);
            // update(typeTitles);
            $('#requestForm').on('submit', function(e){
                 e.preventDefault(); // Prevent default form submission
                // var formData = new FormData(this); 
                const formData = new FormData();
                formData.append('requestor_name', $('#requestor_name').val());
                formData.append('organization', $('#organization').val());
                formData.append('phone_number', $('#phone_number').val());
                formData.append('email_address', $('#email_address').val());
                formData.append('address', $('#address').val());
                formData.append('item_type', $('#item_type').val());
                formData.append('quantity_needed', $('#quantity_needed').val());
                formData.append('item_description', $('#item_description').val());
                formData.append('purpose', $('#purpose').val());
                formData.append('delivery_date', $('#delivery_date').val());
                formData.append('delivery_time', $('#delivery_time').val());
                formData.append('delivery_address', $('#delivery_address').val());
                formData.append('special_instructions', $('#special_instructions').val());
                formData.append('letter_of_intent', $('#Li-yes-no').val());
                formData.append('project_eng_certification', $('#Cpe-yes-no').val());
                formData.append('budget_officer_certification', $('#Cbo-yes-no').val());

                // species ID,Name,PCS
                // Get the selected option's text
                const selectedItemText = $('#item_name_input option:selected').text();

                // Split the text by the hyphen (-) and take the second part (the item name)
                const selectedItemName = selectedItemText.split('-')[1].split(' (')[0];

                // Append the item ID and name to the formData
                const selectedInventoryId = $('#item_name_input').val();
                formData.append('item_id', selectedInventoryId);
                formData.append('item_name_input', selectedItemName);

                let fileDocument = $('#supporting_documents')[0].files;
                for (let i = 0; i < fileDocument.length; i++) {
                    formData.append('supporting_documents[]', fileDocument[i]);
                }

                $.ajax({
                    url: '/Request/insert-record-with-file.php',
                    type: 'POST',
                    processData: false, 
                    contentType: false, 
                    data: formData, 
                    success: function(response){
                        Swal.fire('Record Added Successfully!').then((result) => {
                            window.location.href = '/Request/my-request.php';
                        });

                    },
                    error: function(xhr, status, error){
                        console.error('Error: ' + xhr.responseText);
                        alert('There was an error submitting the form.');
                    }
                });

                // Call the insert-record for donation_monitoring table 
            });
            // custom
            function updateHiddenInput(checkbox, hiddenInputId) {
                var hiddenInput = document.getElementById(hiddenInputId);
                if (checkbox.checked) {
                    hiddenInput.value = 'yes';
                } else {
                    hiddenInput.value = 'no';
                }
            }

            //Get Type
            $.ajax({
                url: '/Request/get-type.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var typeDropdown = $('#item_type');
                    typeDropdown.empty();
                    
                    typeDropdown.append('<option value="">Select Type</option>');
                    var typeTitles = [];

                    $.each(data, function(index, typeTitle) {
                        typeDropdown.append('<option value="' + typeTitle + '">' + typeTitle + '</option>');
                    });
                    update(typeTitles, [],id); 
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching condition data: ', error);
                }
            });

            // Get Tree/Flitches
            $.ajax({
                url: '/Request/get-tree.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var treeDropdown = $('#item_name_input');
                    treeDropdown.empty();
                    treeDropdown.append('<option value="">Select available flitches</option>');
                    var treeTitles = [];

                    $.each(data, function(index, treeData) {
                        var inventoryId = treeData.id;
                        var itemName = treeData.item;
                        var quantity = treeData.quantity;
                        treeDropdown.append(
                            '<option value="' + inventoryId + '">' + 
                            'ID: ' + inventoryId + ' - ' + itemName + ' (Quantity: ' + quantity + ' pcs.)' + 
                            '</option>'
                        );
                    });

                    update([], treeTitles, id); 
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching tree data: ', error);
                }
            });



            //Get Equipment
            $.ajax({
                url: '/Request/get-equipment.php',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var equipmentDropdown = $('#equipment_name');
                    
                    equipmentDropdown.empty();
                    
                    equipmentDropdown.append('<option value="">Select available item</option>');
                    
                    $.each(data, function(index, equipmentTitle) {
                        // console.log('equipment id:',equipmentTitle.id);
                        var equipmentId=equipmentTitle.id
                        equipmentDropdown.append('<option value="' + equipmentTitle + '">' + equipmentTitle + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching condition data: ', error);
                }
            });
        });

        //Display tree/flitches name 
        $('#item_type').change(function() {
        var selectedType = $(this).val().toLowerCase();
        
        if (selectedType === 'Flitches' || selectedType === 'flitches' || selectedType === 'Lumber' || selectedType === 'lumber') {
            $('#item_name_input').show();
            $('#star').show();
            $('#labelName').show();

            $('#equipmentStar').hide();
            $('#equipmentLabelName').hide();
            $('#equipment_name').hide();
        }
        else if (selectedType === 'Equipment' || selectedType === 'equipment'){
            $('#equipmentStar').show();
            $('#equipmentLabelName').show();
            $('#equipment_name').show();

            $('#item_name_input').hide();
            $('#star').hide();
            $('#labelName').hide();

        }else {
            $('#item_name_input').hide();
            $('#star').hide();
            $('#labelName').hide();

            $('#equipmentStar').hide();
            $('#equipmentLabelName').hide();
            $('#equipment_name').hide();
        }
    });

    //Get record by id when edit
    function convertTo24HourFormat(time) {
    
        let timeParts = time.match(/(\d+):(\d+)\s?(AM|PM)?/i);// Check if the time is in the 12-hour format with AM/PM
        if (!timeParts) return time; // If the time is already in 24-hour format or invalid

        let hours = parseInt(timeParts[1], 10);
        let minutes = timeParts[2];
        let period = timeParts[3] ? timeParts[3].toUpperCase() : null;

        if (period === "PM" && hours < 12) {
            hours += 12;
        } else if (period === "AM" && hours === 12) {
            hours = 0; // Midnight case
        }

        // Format the hours and minutes into HH:MM
        return (hours < 10 ? "0" : "") + hours + ":" + minutes;
    }

    var id = "<?php echo $id; ?>";
    if (id) {
        getRecordById();
        function getRecordById(){
            $.ajax({
                url: '/Request/get-record-by-id.php',
                type: 'GET',
                data: { requestId: id },
                dataType: 'json',
                success: function(response) {
                    // Populate the form fields with data from the response
                    $('#requestor_name').val(response.requestor_name);
                    $('#organization').val(response.organization_name);
                    $('#phone_number').val(response.phone_number);
                    $('#email_address').val(response.email);
                    $('#address').val(response.address);
                    $('#quantity_needed').val(response.quantity);
                    $('#item_description').val(response.request_description);
                    $('#purpose').val(response.purpose_of_donation);
                    $('#delivery_address').val(response.delivery_address);
                    $('#special_instructions').val(response.special_instructions);
                    $('#reason').val(response.reason_of_request);
                    $('#previous_donations').val(response.previous_donations);
                    $('#additional_comments').val(response.additional_comments);
                    $('#item_name').val(response.name_of_requested_item);
                    $('#status').val(response.approval_status);
                    $('#delivery_date').val(response.preferred_delivery_date);
                    $('#status').val(response.approval_status);
                    $('#Li-yes-no').val(response.letter_of_intent);
                    $('#Cpe-yes-no').val(response.project_eng_certification);
                    $('#Cbo-yes-no').val(response.budget_officer_certification);

                    // Handle delivery time with conversion to 24-hour format
                    let time = response.preferred_delivery_time;
                    if (time) {
                        let convertedTime = convertTo24HourFormat(time);
                        $('#delivery_time').val(convertedTime);
                    }

                    // Populate the item type (ensure options are available in the select element)
                    let itemType = response.type_of_requested_item;
                    let itemName = response.name_of_requested_item;
                    if (itemType) {
                        $('#item_type_value').val(itemType);
                        $('#item_name_value').val(itemName);
                        
                    }

                    if (itemType === 'Trees' || itemType === 'trees')  {
                        $('#item_name').show();
                        $('#star').show();
                        $('#labelName').show();

                        $('#equipmentStar').hide();
                        $('#equipmentLabelName').hide();
                        $('#equipment_name').hide();

                        
                    } else if (itemType === 'Equipment' || itemType === 'equipment'){
                        $('#equipmentStar').show();
                        $('#equipmentLabelName').show();
                        $('#equipment_name').show();

                        $('#item_name').hide();
                        $('#star').hide();
                        $('#labelName').hide();

                    }else {
                        $('#item_name').hide();
                        $('#star').hide();
                        $('#labelName').hide();

                        $('#equipmentStar').hide();
                        $('#equipmentLabelName').hide();
                        $('#equipment_name').hide();
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert("Error fetching data. See console for details.");
                }
            });
        }
        
    }

    // update button 
    function update(typeTitles, treeTitles,id) {
        $('#updateRequestButton').on('click', function(e) {
            e.preventDefault(); 
            var selectedType = $('#item_type').val();
            var selectedName = $('#item_name').val();
            var selectedEquipmentName = $('#equipment_name').val();
            var status= document.getElementById("status").value;

            // console.log('Selected Type: ' + selectedType + ' Selected Name: ' + selectedName + selectedEquipmentName);
            // console.log("ID:", id);
            const formData = new FormData();
            formData.append('request_id',id);
            formData.append('requestor_name', $('#requestor_name').val());
            formData.append('organization', $('#organization').val());
            formData.append('phone_number', $('#phone_number').val());
            formData.append('email_address', $('#email_address').val());
            formData.append('address', $('#address').val());
            formData.append('quantity_needed', $('#quantity_needed').val());
            formData.append('item_description', $('#item_description').val());
            formData.append('purpose', $('#purpose').val());
            formData.append('delivery_date', $('#delivery_date').val());
            formData.append('delivery_time', $('#delivery_time').val());
            formData.append('delivery_address', $('#delivery_address').val());
            formData.append('special_instructions', $('#special_instructions').val());
            formData.append('letter_of_intent', $('#Li-yes-no').val());
            formData.append('project_eng_certification', $('#Cpe-yes-no').val());
            formData.append('budget_officer_certification', $('#Cbo-yes-no').val());
            formData.append('item_type', $('#item_type').val());

            if(selectedEquipmentName!=''){
                formData.append('item_name', $('#equipment_name').val());
            }else{
                formData.append('item_name', $('#item_name').val());
            }
            
            if(status=='Pending for Approval'){
                //Updating  records
                $.ajax({
                    url: '/Request/update-request.php',
                    type: 'POST',
                    processData: false, 
                    contentType: false, 
                    data: formData, 
                    success: function(response){
                        Swal.fire('Record Updated Successfully!').then((result) => {
                        //    console.log(response);
                        getRecordById();
                        });
                    },
                    error: function(xhr, status, error){
                        console.error('Error: ' + xhr.responseText);
                        alert('There was an error submitting the form.');
                    }
                });
                // for (let pair of formData.entries()) {
                //     console.log(pair[0] + ': ' + pair[1]);
                // } 
            }else{
               
                Swal.fire({
                    title: `Status: ${status}`,
                    text: "Sorry, this record cannot be updated as it has already been approved.",
                    icon: "warning"
                });
            }
                
        }); 

    }

    //update button manual
    $('#updateRequestButton').on('click', function(e) {
        e.preventDefault();
        var status2= document.getElementById("status").value;

        if(status2=='Pending for Approval'){
            insertFile(id);
        }else{
            alert('Need Admin approval for updating files');
        }
        
       
    }); 

    //insert Files
    function insertFile(id){
        var formData = new FormData();
        formData.append('request_id',id);
        var request_id = id;
            let fileDocument = $('#supporting_documents')[0].files;
            for (let i = 0; i < fileDocument.length; i++) {
                formData.append('supporting_documents[]', fileDocument[i]);
            }
        //Inserting file
        $.ajax({
            url: '/Request/insert-file.php',
            type: 'POST',
            processData: false, 
            contentType: false, 
            data: formData, 
            success: function(response){
               fetchFiles(id);
            },
            error: function(xhr, status, error){
                console.error('Error: ' + xhr.responseText);
                alert('There was an error submitting the form.');
            }
        });
    }

    // fetch files
    function fetchFiles(id) {
        $.ajax({
            url: '/Request/fetch-files.php', 
            type: 'POST',
            data: { request_id: id },
            dataType: 'json',
            success: function(response) {
                //console.log("files:", response);
                if (response.status === 'success') {
                    var files = response.files;
                    var fileList = $('#file-list');
                    fileList.empty(); // Clear any existing file list
                    if (files.length > 0) {
                        files.forEach(function(file) {
                            console.log(file.id);
                            var fileItem = `
                                <div class="file-item" style="display: flex; align-items: center;">
                                    <a href="${file.file_path}" download="${file.file_name}">
                                        <i class="fas fa-download"></i> ${file.file_name}
                                    </a>
                                    <button data-id="${file.id}" class="buttonTrash" style="background-color:white;color:gray">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            `;
                            fileList.append(fileItem);
                        });

                        // Delete file logic
                        fileList.on('click', '.buttonTrash', function(event) {
                            event.preventDefault(); // Prevent default action
                            var fileId = $(this).data('id'); // Get the data-id attribute
                            console.log('here',fileId);
                            // Confirm deletion
                            if (confirm('Are you sure you want to delete this file?')) {
                                $.ajax({
                                    url: '/Request/delete-file.php', // Your delete file script
                                    type: 'POST',
                                    data: { request_id: fileId },
                                    dataType: 'json',
                                    success: function(deleteResponse) {
                                        if (deleteResponse.status === 'success') {
                                            console.log('File deleted successfully.');
                                            // Optionally, remove the file item from the list
                                            $(event.target).closest('.file-item').remove();
                                        } else {
                                            alert(deleteResponse.message);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        console.log(xhr.messageText);
                                        alert('Error deleting file.');
                                    }
                                });
                            }
                        });

                    } else {
                        fileList.html('<p>No files uploaded.</p>');
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr.messageText);
                alert('Error fetching files.');
            }
        });
    }


    

    </script>
    <?php
    // PHP code here
    ?>
</body>
</html>
