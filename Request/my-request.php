<?php
session_start();
ob_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");  
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Request</title>
    <link rel="stylesheet" type="text/css" href="/Styles/breadCrumbs.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Prefixfree -->
    <script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript"></script>
    <style>
        * {
        box-sizing: border-box;
        }
        body{margin:0}
        .flex-container {
        display: flex;
        flex-direction: row;
        font-size: 12px;
        margin:10px;
        }
        .flex-item-status{
            background-color: #f1f1f1;
            padding: 10px;
            display:flex;
            margin-left:10px;
            margin-right:10px;
        }
        .flex-item-status-left{
            /* background-color: #335b99; */
            background-color:#f1f1f1;
            flex: 50%;
            color:#333;
          
        }
        .flex-item-status-right{
            /* background-color: #bfbfbf; */
            border: none !important;
            flex: 20%;
            margin-right:5%;
        }
        .btnCancelRequest{
            font-size:12px;
            padding: 4px;
        }
        .btnCancelRequest:hover{
            background-color: #bfbfbf;
        }
       .flex-item-cancel-button{
        background-color: #bfbfbf;
        border: none !important;
        flex: 7%;
       }
        .flex-item-left {
        /* background-color: #f1f1f1; */
        padding: 2px;
        height:100vh;
        flex: 30%;
        overflow-y: auto;
        }
        .flex-item-right {
        padding: 2px;
        flex: 70%;
        height:100vh;
        overflow-y: auto;
        }
        #createNew{
            font-size:12px;
            margin-left:10px;
        }
        /* Responsive layout - makes a one column-layout instead of two-column layout */
        @media (max-width: 800px) {
        .flex-container {
            flex-direction: column;  
        }
        }
        /* Request  */
        .request-box{
            border:1px solid #002f6c;
            margin-bottom:10px;
            cursor:pointer;
        }
        .request-box:hover {
            transform: scale(1.01); 
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); 
        }
        .request-header{
            background-color:#335b99;
            color:white;
            padding:3px;  
        }
        .requestEditIcon{
            background-color:#335b99;
            color:white;
            border:none;
            z-index:999;
            float:right;
        }
        .request-details{
            background-color:#fff;
            color:#333;
            padding:8px;
            /* height:80px; */   
        }
        .request-footer{
            background-color:#f1f1f1;
            color:#333;
            padding:3px;
            text-align:right;
            padding-right:12px;
        
        }
        /* --------------------------------------------------------------------------- */
        /* Request form */
        .form-group {
            margin-bottom: 15px !important;
        }
        label {
            display: block !important;
            margin-bottom: 5px !important;
        }
        input, textarea, select {
            width: 100% !important;
            padding: 4px !important;
            box-sizing: border-box !important;
        }
        .checkbox-group {
            display: flex !important;
            align-items: center !important;
        }
        .checkbox-group input {
            width: auto !important;
            margin-right: 10px !important;
        }
        /* Responsive Flex Layout */
        .form-container {
            display: flex !important;
            flex-wrap: wrap !important;
            /* gap: 12px !important; */
        }
        .form-column {
            flex: 1 !important;
            min-width: 300px !important;    
        }
        fieldset {
            background-color:white;
            padding: 25px !important;
            margin: 15px !important;
            border-width: 1px !important;
            /* border-style: solid   !important; */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1) !important;
        }
        span {
            color: #666 !important;
        }
        </style>
</head>
<body>
    <?php 
    include("../templates/nav-bar.php");
    ?>
    <br>
    <div class="container">
        <?php if ($_SESSION['mode'] == 'light'): ?>
            <div class="breadcrumb flat">
                <a href="#">Request</a>
                <a href="/Request/my-request.php">My request</a> 
            </div>
        <?php else: ?>
            <div class="breadcrumb">
                <a href="#">Request</a>
                <a href="/Request/my-request.php">My request</a>
            </div>
        <?php endif; ?>
    </div>
    <button class="btn btn-primary" id="createNew"  >Create New Request</button>
    <div class="flex-container">
        <div class="flex-item-left">
            <div>FILTER DIV</div>
            <!-- ----------------------------------------------------------------------- -->
            <div class="flex-item-left">
                <div>FILTER DIV</div>
                <!-- Request boxes will be dynamically inserted here by AJAX -->
            </div>
        </div>
        <div class="flex-item-right">
            <form action="" method="post" enctype="multipart/form-data" id="myRequestForm">
                <div class="flex-item-status">
                    <div class="flex-item-status-left">
                        <strong>Status:</strong>
                    </div>
                    <div class="flex-item-status-right">
                        <input type="text" id="status" name="status" disabled  style="font-style:italic" >  
                    </div>
                    <div class="flex-item-cancel-button" id="cancelRequestButtonDiv" style="display:none;">
                    <button id="cancelRequestButton" class="btnCancelRequest"  >
                        <i class="fas fa-ban"></i> Cancel Request
                    </button>
                    </div>
                </div>
            
                <div class="form-container">    
                    <!-- Requestor Information -->
                    <div class="form-column">
                        <fieldset>
                            <legend>Requestor Information</legend>
                            <div class="form-group">
                                <label for="requestor_name"> Requestor Name</label>
                                <input type="text" id="requestor_name" name="requestor_name" disabled >
                            </div>
                            <div class="form-group">
                                <label for="organization">Organization </label>
                                <input type="text" id="organization" name="organization" disabled>
                            </div>
                            <div class="form-group">
                                <label> Contact Information</label>
                                <input type="tel" id="phone_number" name="phone_number" placeholder="Phone Number" disabled >
                                <input type="email" id="email_address" name="email_address" placeholder="Email Address" disabled >
                            </div>
                            <div class="form-group">
                                <label for="address">Address </label>
                                <input type="text" id="address" name="address" disabled>
                            </div>
                        </fieldset>
                    </div>
                    <!-- Donation Request Details -->
                    <div class="form-column">
                        <fieldset>
                            <legend>Donation Request Details</legend>
                            <table>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="item_type">Type of Item Requested </label>
                                            <input type="text" id="item_type" name="item_type" disabled >
                                        </div>
                                    </td>

                                    <td>
                                        <div class="form-group" id="itemNameDiv" style="display:block">
                                            <label style="margin-left:10px" for="item_name">Species</label>
                                            <input style="margin-left:10px" type="text" id="item_name" name="item_name" disabled >
                                        </div>
                                    </td>
                                </tr>
                            </table>      
                            <div class="form-group">
                                <label for="quantity_needed">Quantity Needed </label>
                                <input type="number" id="quantity_needed" name="quantity_needed" disabled>
                            </div>
                            <div class="form-group">
                                <label for="item_description">Description of Items Requested </label>
                                <textarea id="item_description" name="item_description" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label for="purpose">Purpose of Donation </label>
                                <textarea id="purpose" name="purpose" disabled></textarea>
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
                                <label for="delivery_date">Preferred Delivery Date </label>
                                <input type="text" id="delivery_date" name="delivery_date" disabled>
                            </div>
                            <div class="form-group">
                                <label for="delivery_time">Preferred Delivery Time </label>
                                <input type="text" id="delivery_time" name="delivery_time" disabled>
                            </div>
                            <div class="form-group">
                                <label for="delivery_address">Delivery Address </label>
                                <input type="text" id="delivery_address" name="delivery_address" disabled>
                            </div>
                            <div class="form-group">
                                <label for="special_instructions">Special Instructions </label>
                                <textarea id="special_instructions" name="special_instructions" disabled></textarea>
                            </div>
                        </fieldset>
                    </div>
                    <!-- Additional Information -->
                    <div class="form-column">
                        <fieldset>
                            <legend>Document submitted</legend>
                            <div class="form-group">
                                <label for="letterOfIntent">Letter of intent</label>
                                <textarea id="letterOfIntent" name="letterOfIntent"disabled ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="certificationByTheProjEng">Certification by the project engineer</label>
                                <textarea id="certificationByTheProjEng" name="certificationByTheProjEng" disabled></textarea>
                            </div>
                            <div class="form-group">
                                <label for="certificationByBudgetOfficer">Certification by the budget officer</label>
                                <textarea id="certificationByBudgetOfficer" name="certificationByBudgetOfficer" disabled></textarea>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- Verification -->
                <fieldset>
                    <legend>Attachments</legend>
                    <p>Supporting documents:</p>
                    <div id="file-list"></div>
                    <br>
                    <p><i>Press ctrl key + click to view the file or Click only to download the file.</i></p>
                </fieldset>
            </form>
        </div>
    </div>
    <script>
    $(document).ready(function() {

        $('#createNew').on('click', function() {
            window.location.href = "/Request/requestForm.php";
        });
        $('.flex-item-left').on('click', '.request-box', function() {
            var id = $(this).data('id');
        
            fetchDataById(id);
            fetchFiles(id);
        });
        $('.flex-item-left').on('click', '.requestEditIcon', function() {
            var id = $(this).data('id');
            // construct session values
            // sessionStorage.setItem('equipment_type', data.data.equipment_type );

            // Construct query string with data
            let queryString = id;
            // Redirect with query parameters
            window.location.href = '/Request/requestForm.php?' + queryString;
        });
        // Logic for showing the cancel button
        const statusField = $('#status');
        const cancelButtonDiv = $('#cancelRequestButtonDiv');

        function toggleCancelButton() {
            if (statusField.val().trim() !== "") {
                cancelButtonDiv.show();
            } else {
                cancelButtonDiv.hide();
            }
        }
        // Initial check to see if the status has a value
        toggleCancelButton();
        // Listen for changes in the status input
        statusField.on('input', toggleCancelButton);
        // Fetch data from the database
        fetchDataFromDB();
        
        function fetchDataFromDB() {
            $.ajax({
                url: '/Request/get-record.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                
                    $('.flex-item-left').html('<div>FILTER DIV</div>');

                    response.forEach(function(record) {
                        
                        // sessionStorage.setItem('equipment_type', record.letter_of_intent );
                        var requestBox = `
                            <div class="request-box" data-id="${record.id}">
                                <div class="request-header">
                                    ${record.request_number}
                                    <button class="requestEditIcon" id="requestEditIcon" data-id=${record.id}>
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <div class="request-details">
                                    <span style="font-size:14px">Requestee: <strong>${record.requestor_name}</strong></span><br>
                                    <span>Requesting for: <strong>${record.type_of_requested_item}</strong></span>
                                </div>
                                <div class="request-footer">
                                    <i>${record.created_on}</i>
                                </div>
                            </div>
                        `;
                        $('.flex-item-left').append(requestBox);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert("Error fetching data. See console for details.");
                }
            });
        }
        function fetchDataById(id) {
            $.ajax({
                url: '/Request/get-record-by-id.php',
                type: 'GET',
                data: { requestId: id },
                dataType: 'json',
                success: function(response) {
                    sessionStorage.setItem('type_of_requested_item', response.type_of_requested_item );
                    sessionStorage.setItem('letter_of_intent', response.letter_of_intent );
                    sessionStorage.setItem('project_eng_certification', response.project_eng_certification );
                    sessionStorage.setItem('budget_officer_certification', response.budget_officer_certification );
                    // Populate fields with response data
                    $('#requestor_name').val(response.requestor_name);
                    $('#organization').val(response.organization_name);
                    $('#phone_number').val(response.phone_number);
                    $('#email_address').val(response.email);
                    $('#address').val(response.address);
                    $('#item_type').val(response.type_of_requested_item);
                    $('#quantity_needed').val(response.quantity);
                    $('#item_description').val(response.request_description);
                    $('#purpose').val(response.purpose_of_donation);
                    $('#delivery_date').val(response.preferred_delivery_date);
                    $('#delivery_time').val(response.preferred_delivery_time);
                    $('#delivery_address').val(response.delivery_address);
                    $('#special_instructions').val(response.special_instructions);
                    $('#letterOfIntent').val(response.letter_of_intent);
                    $('#certificationByTheProjEng').val(response.project_eng_certification);
                    $('#certificationByBudgetOfficer').val(response.budget_officer_certification);
                    $('#status').val(response.approval_status);
                    $('#item_name').val(response.name_of_requested_item);

                    // // Show/hide item name div based on type of requested item
                    // if (response.type_of_requested_item === 'trees' || 
                    //     response.type_of_requested_item === 'Trees' || 
                    //     response.type_of_requested_item === 'equipment' || 
                    //     response.type_of_requested_item === 'Equipment') {
                    //     $('#itemNameDiv').show();
                    // } else {
                    //     $('#itemNameDiv').hide();
                    // }

                    // Show cancel button based on status value
                    toggleCancelButton();
                    // Cancel request logic
                    $('#cancelRequestButton').on('click', function(e) {
                        e.preventDefault();
                        let requestId = response.id;
                        Swal.fire({
                            title: "Are you sure you want to cancel this request?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, delete it!",
                            cancelButtonText: "No, keep it",
                            didRender: () => {
                                $('.swal2-checkbox').remove();
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: '/Request/delete-request.php',
                                    type: 'POST',
                                    data: JSON.stringify({ id: requestId }),
                                    success: function(response) {
                                        $('#myRequestForm')[0].reset();
                                        toggleCancelButton(); 
                                        fetchDataFromDB();
                                        Swal.fire({
                                            title: "Request deleted successfully!",
                                            icon: "success",
                                            didRender: () => {
                                                $('.swal2-checkbox').remove();
                                            }
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire('Error!', 'There was an error deleting the request.', 'error');
                                    }
                                });
                            }
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert("Error fetching data. See console for details.");
                }
            });
        }
        // Fetch files
        function fetchFiles(id) {
            $.ajax({
                url: '/Request/fetch-files.php',
                type: 'POST',
                data: { request_id: id },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        var files = response.files;
                        var fileList = $('#file-list');
                        fileList.empty();
                        if (files.length > 0) {
                            files.forEach(function(file) {
                                var fileItem = `
                                    <div class="file-item">
                                        <a href="${file.file_path}" download="${file.file_name}">
                                            <i class="fas fa-download"></i> ${file.file_name}
                                        </a>
                                    </div>
                                `;
                                var $fileItem = $(fileItem);
                                $fileItem.find('a').on('click', function(e) {
                                    if (e.ctrlKey) {
                                        $(this).attr('target', '_blank');
                                        $(this).removeAttr('download');
                                    } else {
                                        $(this).attr('download', file.file_name);
                                    }
                                });
                                fileList.append($fileItem);
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
    });
    </script>

    <?php 
    include("../templates/nav-bar2.php");
    ?>
</body>
</html>
