<?php
session_start();
require("../includes/session.php");
require("../includes/darkmode.php");
require("../includes/authentication.php");

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
            background-color: #bfbfbf;
            border: none !important;
            flex: 50%;
           
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
        }
        .request-header{
            background-color:#335b99;
            color:white;
            padding:3px;
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

<!-- Prefixfree -->
<script src="http://thecodeplayer.com/uploads/js/prefixfree-1.0.7.js" type="text/javascript"></script>


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
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->
        <div class="request-box">
            <div class="request-header">REQ01234567</div>
            <div class="request-details">
                <span style="font-size:14px"><strong>Requestor Name</strong></span><br>
                <span>Requested Trees</span>
            </div>
            <div class="request-footer">
               <i> 09-14-2024</i>
            </div>
        </div>
        <!-- ------------------------------------------------------------------------ -->

    </div>
    <div class="flex-item-right">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="flex-item-status">
                <div class="flex-item-status-left">
                    <strong>Status:</strong>
                </div>
                <div class="flex-item-status-right">
                    <input type="text" id="status" name="status" disabled value="Pending for approval" style="font-style:italic" >
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
                        <div class="form-group">
                            <label for="item_type">Type of Item Requested </label>
                            <input type="text" id="item_type" name="item_type" disabled >
                        </div>
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
                        <legend>Additional Information</legend>
                        <div class="form-group">
                            <label for="reason">Reason for Request </label>
                            <textarea id="reason" name="reason"disabled ></textarea>
                        </div>
                        <div class="form-group">
                            <label for="previous_donations">Previous Donations</label>
                            <textarea id="previous_donations" name="previous_donations" disabled></textarea>
                        </div>
                        <div class="form-group">
                            <label for="additional_comments">Additional Comments </label>
                            <textarea id="additional_comments" name="additional_comments" disabled></textarea>
                        </div>
                    </fieldset>
                </div>
            </div>
            

            <!-- Verification -->
            <fieldset>
                <legend>Attachments</legend>
                <div class="form-group">
                    <label for="supporting_documents">Supporting Documents <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Option to upload any supporting documents (e.g., proof of need, project plans, photos).</span></span></label>
                    <input type="file" id="supporting_documents" name="supporting_documents">
                </div>
                <div class="form-group">
                    <label for="signature"><i class="star" >*</i> Signature <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">(Can be a soft copy of signature, image,screenshot)</span></span></label>
                    <input type="text" id="signature" name="signature" >
                </div>
        
            </fieldset>
            
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#createNew').on('click', function() {
            
            window.location.href="/Request/requestForm.php";
        }); 
    });
</script>
<?php 
include("../templates/nav-bar2.php");
?>
</body>
</html>
