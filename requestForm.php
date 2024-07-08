<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Request Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
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
    
    <form action="" method="post" enctype="multipart/form-data">
        <h3>Donation Request Form</h3>
        <div class="form-container">    
            <!-- Requestor Information -->
            <div class="form-column">
                <fieldset>
                    <legend>Requestor Information</legend>
                    <div class="form-group">
                        <label for="requestor_name"><i class="star" >*</i> Requestor Name <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Full name of the requestor.</span></span></label>
                        <input type="text" id="requestor_name" name="requestor_name" required>
                    </div>
                    <div class="form-group">
                        <label for="organization">Organization (if applicable) <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext"> Name of the organization making the request.</span></span></label>
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
                        <label for="item_type"><i class="star" >*</i> Type of Item Requested <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Type of item needed (e.g., logs, trees,coals etc..).</span></span></label>
                        <input type="text" id="item_type" name="item_type" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity_needed"><i class="star" >*</i> Quantity Needed <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext"> Number of items needed.</span></span></label>
                        <input type="number" id="quantity_needed" name="quantity_needed" required>
                    </div>
                    <div class="form-group">
                        <label for="item_description"><i class="star" >*</i> Description of Items Requested <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Detailed description of the logs or trees (e.g., type of wood, size, condition, species of trees, age)</span></span></label>
                        <textarea id="item_description" name="item_description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="purpose"><i class="star" >*</i> Purpose of Donation <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Explanation of how the donated items will be used (e.g., community project, reforestation, firewood).</span></span></label>
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
                        <label for="delivery_date"><i class="star" >*</i> Preferred Delivery Date <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Date when the requestor needs the items to be delivered.</span></span></label>
                        <input type="date" id="delivery_date" name="delivery_date" required>
                    </div>
                    <div class="form-group">
                        <label for="delivery_time"><i class="star" >*</i> Preferred Delivery Time <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Time slot for delivery.</span></span></label>
                        <input type="time" id="delivery_time" name="delivery_time" required>
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
            <div class="form-column">
                <fieldset>
                    <legend>Additional Information</legend>
                    <div class="form-group">
                        <label for="reason"><i class="star" >*</i> Reason for Request <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Explanation of why the donation is needed.</span></span></label>
                        <textarea id="reason" name="reason" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="previous_donations">Previous Donations <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Information about any previous donations received and how they were used.</span></span></label>
                        <textarea id="previous_donations" name="previous_donations"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="additional_comments">Additional Comments <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Any additional information or comments from the requestor.</span></span></label>
                        <textarea id="additional_comments" name="additional_comments"></textarea>
                    </div>
                </fieldset>
            </div>
        </div>
        

        <!-- Acknowledgment and Consent -->
        <fieldset>
            <legend>Acknowledgment and Consent</legend>
            <div class="form-group checkbox-group">
                <input type="checkbox" id="terms_conditions" name="terms_conditions" required>
                <label for="terms_conditions"><i class="star" >*</i> I agree to the terms and conditions <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Checkbox or signature field for the requestor's agreement</span></span></label>
            </div>
            <div class="form-group checkbox-group">
                <input type="checkbox" id="consent_contact" name="consent_contact" required>
                <label for="consent_contact"><i class="star" >*</i> I consent to being contacted by potential donors <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Checkbox for the requestor to consent to being contacted by potential donors.</span></span></label>
            </div>
        </fieldset>

        <!-- Verification -->
        <fieldset>
            <legend>Verification</legend>
            <div class="form-group">
                <label for="supporting_documents">Supporting Documents <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">Option to upload any supporting documents (e.g., proof of need, project plans, photos).</span></span></label>
                <input type="file" id="supporting_documents" name="supporting_documents">
            </div>
            <div class="form-group">
                <label for="signature"><i class="star" >*</i> Signature <span class="tooltip"><i class="fas fa-question-circle"></i><span class="tooltiptext">(Can be a soft copy of signature, image,screenshot)</span></span></label>
                <input type="text" id="signature" name="signature" required>
            </div>
            <button type="submit" name="submit" href="/Pages/admin/dashboard.php">Submit Request</button> <a class="cancelButton" href="/Pages/admin/dashboard.php">Cancel</a>
        </fieldset>
        
    </form>

    <?php
    // PHP code here
    ?>
</body>
</html>
