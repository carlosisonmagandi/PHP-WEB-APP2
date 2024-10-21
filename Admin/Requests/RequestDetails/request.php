<?php
session_start();
require("../../../includes/session.php");
require("../../../includes/darkmode.php");
require("../../../includes/authentication.php");

if (isset($_POST['Logout'])) {
    session_destroy();
    header("Location: ../../index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Request</title>
    <link rel="stylesheet" type="text/css" href="/Styles/breadCrumbs.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        * {
        box-sizing: border-box;
        }
        body{
            margin:0;
            padding:20px;
            font-size:12px;
            font-family: 'Roboto', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

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
            
        }
       
       

        .flex-item-right {
        padding: 2px;
        flex: 70%;
        height:100vh;
        overflow-y: auto;
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


<!-- Prefixfree -->
<script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript"></script>


<br>
<div class="container">
    <?php if ($_SESSION['mode'] == 'light'): ?>
        <div class="breadcrumb flat">
            <a href="/Admin/monitor-item-trees.php">Request</a>
            <a href="#">Request Details</a>
        </div>
        
    <?php else: ?>
        <div class="breadcrumb">
            <a href="/Admin/monitor-item-trees.php">Request</a>
            <a href="#">Request Details</a>
        
        </div>
    <?php endif; ?>
</div>

<div class="flex-container">
   
    <div class="flex-item-right">
        <form action="" method="post" enctype="multipart/form-data" id="myRequestForm">
            <div class="flex-item-status">
                <div class="flex-item-status-left">
                    <strong>Status:</strong>
                </div>
                <div class="flex-item-status-right">
                    <input type="text" id="status" name="status" disabled  style="font-style:italic" >  
                </div>
                
            </div>

            <div class="form-container">    
                <!-- Requestor Information -->
                <div class="form-column">
                    <fieldset>
                        <legend>Requstee Information</legend>
                        <div class="form-group">
                            <label for="requestor_name">Requestee</label>
                            <input type="text" id="requestor_name" name="requestor_name" disabled >
                        </div>
                        <div class="form-group">
                            <label for="organization">Organization/Office </label>
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
                                        <label for="item_type">Type of Species</label>
                                        <input type="text" id="item_type" name="item_type" disabled >
                                    </div>
                                </td>

                                <td>
                                    <div class="form-group" id="itemNameDiv" style="display:block">
                                        <label style="margin-left:50px;" for="item_name">Species</label>
                                        <input type="text" style="margin-left:50px;" id="item_name" name="item_name" disabled >
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
                <!-- <div class="form-group">
                    <label for="supporting_documents">Supporting Documents <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Option to upload any supporting documents (e.g., proof of need, project plans, photos).</span></span></label>
                    <input type="file" id="supporting_documents" name="supporting_documents">
                </div> -->
                <p>Supporting documents:</p>
                <div id="file-list"></div>
                <br>
                <p><i>Press ctrl key + click to view the file or Click only to download the file.</i></p>
                
                <!-- <div class="form-group">
                    <label for="signature"><i class="star" >*</i> Signature <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">(Can be a soft copy of signature, image,screenshot)</span></span></label>
                    <input type="text" id="signature" name="signature" >
                </div> -->
            </fieldset>
        </form>
    </div>
</div>

<script>
$(document).ready(function() {

    
    // Fetch data from the database
    fetchDataFromDB();

    function fetchDataFromDB() {
        var urlParams = new URLSearchParams(window.location.search);
        var requestId = urlParams.get('id'); 
        if (requestId) {
            $.ajax({
                url: '/Admin/Requests/RequestDetails/get-record.php', 
                type: 'GET',
                data: { id: requestId },
                dataType: 'json',
                success: function(response) {
                    var data = response[0];
                    $('#requestor_name').val(data.requestor_name);
                    $('#organization').val(data.organization_name);
                    $('#phone_number').val(data.phone_number);
                    $('#email_address').val(data.email);
                    $('#address').val(data.address);
                    $('#item_type').val(data.type_of_requested_item);
                    $('#quantity_needed').val(data.quantity);
                    $('#item_description').val(data.request_description);
                    $('#purpose').val(data.purpose_of_donation);
                    $('#delivery_date').val(data.preferred_delivery_date);
                    $('#delivery_time').val(data.preferred_delivery_time);
                    $('#delivery_address').val(data.delivery_address);
                    $('#special_instructions').val(data.special_instructions);
                    $('#letterOfIntent').val(data.letter_of_intent);
                    $('#certificationByTheProjEng').val(data.project_eng_certification);
                    $('#certificationByBudgetOfficer').val(data.budget_officer_certification);
                    $('#status').val(data.approval_status);
                    $('#item_name').val(data.name_of_requested_item);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert("Error fetching data. See console for details.");
                }
            });
        } else {
            console.error("No valid request ID found in the URL.");
            alert("Invalid request ID.");
        }
    }

    fetchFiles();
    // Fetch files
    function fetchFiles() {
        var urlParams = new URLSearchParams(window.location.search);
        var requestId = urlParams.get('id'); 
        
        $.ajax({
            url: '/Admin/Requests/RequestDetails/fetch-files.php',
            type: 'POST',
            data: { request_id: requestId },
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
                                    <a href="/Request/${file.file_path}" download="${file.file_name}">
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

</body>
</html>
